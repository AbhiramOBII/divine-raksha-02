<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalOrders' => Order::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'totalProducts' => Product::count(),
            'totalCustomers' => User::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('items')->latest()->take(5)->get();

        $lowStockProducts = Product::with(['stocks', 'category'])
            ->whereHas('stocks', function ($q) {
                $q->where('quantity', '>', 0)->lowStock();
            })
            ->orWhereHas('stocks', function ($q) {
                $q->outOfStock();
            })
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
