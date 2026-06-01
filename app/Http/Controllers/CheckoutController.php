<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'subtotal' => $product->selling_price * $item['quantity'],
                ];
                $subtotal += $product->selling_price * $item['quantity'];
            }
        }

        $freeThreshold = (float) setting('shipping_free_threshold', 999);
        $shippingCost = (float) setting('shipping_cost', 99);
        $shipping = $subtotal >= $freeThreshold ? 0 : $shippingCost;

        // Coupon discount
        $coupon = session()->get('coupon');
        $couponDiscount = 0;
        if ($coupon) {
            $couponModel = \App\Models\Coupon::find($coupon['id']);
            if ($couponModel) {
                $validation = $couponModel->isValid($subtotal, Auth::id());
                if ($validation['valid']) {
                    $couponDiscount = $couponModel->calculateDiscount($subtotal);
                    session()->put('coupon.discount', $couponDiscount);
                } else {
                    session()->forget('coupon');
                    $coupon = null;
                }
            } else {
                session()->forget('coupon');
                $coupon = null;
            }
        }

        $total = $subtotal + $shipping - $couponDiscount;

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'user', 'coupon', 'couponDiscount'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_pincode' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,online',
        ]);

        // Calculate totals and validate stock
        $subtotal = 0;
        $items = [];
        $stockErrors = [];

        foreach ($cart as $id => $cartItem) {
            $product = Product::with('stocks')->find($id);
            if ($product) {
                $totalStock = $product->stocks->sum('quantity');

                if ($totalStock <= 0) {
                    $stockErrors[] = "'{$product->title}' is out of stock.";
                    continue;
                }

                if ($cartItem['quantity'] > $totalStock) {
                    $stockErrors[] = "'{$product->title}' only has {$totalStock} in stock (you requested {$cartItem['quantity']}).";
                    continue;
                }

                $itemSubtotal = $product->selling_price * $cartItem['quantity'];
                $subtotal += $itemSubtotal;
                $items[] = [
                    'product' => $product,
                    'quantity' => $cartItem['quantity'],
                    'size' => $cartItem['size'] ?? null,
                    'subtotal' => $itemSubtotal,
                ];
            }
        }

        if (!empty($stockErrors)) {
            $errorMsg = implode(' ', $stockErrors);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 422);
            }
            return back()->withErrors(['stock' => $errorMsg]);
        }

        $freeThreshold = (float) setting('shipping_free_threshold', 999);
        $shippingCost = (float) setting('shipping_cost', 99);
        $shipping = $subtotal >= $freeThreshold ? 0 : $shippingCost;

        // Handle coupon
        $couponSession = session()->get('coupon');
        $couponDiscount = 0;
        $couponCode = null;
        $couponModel = null;

        if ($couponSession) {
            $couponModel = \App\Models\Coupon::find($couponSession['id']);
            if ($couponModel) {
                $validation = $couponModel->isValid($subtotal, Auth::id(), $request->customer_email);
                if ($validation['valid']) {
                    $couponDiscount = $couponModel->calculateDiscount($subtotal);
                    $couponCode = $couponModel->code;
                } else {
                    session()->forget('coupon');
                }
            }
        }

        $total = $subtotal + $shipping - $couponDiscount;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'status' => 'pending',
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_pincode' => $request->shipping_pincode,
            'shipping_country' => 'India',
            'billing_address' => $request->billing_address ?? $request->shipping_address,
            'billing_city' => $request->billing_city ?? $request->shipping_city,
            'billing_state' => $request->billing_state ?? $request->shipping_state,
            'billing_pincode' => $request->billing_pincode ?? $request->shipping_pincode,
            'subtotal' => $subtotal,
            'shipping_charge' => $shipping,
            'discount' => $couponDiscount,
            'coupon_code' => $couponCode,
            'coupon_discount' => $couponDiscount,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // Record coupon usage
        if ($couponModel && $couponDiscount > 0) {
            \App\Models\CouponUsage::create([
                'coupon_id' => $couponModel->id,
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'customer_email' => $request->customer_email,
                'discount_amount' => $couponDiscount,
            ]);
            $couponModel->increment('times_used');
        }

        // Create order items and decrement stock
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_title' => $item['product']->title,
                'product_sku' => $item['product']->sku,
                'price' => $item['product']->selling_price,
                'quantity' => $item['quantity'],
                'size' => $item['size'],
                'subtotal' => $item['subtotal'],
            ]);

            // Decrement stock
            $remaining = $item['quantity'];
            $stocks = ProductStock::where('product_id', $item['product']->id)
                ->where('quantity', '>', 0)
                ->orderBy('id')
                ->get();

            foreach ($stocks as $stock) {
                if ($remaining <= 0) break;
                $deduct = min($remaining, $stock->quantity);
                $stock->decrement('quantity', $deduct);
                $remaining -= $deduct;
            }
        }

        // For COD, clear cart and redirect to success
        if ($request->payment_method === 'cod') {
            session()->forget(['cart', 'coupon']);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'payment_method' => 'cod',
                    'redirect' => route('checkout.success', $order->order_number),
                ]);
            }

            return redirect()->route('checkout.success', $order->order_number);
        }

        // For online payment, return order ID for Razorpay checkout
        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'payment_method' => 'online',
        ]);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
