<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    private function getRazorpay(): Api
    {
        $key = setting('razorpay_key_id') ?: config('services.razorpay.key');
        $secret = setting('razorpay_key_secret') ?: config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            abort(500, 'Razorpay credentials are not configured. Please set them in Admin > Settings.');
        }

        return new Api($key, $secret);
    }

    private function getRazorpayKey(): string
    {
        return setting('razorpay_key_id') ?: config('services.razorpay.key');
    }

    public function createOrder(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $razorpay = $this->getRazorpay();

        $razorpayOrder = $razorpay->order->create([
            'receipt' => $order->order_number,
            'amount' => (int) ($order->total * 100), // Amount in paise
            'currency' => 'INR',
            'notes' => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
            ],
        ]);

        $order->update([
            'razorpay_order_id' => $razorpayOrder->id,
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $razorpayOrder->id,
            'amount' => (int) ($order->total * 100),
            'currency' => 'INR',
            'key' => $this->getRazorpayKey(),
            'name' => 'Divine Raksha',
            'description' => 'Order #' . $order->order_number,
            'prefill' => [
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'contact' => $order->customer_phone,
            ],
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

        try {
            $razorpay = $this->getRazorpay();

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $razorpay->utility->verifyPaymentSignature($attributes);

            // Payment verified successfully
            $order->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'transaction_id' => $request->razorpay_payment_id,
                'payment_status' => 'paid',
            ]);

            // Clear cart and coupon
            session()->forget(['cart', 'coupon']);

            return response()->json([
                'success' => true,
                'redirect' => route('checkout.success', $order->order_number),
            ]);
        } catch (SignatureVerificationError $e) {
            $order->update([
                'payment_status' => 'failed',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
                'redirect' => route('payment.failed', $order->order_number),
            ], 422);
        }
    }

    public function failed($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('checkout.failed', compact('order'));
    }
}
