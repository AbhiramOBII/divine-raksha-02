@extends('admin.layouts.app')

@section('title', $coupon->exists ? 'Edit Coupon' : 'Create Coupon')
@section('page-title', $coupon->exists ? 'Edit Coupon' : 'Create Coupon')

@section('content')
    <form method="POST" action="{{ $coupon->exists ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}" class="space-y-6 max-w-4xl">
        @csrf
        @if($coupon->exists) @method('PUT') @endif

        <!-- Basic Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Coupon Details</h2>
            <p class="text-sm text-gray-500 mb-6">Set up the basic coupon information</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Name *</label>
                    <input type="text" name="name" value="{{ old('name', $coupon->name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. Summer Sale 20%">
                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code *</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue font-mono uppercase"
                           placeholder="e.g. SUMMER20" oninput="this.value = this.value.toUpperCase()">
                    @error('code') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Discount Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Discount Settings</h2>
            <p class="text-sm text-gray-500 mb-6">Configure the discount type and limits</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount Type *</label>
                    <select name="discount_type" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type', $coupon->discount_type) === 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                    </select>
                    @error('discount_type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount Value *</label>
                    <input type="number" name="discount_value" value="{{ old('discount_value', $coupon->discount_value) }}" required step="0.01" min="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 20">
                    @error('discount_value') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Cart Value</label>
                    <input type="number" name="min_cart_value" value="{{ old('min_cart_value', $coupon->min_cart_value) }}" step="0.01" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 500">
                    <p class="text-xs text-gray-400 mt-1">Leave 0 for no minimum</p>
                    @error('min_cart_value') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Discount Amount</label>
                    <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" step="0.01" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 200">
                    <p class="text-xs text-gray-400 mt-1">For percentage coupons — caps the maximum discount. Leave empty for no cap.</p>
                    @error('max_discount_amount') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Validity & Limits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Validity & Usage Limits</h2>
            <p class="text-sm text-gray-500 mb-6">Set validity period and usage restrictions</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $coupon->start_date?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    @error('start_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $coupon->end_date?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    @error('end_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Usage Limit</label>
                    <input type="number" name="total_usage_limit" value="{{ old('total_usage_limit', $coupon->total_usage_limit) }}" min="1"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 100">
                    <p class="text-xs text-gray-400 mt-1">Leave empty for unlimited</p>
                    @error('total_usage_limit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Per User Usage Limit</label>
                    <input type="number" name="per_user_usage_limit" value="{{ old('per_user_usage_limit', $coupon->per_user_usage_limit ?? 1) }}" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 1">
                    <p class="text-xs text-gray-400 mt-1">0 for unlimited per user</p>
                    @error('per_user_usage_limit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Status & Submit -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                               {{ old('is_active', $coupon->exists ? $coupon->is_active : true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-royal-blue rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-royal-blue"></div>
                    </label>
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                        {{ $coupon->exists ? 'Update Coupon' : 'Create Coupon' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
