<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'stocks'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            })
            ->when($request->filter === 'low', function ($query) {
                $query->whereHas('stocks', fn($q) => $q->lowStock()->where('quantity', '>', 0));
            })
            ->when($request->filter === 'out', function ($query) {
                $query->whereHas('stocks', fn($q) => $q->outOfStock());
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => ProductStock::sum('quantity'),
            'low' => ProductStock::lowStock()->where('quantity', '>', 0)->count(),
            'out' => ProductStock::outOfStock()->count(),
        ];

        return view('admin.stocks.index', compact('products', 'stats'));
    }

    public function manage(Product $product)
    {
        $product->load('stocks');

        // Build rows: one per configured size, plus any existing stock entries for unlisted sizes
        $sizes = $product->size ?? [];
        $existingStocks = $product->stocks->keyBy('size');
        $rows = [];

        if (empty($sizes)) {
            // Product has no sizes — single default row
            $stock = $existingStocks->get(null) ?? $existingStocks->get('');
            $rows[] = [
                'size' => '',
                'quantity' => $stock->quantity ?? 0,
                'min_stock_alert' => $stock->min_stock_alert ?? 5,
            ];
        } else {
            foreach ($sizes as $size) {
                $stock = $existingStocks->get($size);
                $rows[] = [
                    'size' => $size,
                    'quantity' => $stock->quantity ?? 0,
                    'min_stock_alert' => $stock->min_stock_alert ?? 5,
                ];
            }
        }

        return view('admin.stocks.manage', compact('product', 'rows'));
    }

    public function save(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stocks' => ['required', 'array', 'min:1'],
            'stocks.*.size' => ['nullable', 'string', 'max:255'],
            'stocks.*.quantity' => ['required', 'integer', 'min:0'],
            'stocks.*.min_stock_alert' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['stocks'] as $row) {
            ProductStock::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'size' => $row['size'] ?: null,
                ],
                [
                    'quantity' => $row['quantity'],
                    'min_stock_alert' => $row['min_stock_alert'],
                ]
            );
        }

        return redirect()->route('admin.stocks.index')
            ->with('success', "Stock updated for {$product->title}.");
    }
}
