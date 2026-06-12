@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Shopping Cart</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-14">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <h1 class="text-2xl sm:text-3xl font-venlury font-bold text-royal-blue mb-8">Shopping Cart</h1>

            @if(count($cartItems) > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Cart Items -->
                    <div class="flex-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            @foreach($cartItems as $index => $item)
                                <div class="flex items-center gap-4 p-4 sm:p-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}" id="cart-item-{{ $item['product']->id }}">
                                    <!-- Image -->
                                    <a href="{{ route('products.show', $item['product']->slug) }}" class="flex-shrink-0">
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden bg-gray-100">
                                            <img src="{{ $item['product']->featured_image ? asset('storage/' . $item['product']->featured_image) : asset('images/karungulai.jpg') }}" alt="{{ $item['product']->title }}" class="w-full h-full object-cover">
                                        </div>
                                    </a>

                                    <!-- Details -->
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('products.show', $item['product']->slug) }}" class="text-sm sm:text-base font-semibold text-gray-900 hover:text-royal-blue transition-colors line-clamp-2">{{ $item['product']->title }}</a>
                                        @if($item['size'])
                                            <p class="text-xs text-gray-500 mt-1">Size: {{ $item['size'] }}</p>
                                        @endif
                                        <p class="text-royal-blue font-bold mt-1">₹{{ number_format($item['product']->selling_price) }}</p>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="flex flex-col items-center gap-1" x-data="{ qty: {{ $item['quantity'] }} }">
                                        <div class="flex items-center border border-gray-200 rounded-lg">
                                            <button @click="qty = Math.max(1, qty - 1); updateCart({{ $item['product']->id }}, qty)" class="px-2 sm:px-3 py-1.5 text-gray-500 hover:text-royal-blue text-sm">-</button>
                                            <span class="px-2 sm:px-3 py-1.5 border-l border-r border-gray-200 text-sm font-medium min-w-[32px] text-center" x-text="qty"></span>
                                            <button @click="qty = Math.min({{ $item['stock'] }}, qty + 1); updateCart({{ $item['product']->id }}, qty)" class="px-2 sm:px-3 py-1.5 text-gray-500 hover:text-royal-blue text-sm" {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }}>+</button>
                                        </div>
                                        @if($item['stock'] <= 0)
                                            <span class="text-[10px] text-divine-red font-medium">Out of Stock</span>
                                        @elseif($item['quantity'] >= $item['stock'])
                                            <span class="text-[10px] text-divine-red font-medium">Max available: {{ $item['stock'] }}</span>
                                        @elseif($item['stock'] <= 5)
                                            <span class="text-[10px] text-gray-500">Only {{ $item['stock'] }} left</span>
                                        @endif
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="hidden sm:block text-right">
                                        <p class="text-sm font-bold text-gray-900">₹{{ number_format($item['subtotal']) }}</p>
                                    </div>

                                    <!-- Remove -->
                                    <button onclick="removeFromCart({{ $item['product']->id }})" class="p-2 text-gray-400 hover:text-divine-red transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-6 text-sm text-royal-blue font-medium hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-96">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ count($cartItems) }} items)</span>
                                    <span class="font-medium text-gray-900">₹{{ number_format($total) }}</span>
                                </div>
                                @php
                                    $freeThreshold = (float) setting('shipping_free_threshold', 999);
                                    $shippingCost = (float) setting('shipping_cost', 99);
                                    $isFreeShipping = $total >= $freeThreshold;
                                @endphp
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="font-medium {{ $isFreeShipping ? 'text-green-600' : 'text-gray-900' }}">{{ $isFreeShipping ? 'FREE' : '₹' . number_format($shippingCost) }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 flex justify-between">
                                    <span class="font-semibold text-gray-900">Total</span>
                                    <span class="font-bold text-xl text-royal-blue">₹{{ number_format($isFreeShipping ? $total : $total + $shippingCost) }}</span>
                                </div>
                            </div>

                            @if(!$isFreeShipping)
                                <p class="text-xs text-gray-500 mt-3 bg-yellow-50 p-2 rounded-lg">Add ₹{{ number_format($freeThreshold - $total) }} more for free shipping!</p>
                            @endif

                            <a href="{{ route('checkout.index') }}" class="mt-6 block w-full bg-royal-blue text-white text-center py-4 rounded-full font-semibold hover:bg-deep-royal transition-colors sacred-glow">
                                Proceed to Checkout
                            </a>

                            <div class="flex flex-col items-center gap-1.5 mt-4 text-xs text-gray-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Shipping cost may be applicable
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Delivery in 5–7 Days based on availability
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                    Return only if product is damaged
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 mb-6">Looks like you haven't added any sacred items yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-royal-blue text-white font-semibold rounded-full hover:bg-deep-royal transition-colors">
                        Explore Products
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script>
        function updateCart(productId, quantity) {
            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    location.reload();
                } else if (data.message) {
                    alert(data.message);
                    location.reload();
                }
            });
        }

        function removeFromCart(productId) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            }).then(r => r.json()).then(data => {
                if (data.success) location.reload();
            });
        }
    </script>

@include('partials.footer')
