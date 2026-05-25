@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <p class="text-sm text-gray-500">Manage your product catalog</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bulk-upload.index') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Bulk Upload
            </a>
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Product
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or SKU..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
            </div>
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition-colors">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">Reset</a>
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
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Image</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Product</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">SKU</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Category</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Price</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Tags</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    @if($product->featured_image)
                                        <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->title }}" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $product->title }}</div>
                                    <code class="text-xs text-gray-500">/{{ $product->slug }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ $product->category->title }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">₹{{ number_format($product->selling_price, 2) }}</div>
                                    @if($product->cost_price > $product->selling_price)
                                        <div class="text-xs text-gray-400 line-through">₹{{ number_format($product->cost_price, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if($product->featured)
                                            <span class="px-1.5 py-0.5 rounded text-xs bg-yellow-50 text-yellow-700">Featured</span>
                                        @endif
                                        @if($product->new_product)
                                            <span class="px-1.5 py-0.5 rounded text-xs bg-green-50 text-green-700">New</span>
                                        @endif
                                        @if($product->bestseller)
                                            <span class="px-1.5 py-0.5 rounded text-xs bg-purple-50 text-purple-700">Bestseller</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-divine-red hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
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
                <p class="text-sm text-gray-500 mb-4">Get started by creating your first product.</p>
                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Add Product
                </a>
            </div>
        @endif
    </div>
@endsection
