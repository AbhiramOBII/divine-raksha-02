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
            height: 190px;
            border: 1pt solid #000;
            padding: 10px 14px 8px 14px;
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
            <div style="font-size:14pt;font-weight:bold;letter-spacing:1pt;text-transform:uppercase;margin-bottom:4px;">Divine Raksha</div>
            <div style="font-size:9pt;font-weight:bold;text-transform:uppercase;margin-bottom:1px;">To:</div>
            <div style="font-size:13pt;font-weight:bold;margin-bottom:2px;">{{ $order->customer_name }}</div>
            <div style="font-size:11pt;font-weight:bold;margin-bottom:2px;">ORDER: {{ $order->order_number }}</div>
            <div style="font-size:10.5pt;line-height:1.35;margin-bottom:3px;">{{ $fullAddress }}</div>
            <div style="font-size:11pt;font-weight:bold;margin-bottom:4px;">Mobile: {{ $order->customer_phone }}</div>
            <div style="border-top:1pt dashed #555;margin-bottom:4px;"></div>
            <div style="font-size:9pt;font-weight:bold;text-transform:uppercase;margin-bottom:2px;">Product Details</div>
            <div style="font-size:11pt;">{!! $skus !!}</div>
            <div style="font-size:9pt;font-style:italic;color:#555;text-align:right;margin-top:4px;">Thank you for shopping from Divine Raksha, Bengaluru</div>
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
