@extends('admin.layouts.app')

@section('title', 'Stock Management')
@section('page-title', 'Stock Management')

@section('content')
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Units</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total']) }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Low Stock Entries</p>
                    <h3 class="text-2xl font-bold {{ $stats['low'] > 0 ? 'text-yellow-600' : 'text-gray-900' }} mt-1">{{ $stats['low'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Out of Stock</p>
                    <h3 class="text-2xl font-bold {{ $stats['out'] > 0 ? 'text-divine-red' : 'text-gray-900' }} mt-1">{{ $stats['out'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-divine-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <p class="text-sm text-gray-500">Select a product to manage its stock by size</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.stocks.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name or SKU..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
            </div>
            <div>
                <select name="filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    <option value="">All Products</option>
                    <option value="low" {{ request('filter') === 'low' ? 'selected' : '' }}>Has Low Stock</option>
                    <option value="out" {{ request('filter') === 'out' ? 'selected' : '' }}>Has Out of Stock</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">Filter</button>
                <a href="{{ route('admin.stocks.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">Reset</a>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Product</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">SKU</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Category</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Current Stock</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Total</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            @php
                                $totalStock = $product->stocks->sum('quantity');
                                $hasLow = $product->stocks->contains(fn($s) => $s->isLowStock() && !$s->isOutOfStock());
                                $hasOut = $product->stocks->contains(fn($s) => $s->isOutOfStock());
                                $noStock = $product->stocks->isEmpty();
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $product->title }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</code>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->category->title ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if($noStock)
                                        <span class="text-gray-400 text-xs">Not set</span>
                                    @elseif($product->stocks->count() === 1 && !$product->stocks->first()->size)
                                        <span class="font-semibold {{ $product->stocks->first()->isOutOfStock() ? 'text-divine-red' : ($product->stocks->first()->isLowStock() ? 'text-yellow-600' : 'text-gray-900') }}">
                                            {{ number_format($product->stocks->first()->quantity) }} units
                                        </span>
                                    @else
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($product->stocks as $stock)
                                                @php
                                                    $bgClass = $stock->isOutOfStock() ? 'bg-red-50 text-red-700 border-red-200' : ($stock->isLowStock() ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 'bg-green-50 text-green-700 border-green-200');
                                                @endphp
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium border {{ $bgClass }}">
                                                    @if($stock->size)<span class="text-gray-500">{{ $stock->size }}:</span>@endif
                                                    {{ $stock->quantity }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($noStock)
                                        <span class="text-gray-400">—</span>
                                    @else
                                        <span class="font-bold text-lg {{ $hasOut ? 'text-divine-red' : ($hasLow ? 'text-yellow-600' : 'text-gray-900') }}">
                                            {{ number_format($totalStock) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($noStock)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Unset</span>
                                    @elseif($hasOut)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Out of Stock</span>
                                    @elseif($hasLow)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Low Stock</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">In Stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.stocks.manage', $product) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-royal-blue text-white text-xs font-medium rounded-lg hover:bg-deep-royal transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">No products found</h3>
                <p class="text-sm text-gray-500">Create products first to manage their stock.</p>
            </div>
        @endif
    </div>
@endsection
