@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-red-600 font-medium">Payment Failed</span>
            </nav>
        </div>
    </div>

    <section class="py-16 sm:py-24">
        <div class="container max-w-2xl mx-auto px-4 sm:px-6 text-center">
            <!-- Failed Icon -->
            <div class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <h1 class="text-2xl sm:text-3xl font-venlury font-bold text-gray-900 mb-3">Payment Failed</h1>
            <p class="text-gray-600 mb-2">We couldn't process your payment for order <span class="font-semibold text-royal-blue">#{{ $order->order_number }}</span>.</p>
            <p class="text-sm text-gray-500 mb-8">Don't worry — your order has been saved. You can try again or choose a different payment method.</p>

            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 text-left">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Number</span>
                        <span class="font-medium text-gray-900">#{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Amount</span>
                        <span class="font-bold text-royal-blue">₹{{ number_format($order->total) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="text-red-600 font-medium">Payment Failed</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('checkout.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-royal-blue text-white rounded-full font-semibold hover:bg-deep-royal transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Retry Payment
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-full font-semibold hover:bg-gray-200 transition-colors">
                    Continue Shopping
                </a>
            </div>

            <p class="mt-6 text-xs text-gray-500">If you continue to face issues, please contact us at <a href="mailto:support@divineraksha.com" class="text-royal-blue hover:underline">support@divineraksha.com</a></p>
        </div>
    </section>

@include('partials.footer')
