<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Verify webhook signature
        $webhookSecret = setting('razorpay_webhook_secret');

        if ($webhookSecret) {
            $expectedSignature = hash_hmac('sha256', $request->getContent(), $webhookSecret);
            $receivedSignature = $request->header('X-Razorpay-Signature');

            if (!$receivedSignature || !hash_equals($expectedSignature, $receivedSignature)) {
                Log::warning('Razorpay webhook: Invalid signature', [
                    'ip' => $request->ip(),
                ]);
                return response()->json(['error' => 'Invalid signature'], 403);
            }
        }

        $payload = $request->all();
        $event = $payload['event'] ?? null;

        Log::info('Razorpay webhook received', ['event' => $event]);

        return match ($event) {
            'payment.failed' => $this->handlePaymentFailed($payload),
            'order.paid' => $this->handleOrderPaid($payload),
            'refund.processed' => $this->handleRefundProcessed($payload),
            'refund.failed' => $this->handleRefundFailed($payload),
            default => response()->json(['status' => 'ignored', 'event' => $event]),
        };
    }

    /**
     * payment.failed — Mark order as failed, notify customer.
     */
    private function handlePaymentFailed(array $payload)
    {
        $payment = $payload['payload']['payment']['entity'] ?? null;

        if (!$payment) {
            return response()->json(['status' => 'no payment entity'], 400);
        }

        $razorpayOrderId = $payment['order_id'] ?? null;
        $order = $razorpayOrderId ? Order::where('razorpay_order_id', $razorpayOrderId)->first() : null;

        if (!$order) {
            Log::warning('Razorpay webhook payment.failed: Order not found', [
                'razorpay_order_id' => $razorpayOrderId,
            ]);
            return response()->json(['status' => 'order not found'], 200);
        }

        // Only update if not already paid (avoid race conditions)
        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'failed',
                'transaction_id' => $payment['id'] ?? $order->transaction_id,
            ]);

            Log::info('Razorpay webhook: Payment failed', [
                'order' => $order->order_number,
                'reason' => $payment['error_description'] ?? 'unknown',
            ]);

            // Send failure notification email to customer
            $this->sendPaymentFailedEmail($order, $payment);
        }

        return response()->json(['status' => 'handled']);
    }

    /**
     * order.paid — Mark order as paid (server-to-server confirmation).
     */
    private function handleOrderPaid(array $payload)
    {
        $razorpayOrder = $payload['payload']['order']['entity'] ?? null;
        $payment = $payload['payload']['payment']['entity'] ?? null;

        if (!$razorpayOrder) {
            return response()->json(['status' => 'no order entity'], 400);
        }

        $order = Order::where('razorpay_order_id', $razorpayOrder['id'])->first();

        if (!$order) {
            Log::warning('Razorpay webhook order.paid: Order not found', [
                'razorpay_order_id' => $razorpayOrder['id'],
            ]);
            return response()->json(['status' => 'order not found'], 200);
        }

        $order->update([
            'payment_status' => 'paid',
            'transaction_id' => $payment['id'] ?? $order->transaction_id,
            'razorpay_payment_id' => $payment['id'] ?? $order->razorpay_payment_id,
        ]);

        Log::info('Razorpay webhook: Order paid', [
            'order' => $order->order_number,
            'payment_id' => $payment['id'] ?? null,
        ]);

        return response()->json(['status' => 'handled']);
    }

    /**
     * refund.processed — Confirm refund completed.
     */
    private function handleRefundProcessed(array $payload)
    {
        $refund = $payload['payload']['refund']['entity'] ?? null;

        if (!$refund) {
            return response()->json(['status' => 'no refund entity'], 400);
        }

        $paymentId = $refund['payment_id'] ?? null;
        $order = $paymentId ? Order::where('razorpay_payment_id', $paymentId)->first() : null;

        if (!$order) {
            Log::warning('Razorpay webhook refund.processed: Order not found', [
                'payment_id' => $paymentId,
            ]);
            return response()->json(['status' => 'order not found'], 200);
        }

        $order->update([
            'payment_status' => 'refunded',
        ]);

        Log::info('Razorpay webhook: Refund processed', [
            'order' => $order->order_number,
            'refund_id' => $refund['id'] ?? null,
            'amount' => ($refund['amount'] ?? 0) / 100,
        ]);

        // Notify customer about successful refund
        $this->sendRefundEmail($order, $refund, 'processed');

        return response()->json(['status' => 'handled']);
    }

    /**
     * refund.failed — Update order to reflect refund failure.
     */
    private function handleRefundFailed(array $payload)
    {
        $refund = $payload['payload']['refund']['entity'] ?? null;

        if (!$refund) {
            return response()->json(['status' => 'no refund entity'], 400);
        }

        $paymentId = $refund['payment_id'] ?? null;
        $order = $paymentId ? Order::where('razorpay_payment_id', $paymentId)->first() : null;

        if (!$order) {
            Log::warning('Razorpay webhook refund.failed: Order not found', [
                'payment_id' => $paymentId,
            ]);
            return response()->json(['status' => 'order not found'], 200);
        }

        // Keep payment_status as 'paid' since refund failed — money is still with us
        Log::error('Razorpay webhook: Refund failed', [
            'order' => $order->order_number,
            'refund_id' => $refund['id'] ?? null,
        ]);

        // Notify customer about failed refund
        $this->sendRefundEmail($order, $refund, 'failed');

        return response()->json(['status' => 'handled']);
    }

    /**
     * Send payment failed email to customer.
     */
    private function sendPaymentFailedEmail(Order $order, array $payment): void
    {
        try {
            Mail::raw(
                "Dear {$order->customer_name},\n\n" .
                "Your payment for Order #{$order->order_number} of ₹" . number_format($order->total, 2) . " has failed.\n\n" .
                "Reason: " . ($payment['error_description'] ?? 'Payment was declined') . "\n\n" .
                "Please try again or use a different payment method.\n\n" .
                "Thank you,\nDivine Raksha",
                function ($message) use ($order) {
                    $message->to($order->customer_email, $order->customer_name)
                        ->subject("Payment Failed – Order #{$order->order_number}");
                }
            );
        } catch (\Throwable $e) {
            Log::error('Failed to send payment failed email', [
                'order' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send refund status email to customer.
     */
    private function sendRefundEmail(Order $order, array $refund, string $status): void
    {
        try {
            $amount = '₹' . number_format(($refund['amount'] ?? 0) / 100, 2);

            if ($status === 'processed') {
                $subject = "Refund Processed – Order #{$order->order_number}";
                $body = "Dear {$order->customer_name},\n\n" .
                    "Your refund of {$amount} for Order #{$order->order_number} has been processed successfully.\n\n" .
                    "The amount will be credited to your original payment method within 5-7 business days.\n\n" .
                    "Thank you,\nDivine Raksha";
            } else {
                $subject = "Refund Update – Order #{$order->order_number}";
                $body = "Dear {$order->customer_name},\n\n" .
                    "We encountered an issue processing your refund of {$amount} for Order #{$order->order_number}.\n\n" .
                    "Our team has been notified and will resolve this shortly. If you have any concerns, please contact us.\n\n" .
                    "Thank you,\nDivine Raksha";
            }

            Mail::raw($body, function ($message) use ($order, $subject) {
                $message->to($order->customer_email, $order->customer_name)
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to send refund email', [
                'order' => $order->order_number,
                'status' => $status,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
