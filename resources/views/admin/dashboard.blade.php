@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="om-background rounded-xl p-6 mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-venlury font-bold text-pure-white mb-2">
                Namaste, {{ Auth::guard('admin')->user()->name }}! 🙏
            </h2>
            <p class="text-pure-white/70">Welcome to the Divine Raksha Admin Panel. Manage your sacred store from here.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                @if($stats['pendingOrders'] > 0)
                    <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">{{ $stats['pendingOrders'] }} pending</span>
                @endif
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalOrders'] }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Orders</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['revenue'], 0) }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Revenue</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalProducts'] }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Products</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalCustomers'] }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Customers</p>
        </div>
    </div>

    <!-- Recent Orders -->
    @if($recentOrders->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-royal-blue hover:text-deep-royal font-medium">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Order #</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Customer</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Total</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Payment</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-royal-blue hover:text-deep-royal">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-6 py-3 text-gray-700">{{ $order->customer_name }}</td>
                            <td class="px-6 py-3 font-medium text-gray-900">₹{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $sc = ['pending'=>'bg-yellow-50 text-yellow-700','processing'=>'bg-blue-50 text-blue-700','shipped'=>'bg-indigo-50 text-indigo-700','delivered'=>'bg-green-50 text-green-700','cancelled'=>'bg-red-50 text-red-700'];
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$order->status] ?? '' }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $pc = ['paid'=>'bg-green-50 text-green-700','pending'=>'bg-yellow-50 text-yellow-700','failed'=>'bg-red-50 text-red-700','refunded'=>'bg-gray-100 text-gray-700'];
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $pc[$order->payment_status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($order->payment_status) }}</span>
                            </td>
                            <td class="px-6 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Low Stock Products -->
    @if($lowStockProducts->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                <h3 class="font-semibold text-gray-900">Low Stock / Out of Stock Products</h3>
            </div>
            <a href="{{ route('admin.stocks.index', ['filter' => 'low']) }}" class="text-sm text-royal-blue hover:text-deep-royal font-medium">View All &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Product</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">SKU</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Category</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Stock</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($lowStockProducts as $product)
                        @php
                            $totalStock = $product->stocks->sum('quantity');
                            $hasOut = $product->stocks->contains(fn($s) => $s->isOutOfStock());
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $product->title }}</td>
                            <td class="px-6 py-3"><code class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</code></td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->category->title ?? '—' }}</td>
                            <td class="px-6 py-3">
                                <span class="font-bold {{ $hasOut ? 'text-divine-red' : 'text-yellow-600' }}">{{ $totalStock }}</span>
                            </td>
                            <td class="px-6 py-3">
                                @if($hasOut)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Out of Stock</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Low Stock</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('admin.stocks.manage', $product) }}" class="text-sm text-royal-blue hover:text-deep-royal font-medium">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-royal-blue hover:bg-blue-50/50 transition-all duration-200">
                <svg class="w-8 h-8 text-royal-blue mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Add Product</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-royal-blue hover:bg-blue-50/50 transition-all duration-200">
                <svg class="w-8 h-8 text-royal-blue mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">View Orders</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-royal-blue hover:bg-blue-50/50 transition-all duration-200">
                <svg class="w-8 h-8 text-royal-blue mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Categories</span>
            </a>
            <a href="{{ route('admin.stocks.index') }}" class="flex flex-col items-center p-4 rounded-lg border border-gray-200 hover:border-royal-blue hover:bg-blue-50/50 transition-all duration-200">
                <svg class="w-8 h-8 text-royal-blue mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">Manage Stock</span>
            </a>
        </div>
    </div>
@endsection
