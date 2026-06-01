@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order Details')

@section('content')
    <!-- Back Button & Order Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}" class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    'delivered' => 'bg-green-50 text-green-700 border-green-200',
                    'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                ];
                $payColors = [
                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    'paid' => 'bg-green-50 text-green-700 border-green-200',
                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                    'refunded' => 'bg-purple-50 text-purple-700 border-purple-200',
                ];
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$order->status] ?? '' }}">
                {{ ucfirst($order->status) }}
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $payColors[$order->payment_status] ?? '' }}">
                Payment: {{ ucfirst($order->payment_status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Order Items + Summary -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Order Items ({{ $order->items->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="px-6 py-4 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($item->product && $item->product->featured_image)
                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="{{ $item->product_title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900">{{ $item->product_title }}</p>
                                <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                    @if($item->product_sku)
                                        <span>SKU: {{ $item->product_sku }}</span>
                                    @endif
                                    @if($item->size)
                                        <span>Size: {{ $item->size }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                <p class="font-semibold text-gray-900">₹{{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Order Totals -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-900">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shipping</span>
                        <span class="text-gray-900">₹{{ number_format($order->shipping_charge, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">
                                Discount
                                @if($order->coupon_code)
                                    <code class="ml-1 px-1.5 py-0.5 bg-green-100 text-green-700 text-xs rounded">{{ $order->coupon_code }}</code>
                                @endif
                            </span>
                            <span class="text-green-600">-₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-bold pt-2 border-t border-gray-200">
                        <span class="text-gray-900">Total</span>
                        <span class="text-royal-blue">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Order Notes</h3>
                    <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Right Column: Customer Info + Actions -->
        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Order Status</label>
                    <div class="flex gap-2 mt-1">
                        <select name="status" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="px-3 py-2 bg-royal-blue text-white text-sm rounded-lg hover:bg-deep-royal transition-colors">Update</button>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.orders.updatePaymentStatus', $order) }}">
                    @csrf
                    @method('PATCH')
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Payment Status</label>
                    <div class="flex gap-2 mt-1">
                        <select name="payment_status" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <button type="submit" class="px-3 py-2 bg-royal-blue text-white text-sm rounded-lg hover:bg-deep-royal transition-colors">Update</button>
                    </div>
                </form>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Customer</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-royal-blue/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-royal-blue">{{ strtoupper(substr($order->customer_name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                            @if($order->user)
                                <span class="text-xs text-green-600">Registered User</span>
                            @else
                                <span class="text-xs text-gray-400">Guest</span>
                            @endif
                        </div>
                    </div>
                    <div class="pt-3 border-t border-gray-100 space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $order->customer_email }}
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $order->customer_phone }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ editing: false }">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">Shipping Address</h3>
                    <button type="button" @click="editing = !editing" class="text-xs text-royal-blue hover:text-deep-royal font-medium">
                        <span x-show="!editing">Edit</span>
                        <span x-show="editing" x-cloak>Cancel</span>
                    </button>
                </div>

                <!-- Display Mode -->
                <div x-show="!editing">
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                        {{ $order->shipping_country }}
                    </p>
                </div>

                <!-- Edit Mode -->
                <form x-show="editing" x-cloak method="POST" action="{{ route('admin.orders.updateShipping', $order) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="text-xs font-medium text-gray-500">Address</label>
                        <textarea name="shipping_address" rows="2" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        @error('shipping_address') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-medium text-gray-500">City</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city', $order->shipping_city) }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            @error('shipping_city') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500">State</label>
                            <input type="text" name="shipping_state" value="{{ old('shipping_state', $order->shipping_state) }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            @error('shipping_state') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500">Pincode</label>
                        <input type="text" name="shipping_pincode" value="{{ old('shipping_pincode', $order->shipping_pincode) }}" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('shipping_pincode') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                        Save Address
                    </button>
                </form>
            </div>

            <!-- Billing Address -->
            @if($order->billing_address)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Billing Address</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $order->billing_address }}<br>
                        {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_pincode }}
                    </p>
                </div>
            @endif

            <!-- Payment Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-3">Payment</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Method</span>
                        <span class="font-medium text-gray-900">{{ $order->payment_method ? strtoupper($order->payment_method) : 'N/A' }}</span>
                    </div>
                    @if($order->transaction_id)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Transaction ID</span>
                            <span class="font-mono text-xs text-gray-700">{{ $order->transaction_id }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Delete Order -->
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
                <h3 class="font-semibold text-red-700 mb-2">Danger Zone</h3>
                <p class="text-xs text-gray-500 mb-3">Once deleted, this order cannot be recovered.</p>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to permanently delete this order?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 border border-red-200 transition-colors">
                        Delete Order
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
