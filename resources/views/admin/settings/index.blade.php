@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- General Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">General Information</h2>
            <p class="text-sm text-gray-500 mb-6">Basic information about your website</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. Divine Raksha">
                    @error('site_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Keywords</label>
                    <input type="text" name="site_keywords" value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. rudraksha, gemstones, spiritual">
                    @error('site_keywords')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                    <textarea name="site_description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                              placeholder="A short description of your website for search engines">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    @error('site_description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Offer Marquee -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Offer Marquee</h2>
            <p class="text-sm text-gray-500 mb-6">Scrolling announcement banner displayed between header and hero on the homepage</p>

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="marquee_enabled" value="">
                        <input type="checkbox" name="marquee_enabled" value="1" class="sr-only peer"
                               {{ old('marquee_enabled', $settings['marquee_enabled'] ?? '') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-royal-blue rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-royal-blue"></div>
                    </label>
                    <span class="text-sm font-medium text-gray-700">Enable Marquee</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marquee Text</label>
                    <textarea name="marquee_text" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                              placeholder="e.g. Free Shipping on Orders Above ₹999 | Use Code DIVINE10 for 10% Off | New Arrivals Every Week">{{ old('marquee_text', $settings['marquee_text'] ?? '') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Use <code class="bg-gray-100 px-1 rounded">|</code> (pipe) to separate multiple messages. They will scroll continuously.</p>
                    @error('marquee_text')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Contact Information</h2>
            <p class="text-sm text-gray-500 mb-6">Displayed in the header, footer & contact pages</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="site_phone" value="{{ old('site_phone', $settings['site_phone'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. +91 98765 43210">
                    @error('site_phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="site_email" value="{{ old('site_email', $settings['site_email'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. info@divineraksha.com">
                    @error('site_email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="site_address" rows="2"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                              placeholder="Full business address">{{ old('site_address', $settings['site_address'] ?? '') }}</textarea>
                    @error('site_address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Social Media</h2>
            <p class="text-sm text-gray-500 mb-6">Links to your social media profiles</p>

            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="https://instagram.com/yourpage">
                        @error('social_instagram')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="https://facebook.com/yourpage">
                        @error('social_facebook')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="https://youtube.com/@yourchannel">
                        @error('social_youtube')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Gateway -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Payment Gateway (Razorpay)</h2>
            <p class="text-sm text-gray-500 mb-6">Configure your Razorpay credentials for online payments</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Razorpay Key ID</label>
                    <input type="text" name="razorpay_key_id" value="{{ old('razorpay_key_id', $settings['razorpay_key_id'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue font-mono"
                           placeholder="rzp_live_xxxxxxxxxxxxxxxx">
                    @error('razorpay_key_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Razorpay Key Secret</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="razorpay_key_secret" value="{{ old('razorpay_key_secret', $settings['razorpay_key_secret'] ?? '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue font-mono pr-10"
                               placeholder="Enter your secret key">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    @error('razorpay_key_secret')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Webhook Secret</label>
                <div class="relative" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" name="razorpay_webhook_secret" value="{{ old('razorpay_webhook_secret', $settings['razorpay_webhook_secret'] ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue font-mono pr-10"
                           placeholder="Enter your webhook secret">
                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                @error('razorpay_webhook_secret')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg space-y-2">
                <p class="text-xs text-amber-700"><strong>Note:</strong> Use <code class="bg-amber-100 px-1 rounded">rzp_test_</code> keys for testing and <code class="bg-amber-100 px-1 rounded">rzp_live_</code> keys for production. Get your keys from <a href="https://dashboard.razorpay.com/app/keys" target="_blank" class="underline font-medium">Razorpay Dashboard</a>.</p>
                <p class="text-xs text-amber-700"><strong>Webhook URL:</strong> Set your webhook endpoint in Razorpay Dashboard to: <code class="bg-amber-100 px-1 rounded break-all">{{ url('/webhook/razorpay') }}</code></p>
                <p class="text-xs text-amber-700"><strong>Events to enable:</strong> <code class="bg-amber-100 px-1 rounded">payment.failed</code>, <code class="bg-amber-100 px-1 rounded">order.paid</code>, <code class="bg-amber-100 px-1 rounded">refund.processed</code>, <code class="bg-amber-100 px-1 rounded">refund.failed</code></p>
            </div>
        </div>

        <!-- Shipping Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-1">Shipping</h2>
            <p class="text-sm text-gray-500 mb-6">Configure shipping cost and free shipping threshold</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Threshold (₹)</label>
                    <input type="number" name="shipping_free_threshold" value="{{ old('shipping_free_threshold', $settings['shipping_free_threshold'] ?? '999') }}" step="1" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 999">
                    <p class="text-xs text-gray-400 mt-1">Minimum order value to qualify for free shipping. Set to 0 to always offer free shipping.</p>
                    @error('shipping_free_threshold')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Cost (₹)</label>
                    <input type="number" name="shipping_cost" value="{{ old('shipping_cost', $settings['shipping_cost'] ?? '99') }}" step="1" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="e.g. 99">
                    <p class="text-xs text-gray-400 mt-1">Flat shipping charge when order is below the free shipping threshold.</p>
                    @error('shipping_cost')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                Save Settings
            </button>
        </div>
    </form>
@endsection
