<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'subtotal' => $product->selling_price * $item['quantity'],
                ];
                $total += $product->selling_price * $item['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'quantity' => $request->quantity,
                'size' => $request->size,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cartCount' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);
        $id = $request->product_id;

        if ($request->quantity <= 0) {
            unset($cart[$id]);
        } else {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
            }
        }

        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax()) {
            $total = 0;
            foreach ($cart as $cid => $item) {
                $p = Product::find($cid);
                if ($p) $total += $p->selling_price * $item['quantity'];
            }
            return response()->json([
                'success' => true,
                'cartCount' => array_sum(array_column($cart, 'quantity')),
                'total' => $total,
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }
}
