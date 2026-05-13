@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Track My Order</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-3xl mx-auto px-4 sm:px-6">

            <!-- Page Header -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-royal-blue/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-venlury font-bold text-royal-blue mb-2">Track My Order</h1>
                <p class="text-gray-500">Enter your order ID to check the current status of your order</p>
            </div>

            <!-- Search Form -->
            <form method="POST" action="{{ route('order.track.search') }}" class="mb-10">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="order_number" value="{{ old('order_number') }}" placeholder="Enter Order ID (e.g. DR260512XXXX)"
                               class="w-full px-5 py-3.5 border-2 rounded-xl text-base focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors {{ $errors->has('order_number') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
                               autofocus>
                        @error('order_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-8 py-3.5 bg-royal-blue text-white font-semibold rounded-xl hover:bg-deep-royal transition-colors duration-200 shrink-0">
                        Track Order
                    </button>
                </div>
            </form>

            <!-- Order Result -->
            @if(isset($order))
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                    <!-- Order Header -->
                    <div class="px-6 py-5 bg-gradient-to-r from-royal-blue to-[#011455] text-white">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-white/70 text-sm">Order Number</p>
                                <p class="text-xl font-bold">{{ $order->order_number }}</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <p class="text-white/70 text-sm">Placed on</p>
                                <p class="font-medium">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="px-6 py-6 border-b border-gray-100">
                        @php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                            $cancelled = $order->status === 'cancelled';
                            $currentIndex = array_search($order->status, $statuses);
                            if ($currentIndex === false) $currentIndex = -1;
                        @endphp

                        @if($cancelled)
                            <div class="flex items-center justify-center py-4">
                                <div class="flex items-center gap-3 px-6 py-3 bg-red-50 border border-red-200 rounded-xl">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-red-700 font-semibold">Order Cancelled</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between relative">
                                <!-- Progress Line -->
                                <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-200 mx-10"></div>
                                <div class="absolute top-5 left-0 h-0.5 bg-green-500 mx-10 transition-all duration-500"
                                     style="width: {{ $currentIndex >= 0 ? ($currentIndex / (count($statuses) - 1)) * (100 - 10) : 0 }}%"></div>

                                @foreach($statuses as $i => $status)
                                    @php
                                        $isDone = $i <= $currentIndex;
                                        $isCurrent = $i === $currentIndex;
                                    @endphp
                                    <div class="relative z-10 flex flex-col items-center flex-1">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                            {{ $isDone ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}
                                            {{ $isCurrent ? 'ring-4 ring-green-100' : '' }}">
                                            @if($isDone)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-sm font-bold">{{ $i + 1 }}</span>
                                            @endif
                                        </div>
                                        <span class="mt-2 text-xs sm:text-sm font-medium {{ $isDone ? 'text-green-700' : 'text-gray-400' }}">{{ ucfirst($status) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Order Details -->
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                            <div>
                                <p class="text-gray-400 mb-1">Status</p>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-50 text-yellow-700',
                                        'processing' => 'bg-blue-50 text-blue-700',
                                        'shipped' => 'bg-indigo-50 text-indigo-700',
                                        'delivered' => 'bg-green-50 text-green-700',
                                        'cancelled' => 'bg-red-50 text-red-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? '' }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div>
                                <p class="text-gray-400 mb-1">Payment</p>
                                @php
                                    $payColors = [
                                        'pending' => 'bg-yellow-50 text-yellow-700',
                                        'paid' => 'bg-green-50 text-green-700',
                                        'failed' => 'bg-red-50 text-red-700',
                                        'refunded' => 'bg-purple-50 text-purple-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $payColors[$order->payment_status] ?? '' }}">{{ ucfirst($order->payment_status) }}</span>
                            </div>
                            <div>
                                <p class="text-gray-400 mb-1">Total</p>
                                <p class="font-bold text-gray-900">₹{{ number_format($order->total, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 mb-1">Items</p>
                                <p class="font-bold text-gray-900">{{ $order->items->sum('quantity') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900 mb-4">Items in this order</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                        @if($item->product && $item->product->featured_image)
                                            <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="{{ $item->product_title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 text-sm">{{ $item->product_title }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}@if($item->size) &middot; Size: {{ $item->size }}@endif</p>
                                    </div>
                                    <p class="font-semibold text-gray-900 text-sm">₹{{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="px-6 py-5">
                        <h3 class="font-semibold text-gray-900 mb-2">Shipping To</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $order->customer_name }}<br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </section>

@include('partials.footer')
