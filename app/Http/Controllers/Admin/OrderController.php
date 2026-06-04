<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.product')->latest();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('items', function ($itemQuery) use ($search) {
                      $itemQuery->whereHas('product', function ($prodQuery) use ($search) {
                          $prodQuery->where('title', 'like', "%{$search}%");
                      });
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(20)->withQueryString();

        // Stats
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        // Product-based order summary
        $productSummary = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereNotIn('orders.status', ['cancelled'])
            ->select(
                'products.id as product_id',
                'products.title as product_name',
                'products.slug as product_slug',
                DB::raw('COUNT(DISTINCT orders.id) as order_count'),
                DB::raw('SUM(order_items.quantity) as total_qty')
            )
            ->groupBy('products.id', 'products.title', 'products.slug')
            ->orderByDesc('order_count')
            ->get();

        return view('admin.orders.index', compact('orders', 'stats', 'productSummary'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('title')->get();
        return view('admin.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_pincode' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,online,bank_transfer,other',
            'payment_status' => 'required|in:pending,paid',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'nullable|string|max:50',
            'shipping_charge' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->selling_price;
                $qty = $item['quantity'];
                $itemSubtotal = $price * $qty;
                $subtotal += $itemSubtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'product_sku' => $product->sku ?? '',
                    'price' => $price,
                    'quantity' => $qty,
                    'size' => $item['size'] ?? null,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $shippingCharge = $request->shipping_charge ?? 0;
            $discount = $request->discount ?? 0;
            $total = $subtotal + $shippingCharge - $discount;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'status' => 'processing',
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_pincode' => $request->shipping_pincode,
                'subtotal' => $subtotal,
                'shipping_charge' => $shippingCharge,
                'discount' => $discount,
                'total' => $total,
                'notes' => $request->notes,
            ]);

            foreach ($itemsData as $itemData) {
                $order->items()->create($itemData);
            }

            DB::commit();

            // Send confirmation email
            if ($request->payment_status === 'paid') {
                try {
                    $order->load('items');
                    $adminEmail = setting('admin_order_email', 'rakshadivine@gmail.com');
                    Mail::to($order->customer_email)
                        ->cc($adminEmail)
                        ->send(new OrderConfirmation($order));
                } catch (\Exception $e) {
                    \Log::error('Admin create order - email failed: ' . $e->getMessage());
                }
            }

            return redirect()->route('admin.orders.show', $order)
                ->with('success', "Order #{$order->order_number} created successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Send status update email to customer and admin
        if ($oldStatus !== $request->status) {
            try {
                $order->load('items');
                $adminEmail = setting('admin_order_email', 'rakshadivine@gmail.com');
                Mail::to($order->customer_email)
                    ->cc($adminEmail)
                    ->send(new OrderStatusUpdated($order, $oldStatus));
            } catch (\Exception $e) {
                \Log::error('Order status email failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated to ' . ucfirst($request->payment_status));
    }

    public function updateShipping(Request $request, Order $order)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_pincode' => 'required|string|max:10',
        ]);

        $order->update($validated);

        return back()->with('success', 'Shipping address updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    public function exportCsv(Request $request)
    {
        $query = Order::with('items.product')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Order #', 'Date', 'Customer Name', 'Email', 'Phone',
                'Shipping Address', 'City', 'State', 'Pincode',
                'Items', 'Subtotal', 'Shipping', 'Coupon Code', 'Coupon Discount', 'Total',
                'Payment Method', 'Payment Status', 'Order Status', 'Transaction ID',
            ]);

            foreach ($orders as $order) {
                $itemsList = $order->items->map(function ($item) {
                    return $item->product_title . ' x' . $item->quantity;
                })->implode('; ');

                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->shipping_address,
                    $order->shipping_city,
                    $order->shipping_state,
                    $order->shipping_pincode,
                    $itemsList,
                    $order->subtotal,
                    $order->shipping_charge,
                    $order->coupon_code ?? '',
                    $order->coupon_discount,
                    $order->total,
                    ucfirst($order->payment_method),
                    ucfirst($order->payment_status),
                    ucfirst($order->status),
                    $order->transaction_id ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
