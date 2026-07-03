<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Address Labels</title>
    <style>
        * { margin: 0; padding: 0; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11pt;
            background: #fff;
            color: #000;
        }

        table.page-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            page-break-after: always;
        }
        table.page-table:last-child {
            page-break-after: auto;
        }

        td.label-cell {
            width: 100%;
            height: 270px;
            border: 1pt solid #000;
            padding: 12px 18px 10px 18px;
            vertical-align: top;
            overflow: hidden;
        }
    </style>
</head>
<body>

@php
    $chunks = $orders->chunk(3);
@endphp

@foreach($chunks as $chunk)
<table class="page-table">
    @foreach($chunk as $order)
    @php
        $fullAddress = collect([
            $order->shipping_address,
            $order->shipping_city,
            $order->shipping_state
                ? $order->shipping_state . ($order->shipping_pincode ? ' - ' . $order->shipping_pincode : '')
                : $order->shipping_pincode,
        ])->filter()->implode(', ');

        $skus = $order->items->map(function($item) {
            $sku = $item->product_sku ?: ($item->product ? ($item->product->sku ?? $item->product_title) : $item->product_title);
            return $sku . ' &times; ' . $item->quantity;
        })->implode(',&nbsp; ');
    @endphp
    <tr>
        <td class="label-cell">
            <div style="font-size:16pt;font-weight:bold;letter-spacing:1.5pt;text-transform:uppercase;margin-bottom:5px;">Divine Raksha</div>
            <div style="font-size:9pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.5pt;margin-bottom:2px;">To:</div>
            <div style="font-size:15pt;font-weight:bold;margin-bottom:3px;">{{ $order->customer_name }}</div>
            <div style="font-size:11pt;font-weight:bold;margin-bottom:3px;">ORDER: {{ $order->order_number }}</div>
            <div style="font-size:11pt;line-height:1.45;margin-bottom:3px;">{{ $fullAddress }}</div>
            <div style="font-size:12pt;font-weight:bold;margin-bottom:5px;">Mobile: {{ $order->customer_phone }}</div>
            <div style="border-top:1.5pt dashed #444;margin-bottom:5px;"></div>
            <div style="font-size:9pt;font-weight:bold;text-transform:uppercase;letter-spacing:0.5pt;margin-bottom:3px;">Product Details</div>
            <div style="font-size:12pt;">{!! $skus !!}</div>
            <div style="font-size:9pt;font-style:italic;color:#555;text-align:right;margin-top:5px;">Thank you for shopping from Divine Raksha, Bengaluru</div>
        </td>
    </tr>
    @endforeach

    {{-- Fill empty rows so table always has 3 rows --}}
    @for($p = $chunk->count(); $p < 3; $p++)
    <tr>
        <td class="label-cell" style="border:1pt dashed #ccc;background:#fafafa;"></td>
    </tr>
    @endfor
</table>
@endforeach

</body>
</html>
