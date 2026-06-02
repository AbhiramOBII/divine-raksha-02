<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
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

                    <!-- Status Update -->
                    <tr>
                        <td style="padding: 40px 40px 20px;">
                            <h2 style="margin: 0; color: #1e3a8a; font-size: 22px;">Order Status Updated</h2>
                            <p style="color: #64748b; font-size: 15px; line-height: 1.6; margin: 12px 0 0;">
                                Dear {{ $order->customer_name }},<br>
                                Your order <strong style="color: #1e3a8a;">{{ $order->order_number }}</strong> has been updated.
                            </p>
                        </td>
                    </tr>

                    <!-- Status Change Visual -->
                    <tr>
                        <td style="padding: 0 40px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 24px; text-align: center;">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['color' => '#d97706', 'label' => 'Pending', 'icon' => '⏳'],
                                                'processing' => ['color' => '#2563eb', 'label' => 'Processing', 'icon' => '⚙️'],
                                                'shipped' => ['color' => '#4f46e5', 'label' => 'Shipped', 'icon' => '🚚'],
                                                'delivered' => ['color' => '#16a34a', 'label' => 'Delivered', 'icon' => '✅'],
                                                'cancelled' => ['color' => '#dc2626', 'label' => 'Cancelled', 'icon' => '❌'],
                                            ];
                                            $old = $statusConfig[$oldStatus] ?? ['color' => '#64748b', 'label' => ucfirst($oldStatus), 'icon' => '📦'];
                                            $new = $statusConfig[$order->status] ?? ['color' => '#64748b', 'label' => ucfirst($order->status), 'icon' => '📦'];
                                        @endphp
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="40%" align="center">
                                                    <p style="margin: 0; font-size: 28px;">{{ $old['icon'] }}</p>
                                                    <p style="margin: 8px 0 0; color: {{ $old['color'] }}; font-size: 14px; font-weight: 600;">{{ $old['label'] }}</p>
                                                </td>
                                                <td width="20%" align="center">
                                                    <p style="margin: 0; color: #94a3b8; font-size: 24px;">→</p>
                                                </td>
                                                <td width="40%" align="center">
                                                    <p style="margin: 0; font-size: 28px;">{{ $new['icon'] }}</p>
                                                    <p style="margin: 8px 0 0; color: {{ $new['color'] }}; font-size: 16px; font-weight: 700;">{{ $new['label'] }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Status Messages -->
                    <tr>
                        <td style="padding: 0 40px 30px;">
                            @if($order->status === 'processing')
                                <p style="color: #334155; font-size: 14px; line-height: 1.6; margin: 0;">
                                    We are preparing your order. You will be notified once it is shipped.
                                </p>
                            @elseif($order->status === 'shipped')
                                <p style="color: #334155; font-size: 14px; line-height: 1.6; margin: 0;">
                                    Your order is on its way! It will be delivered to your shipping address soon.
                                </p>
                            @elseif($order->status === 'delivered')
                                <p style="color: #334155; font-size: 14px; line-height: 1.6; margin: 0;">
                                    Your order has been delivered. We hope you enjoy your sacred items. Thank you for choosing Divine Raksha! 🙏
                                </p>
                            @elseif($order->status === 'cancelled')
                                <p style="color: #334155; font-size: 14px; line-height: 1.6; margin: 0;">
                                    Your order has been cancelled. If you have any questions, please contact our support team.
                                </p>
                            @else
                                <p style="color: #334155; font-size: 14px; line-height: 1.6; margin: 0;">
                                    Your order status has been updated. Please check the details below.
                                </p>
                            @endif
                        </td>
                    </tr>

                    <!-- Order Summary -->
                    <tr>
                        <td style="padding: 0 40px 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 6px;">Order Number</td>
                                                <td align="right" style="color: #1e3a8a; font-size: 14px; font-weight: 600; padding-bottom: 6px;">{{ $order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px; padding-bottom: 6px;">Order Total</td>
                                                <td align="right" style="color: #334155; font-size: 14px; font-weight: 600; padding-bottom: 6px;">₹{{ number_format($order->total) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 13px;">Items</td>
                                                <td align="right" style="color: #334155; font-size: 14px;">{{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
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
