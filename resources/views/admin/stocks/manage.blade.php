@extends('admin.layouts.app')

@section('title', 'Manage Stock — ' . $product->title)
@section('page-title', 'Manage Stock')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.stocks.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-royal-blue mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Stock
        </a>

        <!-- Product Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $product->title }}</h3>
                    <div class="flex items-center gap-3 mt-1">
                        <code class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</code>
                        <span class="text-xs text-gray-500">{{ $product->category->title ?? '' }}</span>
                    </div>
                </div>
                @if($product->featured_image)
                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->title }}" class="w-14 h-14 rounded-lg object-cover border border-gray-200">
                @endif
            </div>
        </div>

        <!-- Stock Form -->
        <form action="{{ route('admin.stocks.save', $product) }}" method="POST">
            @csrf

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Stock by Size</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($product->size && count($product->size) > 0)
                            Set quantity and minimum stock alert for each size
                        @else
                            This product has no sizes configured — managing as single stock entry
                        @endif
                    </p>
                </div>

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Size</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Quantity</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Min Stock Alert</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($rows as $i => $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if($row['size'])
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{ $row['size'] }}</span>
                                    @else
                                        <span class="text-gray-400">Default</span>
                                    @endif
                                    <input type="hidden" name="stocks[{{ $i }}][size]" value="{{ $row['size'] }}">
                                </td>
                                <td class="px-6 py-3">
                                    <input type="number" name="stocks[{{ $i }}][quantity]"
                                           value="{{ old("stocks.{$i}.quantity", $row['quantity']) }}"
                                           min="0" required
                                           class="w-28 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                                    @error("stocks.{$i}.quantity") <p class="mt-1 text-xs text-divine-red">{{ $message }}</p> @enderror
                                </td>
                                <td class="px-6 py-3">
                                    <input type="number" name="stocks[{{ $i }}][min_stock_alert]"
                                           value="{{ old("stocks.{$i}.min_stock_alert", $row['min_stock_alert']) }}"
                                           min="0" required
                                           class="w-28 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                                    @error("stocks.{$i}.min_stock_alert") <p class="mt-1 text-xs text-divine-red">{{ $message }}</p> @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.stocks.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit"
                        class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">Save Stock</button>
            </div>
        </form>
    </div>
@endsection
