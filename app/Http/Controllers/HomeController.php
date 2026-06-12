<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\FomoData;
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
        $fomoEntries = FomoData::inRandomOrder()->limit(10)->get();
        $products = Product::active()->inRandomOrder()->limit(20)->pluck('title')->toArray();

        if ($fomoEntries->isEmpty() || empty($products)) {
            return response()->json([]);
        }

        $timeOffsets = [
            'Just now', '1 minute ago', '2 minutes ago', '3 minutes ago',
            '5 minutes ago', '8 minutes ago', '12 minutes ago', '15 minutes ago',
            '20 minutes ago', '25 minutes ago', '30 minutes ago', '45 minutes ago',
            '1 hour ago', '2 hours ago',
        ];

        $result = $fomoEntries->map(function ($entry) use ($products, $timeOffsets) {
            return [
                'name' => $entry->fake_name,
                'city' => $entry->fake_city,
                'product' => $products[array_rand($products)],
                'time' => $timeOffsets[array_rand($timeOffsets)],
            ];
        });

        return response()->json($result);
    }
}
