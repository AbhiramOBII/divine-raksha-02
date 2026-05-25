<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

        $shipping = $subtotal >= 999 ? 0 : 99;
        $total = $subtotal + $shipping;

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'user'));
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

        // Calculate totals
        $subtotal = 0;
        $items = [];

        foreach ($cart as $id => $cartItem) {
            $product = Product::find($id);
            if ($product) {
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

        $shipping = $subtotal >= 999 ? 0 : 99;
        $total = $subtotal + $shipping;

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
            'discount' => 0,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // Create order items
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
        }

        // For COD, clear cart and redirect to success
        if ($request->payment_method === 'cod') {
            session()->forget('cart');

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
