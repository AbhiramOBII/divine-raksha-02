<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e3a8a, #011455); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #d4af37; font-size: 24px; font-weight: 700;">Divine Raksha</h1>
                            <p style="margin: 8px 0 0; color: rgba(255,255,255,0.8); font-size: 13px;">Sacred Protection & Spiritual Balance</p>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding: 40px 40px 20px;">
                            <h2 style="margin: 0; color: #1e3a8a; font-size: 22px;">Thank You for Your Order! 🙏</h2>
                            <p style="color: #64748b; font-size: 15px; line-height: 1.6; margin: 12px 0 0;">
                                Dear {{ $order->customer_name }},<br>
                                Your order has been placed successfully. Here are the details:
                            </p>
                        </td>
                    </tr>

                    <!-- Order Info -->
                    <tr>
                        <td style="padding: 0 40px 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; border-radius: 8px; padding: 20px;">
                                <tr>
                                    <td style="padding: 12px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 8px;">Order Number</td>
                                                <td align="right" style="color: #1e3a8a; font-size: 14px; font-weight: 600; padding-bottom: 8px;">{{ $order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 8px;">Date</td>
                                                <td align="right" style="color: #334155; font-size: 14px; padding-bottom: 8px;">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 8px;">Payment Method</td>
                                                <td align="right" style="color: #334155; font-size: 14px; padding-bottom: 8px;">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px;">Payment Status</td>
                                                <td align="right" style="font-size: 14px; font-weight: 600; color: {{ $order->payment_status === 'paid' ? '#16a34a' : '#d97706' }};">{{ ucfirst($order->payment_status) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Items -->
                    <tr>
                        <td style="padding: 0 40px 20px;">
                            <h3 style="margin: 0 0 12px; color: #334155; font-size: 16px;">Items Ordered</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-top: 2px solid #e2e8f0;">
                                @foreach($order->items as $item)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px 0;">
                                        <p style="margin: 0; color: #334155; font-size: 14px; font-weight: 500;">{{ $item->product_title }}</p>
                                        @if($item->size)
                                            <p style="margin: 4px 0 0; color: #94a3b8; font-size: 12px;">Size: {{ $item->size }}</p>
                                        @endif
                                    </td>
                                    <td align="center" style="padding: 12px 0; color: #64748b; font-size: 13px;">× {{ $item->quantity }}</td>
                                    <td align="right" style="padding: 12px 0; color: #334155; font-size: 14px; font-weight: 500;">₹{{ number_format($item->subtotal) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Totals -->
                    <tr>
                        <td style="padding: 0 40px 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 6px;">Subtotal</td>
                                                <td align="right" style="color: #334155; font-size: 14px; padding-bottom: 6px;">₹{{ number_format($order->subtotal) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 6px;">Shipping</td>
                                                <td align="right" style="color: {{ $order->shipping_charge == 0 ? '#16a34a' : '#334155' }}; font-size: 14px; padding-bottom: 6px;">{{ $order->shipping_charge == 0 ? 'FREE' : '₹' . number_format($order->shipping_charge) }}</td>
                                            </tr>
                                            @if($order->discount > 0)
                                            <tr>
                                                <td style="color: #16a34a; font-size: 13px; padding-bottom: 6px;">Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</td>
                                                <td align="right" style="color: #16a34a; font-size: 14px; padding-bottom: 6px;">-₹{{ number_format($order->discount) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: 1px solid #e2e8f0; padding-top: 10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="color: #1e3a8a; font-size: 16px; font-weight: 700;">Total</td>
                                                <td align="right" style="color: #1e3a8a; font-size: 18px; font-weight: 700;">₹{{ number_format($order->total) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Shipping Address -->
                    <tr>
                        <td style="padding: 0 40px 30px;">
                            <h3 style="margin: 0 0 8px; color: #334155; font-size: 16px;">Shipping Address</h3>
                            <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.6;">
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                                {{ $order->shipping_country }}
                            </p>
                        </td>
                    </tr>

                    <!-- Track Order CTA -->
                    <tr>
                        <td style="padding: 0 40px 30px; text-align: center;">
                            <a href="{{ url('/track-order?order=' . $order->order_number . '&email=' . $order->customer_email) }}"
                               style="display: inline-block; background-color: #1e3a8a; color: #ffffff; padding: 14px 36px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">
                                Track Your Order
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f1f5f9; padding: 24px 40px; text-align: center;">
                            <p style="margin: 0 0 8px; color: #64748b; font-size: 13px;">
                                Need help? Reach us at <a href="mailto:{{ setting('site_email', 'support@divineraksha.com') }}" style="color: #1e3a8a;">{{ setting('site_email', 'support@divineraksha.com') }}</a>
                            </p>
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                &copy; {{ date('Y') }} Divine Raksha. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
