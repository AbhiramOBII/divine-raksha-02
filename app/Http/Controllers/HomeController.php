<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $bestsellers = Product::active()->bestseller()->with('category')->limit(10)->get();

        $purposes = ['Wealth', 'Love', 'Health', 'Luck', 'Protection', 'Peace', 'Courage', 'Balance', 'Education', 'Spiritual Growth', 'Career', 'Emotional Healing', 'Creativity', 'Success', 'Focus', 'Relationships'];

        $raashis = [
            'Mesha' => ['label' => 'Aries', 'icon' => 'aries.svg'],
            'Vrishabha' => ['label' => 'Taurus', 'icon' => 'taurus.svg'],
            'Mithuna' => ['label' => 'Gemini', 'icon' => 'gemini.svg'],
            'Karka' => ['label' => 'Cancer', 'icon' => 'cancer.svg'],
            'Simha' => ['label' => 'Leo', 'icon' => 'leo.svg'],
            'Kanya' => ['label' => 'Virgo', 'icon' => 'virgo.svg'],
            'Tula' => ['label' => 'Libra', 'icon' => 'libra.svg'],
            'Vrischika' => ['label' => 'Scorpio', 'icon' => 'scorpio.svg'],
            'Dhanu' => ['label' => 'Sagittarius', 'icon' => 'sagittarius.svg'],
            'Makara' => ['label' => 'Capricorn', 'icon' => 'capricorn.svg'],
            'Kumbha' => ['label' => 'Aquarius', 'icon' => 'aquarius.svg'],
            'Meena' => ['label' => 'Pisces', 'icon' => 'pisces.svg'],
        ];

        $numerology = range(1, 9);

        $latestBlogs = Blog::active()->with('category')->latest()->take(4)->get();

        return view('home', compact('sliders', 'bestsellers', 'purposes', 'raashis', 'numerology', 'latestBlogs'));
    }

    public function recentOrders()
    {
        $orders = Order::with('items')
            ->where('payment_status', 'paid')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                $firstItem = $order->items->first();
                $name = explode(' ', $order->customer_name)[0];
                return [
                    'name' => $name,
                    'city' => $order->shipping_city,
                    'product' => $firstItem ? $firstItem->product_title : 'a sacred item',
                    'time' => $order->created_at->diffForHumans(),
                ];
            });

        return response()->json($orders);
    }
}
