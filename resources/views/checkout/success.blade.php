@include('partials.header')

    <section class="py-16 sm:py-24">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="max-w-2xl mx-auto text-center">
                <!-- Success Icon -->
                <div class="w-24 h-24 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-8">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>

                <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-4">Order Placed Successfully!</h1>
                <p class="text-lg text-gray-600 mb-2">Thank you for your purchase. Your sacred items are on their way.</p>
                <p class="text-sm text-gray-500 mb-8">Order Number: <span class="font-semibold text-royal-blue">{{ $order->order_number }}</span></p>

                <!-- Order Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-left mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h3>

                    <div class="space-y-3 mb-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->product_title }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}{{ $item->size ? ' | Size: ' . $item->size : '' }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">₹{{ number_format($item->subtotal) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-3 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span>{{ $order->shipping_charge == 0 ? 'FREE' : '₹' . number_format($order->shipping_charge) }}</span>
                        </div>
                        <div class="flex justify-between font-semibold text-gray-900 text-base pt-2 border-t border-gray-200">
                            <span>Total Paid</span>
                            <span class="text-royal-blue">₹{{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-left mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Shipping To</h3>
                    <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                    <p class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</p>
                    <p class="text-sm text-gray-600">Phone: {{ $order->customer_phone }}</p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-royal-blue text-white font-semibold rounded-full hover:bg-deep-royal transition-colors">
                        Continue Shopping
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border-2 border-royal-blue text-royal-blue font-semibold rounded-full hover:bg-royal-blue hover:text-white transition-colors">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>

@include('partials.footer')
