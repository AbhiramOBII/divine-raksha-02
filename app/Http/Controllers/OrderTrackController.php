<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackController extends Controller
{
    public function index()
    {
        return view('track-order');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with('items.product')
            ->where('order_number', $request->order_number)
            ->first();

        if (!$order) {
            return back()->withInput()->withErrors([
                'order_number' => 'No order found with this order ID. Please check and try again.',
            ]);
        }

        return view('track-order', compact('order'));
    }
}
