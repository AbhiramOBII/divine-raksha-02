<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category', 'stocks');

        // Filter by bestseller
        if ($request->filled('bestseller')) {
            $query->where('bestseller', true);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by attribute (JSON array column)
        if ($request->filled('attribute')) {
            foreach ((array) $request->attribute as $attr) {
                $query->whereJsonContains('attributes', $attr);
            }
        }

        // Filter by size
        if ($request->filled('size')) {
            foreach ((array) $request->size as $size) {
                $query->whereJsonContains('size', $size);
            }
        }

        // Filter by purpose
        if ($request->filled('purpose')) {
            foreach ((array) $request->purpose as $purpose) {
                $query->whereJsonContains('shop_purpose', $purpose);
            }
        }

        // Filter by raashi
        if ($request->filled('raashi')) {
            foreach ((array) $request->raashi as $raashi) {
                $query->whereJsonContains('shop_by_raashi', $raashi);
            }
        }

        // Filter by numerology
        if ($request->filled('numerology')) {
            foreach ((array) $request->numerology as $num) {
                $query->whereJsonContains('shop_by_numerology', $num);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // Filter options
        $categories = Category::active()->whereHas('products', function ($q) {
            $q->where('status', true);
        })->orderBy('sort_order')->get();

        $attributes = ['Natural', 'Blessed', 'Handcrafted', 'Organic'];
        $sizes = ['Small', 'Medium', 'Large', 'Extra Large'];
        $purposes = ['Wealth', 'Love', 'Health', 'Luck', 'Protection', 'Peace', 'Courage', 'Balance'];
        $raashis = ['Mesha', 'Vrishabha', 'Mithuna', 'Karka', 'Simha', 'Kanya', 'Tula', 'Vrischika', 'Dhanu', 'Makara', 'Kumbha', 'Meena'];
        $numerology = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return view('products.index', compact(
            'products', 'categories', 'attributes', 'sizes', 'purposes', 'raashis', 'numerology'
        ));
    }

    public function show(Product $product)
    {
        $product->load('category', 'stocks');

        $relatedProducts = Product::active()
            ->with('stocks')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->limit(6)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function shopByPurpose(Request $request, $purpose = null)
    {
        $purposes = [
            'Wealth'     => ['icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z', 'desc' => 'Attract abundance and financial prosperity'],
            'Love'       => ['icon' => 'M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z', 'desc' => 'Strengthen relationships and attract love'],
            'Health'     => ['icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z', 'desc' => 'Promote healing and physical well-being'],
            'Luck'       => ['icon' => 'M12 2l2.4 7.4h7.6l-6 4.6 2.3 7-6.3-4.7-6.3 4.7 2.3-7-6-4.6h7.6z', 'desc' => 'Enhance fortune and good luck'],
            'Protection' => ['icon' => 'M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z', 'desc' => 'Shield from negative energies and evil eye'],
            'Peace'      => ['icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z', 'desc' => 'Cultivate inner calm and tranquility'],
            'Courage'    => ['icon' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z', 'desc' => 'Build strength and fearlessness'],
            'Balance'    => ['icon' => 'M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm6 9.09c0 4-2.55 7.7-6 8.83-3.45-1.13-6-4.82-6-8.83V6.31l6-2.12 6 2.12v4.78z', 'desc' => 'Harmonize mind, body and spirit'],
        ];

        $query = Product::active()->with('category', 'stocks');

        if ($purpose && array_key_exists($purpose, $purposes)) {
            $query->whereJsonContains('shop_purpose', $purpose);
        }

        $products = $query->latest()->paginate(12);

        return view('products.by-purpose', compact('purposes', 'purpose', 'products'));
    }

    public function shopByRaashi(Request $request, $raashi = null)
    {
        $raashis = [
            'Mesha'     => ['label' => 'Aries',       'symbol' => '♈'],
            'Vrishabha' => ['label' => 'Taurus',      'symbol' => '♉'],
            'Mithuna'   => ['label' => 'Gemini',      'symbol' => '♊'],
            'Karka'     => ['label' => 'Cancer',      'symbol' => '♋'],
            'Simha'     => ['label' => 'Leo',         'symbol' => '♌'],
            'Kanya'     => ['label' => 'Virgo',       'symbol' => '♍'],
            'Tula'      => ['label' => 'Libra',       'symbol' => '♎'],
            'Vrischika' => ['label' => 'Scorpio',     'symbol' => '♏'],
            'Dhanu'     => ['label' => 'Sagittarius', 'symbol' => '♐'],
            'Makara'    => ['label' => 'Capricorn',   'symbol' => '♑'],
            'Kumbha'    => ['label' => 'Aquarius',    'symbol' => '♒'],
            'Meena'     => ['label' => 'Pisces',      'symbol' => '♓'],
        ];

        // Normalize to title case so URLs can be lowercase
        if ($raashi) {
            $raashi = ucfirst(strtolower($raashi));
        }

        $query = Product::active()->with('category', 'stocks');

        if ($raashi && array_key_exists($raashi, $raashis)) {
            $query->whereJsonContains('shop_by_raashi', $raashi);
        }

        $products = $query->latest()->paginate(12);

        return view('products.by-raashi', compact('raashis', 'raashi', 'products'));
    }

    public function shopByNumerology(Request $request, $number = null)
    {
        $numbers = range(1, 9);

        $query = Product::active()->with('category', 'stocks');

        if ($number && in_array($number, $numbers)) {
            $query->whereJsonContains('shop_by_numerology', (string) $number);
        }

        $products = $query->latest()->paginate(12);

        return view('products.by-numerology', compact('numbers', 'number', 'products'));
    }

    public function bestsellers()
    {
        $products = Product::active()->bestseller()->with('category', 'stocks')->latest()->paginate(12);
        return view('products.bestsellers', compact('products'));
    }
}
