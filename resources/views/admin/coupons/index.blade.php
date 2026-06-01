@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page-title', 'Coupon Management')

@section('content')
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Coupons</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $stats['active'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Expired</p>
                    <h3 class="text-2xl font-bold {{ $stats['expired'] > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">{{ $stats['expired'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <form method="GET" action="{{ route('admin.coupons.index') }}" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search coupons..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700">Filter</button>
        </form>
        <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Create Coupon
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($coupons->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Coupon</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Code</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Discount</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Min Cart</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Validity</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Usage</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($coupons as $coupon)
                            @php
                                $isExpired = $coupon->end_date && $coupon->end_date->lt(now());
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $coupon->name }}</td>
                                <td class="px-6 py-4">
                                    <code class="px-2 py-1 bg-gray-100 text-royal-blue font-semibold rounded text-xs">{{ $coupon->code }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    @if($coupon->discount_type === 'percentage')
                                        <span class="font-semibold text-gray-900">{{ $coupon->discount_value }}%</span>
                                        @if($coupon->max_discount_amount)
                                            <span class="text-xs text-gray-500 block">Max ₹{{ number_format($coupon->max_discount_amount) }}</span>
                                        @endif
                                    @else
                                        <span class="font-semibold text-gray-900">₹{{ number_format($coupon->discount_value) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">₹{{ number_format($coupon->min_cart_value) }}</td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    @if($coupon->start_date && $coupon->end_date)
                                        {{ $coupon->start_date->format('d M') }} - {{ $coupon->end_date->format('d M Y') }}
                                    @elseif($coupon->end_date)
                                        Until {{ $coupon->end_date->format('d M Y') }}
                                    @else
                                        No expiry
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900 font-medium">{{ $coupon->times_used }}</span>
                                    <span class="text-gray-400">/{{ $coupon->total_usage_limit ?? '∞' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($isExpired)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Expired</span>
                                    @elseif($coupon->is_active)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-divine-red hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">{{ $coupons->links() }}</div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">No coupons found</h3>
                <p class="text-sm text-gray-500">Create your first coupon to get started.</p>
            </div>
        @endif
    </div>
@endsection
