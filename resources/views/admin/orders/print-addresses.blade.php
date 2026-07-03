<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Addresses — Divine Raksha</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background: #fff;
            color: #000;
        }

        /* Screen preview buttons */
        .screen-only {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            background: #1e3a8a;
            color: #fff;
        }
        .screen-only h2 { font-size: 15px; font-weight: 600; flex: 1; }
        .screen-only button {
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }
        .btn-print { background: #d4af37; color: #000; }
        .btn-close { background: rgba(255,255,255,0.15); color: #fff; }

        /* A4 page: 3 labels stacked */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 8mm;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .label {
            width: 100%;
            height: 93mm; /* 3 per A4: (297 - 16mm padding - 6mm gaps) / 3 ≈ 93mm */
            border: 1.5px solid #000;
            padding: 8mm 10mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .label + .label {
            border-top: none;
        }

        .label-top { flex: 1; }

        .brand {
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .to-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .customer-name {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .order-number {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .address {
            font-size: 11.5px;
            line-height: 1.5;
            margin-bottom: 3px;
        }

        .mobile {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .divider {
            border: none;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .product-section .product-title {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .product-items {
            font-size: 11.5px;
            line-height: 1.6;
        }

        .product-items span {
            font-weight: 700;
        }

        .footer-note {
            font-size: 9.5px;
            text-align: right;
            font-style: italic;
            color: #333;
            margin-top: 4px;
        }

        /* Print styles */
        @media print {
            .screen-only { display: none !important; }
            body { margin: 0; }
            .page {
                margin: 0;
                padding: 8mm;
                width: 210mm;
                min-height: 297mm;
            }
            .label { page-break-inside: avoid; break-inside: avoid; }
        }

        /* Every 3rd label starts a new page in print */
        @media print {
            .page-break { page-break-before: always; break-before: page; }
        }
    </style>
</head>
<body>

    <div class="screen-only">
        <h2>Print Address Labels — {{ $orders->count() }} order(s) &nbsp;·&nbsp; {{ ceil($orders->count() / 3) }} A4 page(s)</h2>
        <button class="btn-close" onclick="window.close()">✕ Close</button>
        <button class="btn-print" onclick="window.print()">🖨 Print</button>
    </div>

    @php $chunks = $orders->chunk(3); @endphp

    @foreach($chunks as $chunkIndex => $chunk)
        <div class="page {{ $chunkIndex > 0 ? 'page-break' : '' }}">
            @foreach($chunk as $order)
                @php
                    $fullAddress = collect([
                        $order->shipping_address,
                        $order->shipping_city,
                        $order->shipping_state ? $order->shipping_state . ($order->shipping_pincode ? ' - ' . $order->shipping_pincode : '') : $order->shipping_pincode,
                    ])->filter()->implode(', ');
                @endphp

                <div class="label">
                    <div class="label-top">
                        <div class="brand">Divine Raksha</div>

                        <div class="to-label">To:</div>
                        <div class="customer-name">{{ $order->customer_name }}</div>
                        <div class="order-number">ORDER: {{ $order->order_number }}</div>
                        <div class="address">{{ $fullAddress }}</div>
                        <div class="mobile">Mobile: {{ $order->customer_phone }}</div>
                    </div>

                    <div class="product-section">
                        <hr class="divider">
                        <div class="product-title">Product Details</div>
                        <div class="product-items">
                            @foreach($order->items as $item)
                                <span>{{ $item->product_sku ?: ($item->product ? ($item->product->sku ?? $item->product_title) : $item->product_title) }}</span> × {{ $item->quantity }}@if(!$loop->last),&nbsp;@endif
                            @endforeach
                        </div>
                        <div class="footer-note">Thank you for shopping from Divine Raksha, Bengaluru</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

</body>
</html>
