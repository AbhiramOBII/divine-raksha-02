@php
    $seoTitle = ($product->meta_title ?: $product->title) . ' | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = Str::limit(strip_tags($product->meta_description ?: ($product->short_description ?? ($product->full_description ?? ''))), 160);
    $seoType = 'product';

    // Use featured_image first, fall back to first gallery image, then default OG
    if ($product->featured_image) {
        $seoImage = asset('storage/' . $product->featured_image);
    } elseif ($product->gallery_images && count($product->gallery_images) > 0) {
        $seoImage = asset('storage/' . $product->gallery_images[0]);
    } else {
        $seoImage = asset('images/og-default.jpg');
    }

    $seoCanonical = route('products.show', $product);

    // Schema.org images array
    $schemaImages = [];
    if ($product->featured_image) $schemaImages[] = asset('storage/' . $product->featured_image);
    if ($product->gallery_images) foreach ($product->gallery_images as $img) $schemaImages[] = asset('storage/' . $img);
    if (empty($schemaImages)) $schemaImages[] = asset('images/og-default.jpg');

    $seoSchema = '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->title,
        'description' => $seoDescription,
        'image' => $schemaImages,
        'brand' => ['@type' => 'Brand', 'name' => setting('site_name', 'Divine Raksha')],
        'offers' => ['@type' => 'Offer', 'priceCurrency' => 'INR', 'price' => (string) $product->selling_price, 'availability' => 'https://schema.org/InStock', 'url' => $seoCanonical],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
@endphp

@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('products.index') }}" class="hover:text-royal-blue transition-colors">Products</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium truncate max-w-[200px]">{{ $product->title }}</span>
            </nav>
        </div>
    </div>

    @php
        $totalStock = $product->stocks->sum('quantity');
    @endphp

    <!-- Product Detail Section -->
    <section class="py-16 bg-pure-white" x-data="{ activeImage: '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('images/karungulai.jpg') }}' }">
        <div class="container max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        <img :src="activeImage" alt="{{ $product->title }}" class="w-full h-full object-cover">
                    </div>
                    <!-- Thumbnail Images -->
                    <div class="grid grid-cols-4 gap-4">
                        <div @click="activeImage = '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('images/karungulai.jpg') }}'"
                             class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 transition-colors"
                             :class="activeImage === '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('images/karungulai.jpg') }}' ? 'border-sacred-gold' : 'border-transparent hover:border-sacred-gold'">
                            <img src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('images/karungulai.jpg') }}" alt="Main" class="w-full h-full object-cover">
                        </div>
                        @if($product->gallery_images && count($product->gallery_images) > 0)
                            @foreach($product->gallery_images as $image)
                                <div @click="activeImage = '{{ asset('storage/' . $image) }}'"
                                     class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 transition-colors"
                                     :class="activeImage === '{{ asset('storage/' . $image) }}' ? 'border-sacred-gold' : 'border-transparent hover:border-sacred-gold'">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Product Title and Badges -->
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            @if($product->discount_percentage > 0)
                                <span class="bg-divine-red text-pure-white px-2 py-1 rounded-full text-xs font-semibold">{{ $product->discount_percentage }}% OFF</span>
                            @endif
                            @if($product->bestseller)
                                <span class="bg-sacred-gold text-royal-blue px-2 py-1 rounded-full text-xs font-bold">BESTSELLER</span>
                            @endif
                            @if($product->new_product)
                                <span class="bg-green-500 text-pure-white px-2 py-1 rounded-full text-xs font-bold">NEW</span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-venlury font-bold text-royal-blue mb-4">
                            {{ $product->title }}
                        </h1>
                    </div>

                    <!-- Price -->
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center space-x-4 mb-2">
                            <span class="text-3xl font-bold text-royal-blue">₹{{ number_format($product->selling_price) }}</span>
                            @if($product->cost_price > $product->selling_price)
                                <span class="text-xl text-gray-500 line-through">₹{{ number_format($product->cost_price) }}</span>
                                <span class="bg-divine-red text-pure-white px-2 py-1 rounded text-sm font-semibold">Save ₹{{ number_format($product->cost_price - $product->selling_price) }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">MRP: ₹{{ number_format($product->cost_price) }} (Inclusive of all taxes)</p>
                    </div>

                    <!-- Product Description -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-royal-blue mb-3">Product Description</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            {{ $product->short_description }}
                        </p>
                        @if($product->attributes && count($product->attributes) > 0)
                            <ul class="space-y-2 text-gray-600">
                                @foreach($product->attributes as $attr)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-sacred-gold mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $attr }}
                                    </li>
                                @endforeach
                                @if($product->material)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-sacred-gold mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Material: {{ $product->material }}
                                    </li>
                                @endif
                                @if($product->weight)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-sacred-gold mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Weight: {{ $product->weight }}
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>

                    <!-- Size Selection -->
                    @if($product->size && count($product->size) > 0)
                        <div class="border-b border-gray-200 pb-6" x-data="{ selectedSize: '' }">
                            <h3 class="text-lg font-semibold text-royal-blue mb-3">Select Size</h3>
                            <div class="flex space-x-3">
                                @foreach($product->size as $size)
                                    <button type="button" @click="selectedSize = '{{ $size }}'"
                                            :class="selectedSize === '{{ $size }}' ? 'border-sacred-gold bg-sacred-gold text-royal-blue' : 'border-gray-300 text-gray-600 hover:border-sacred-gold'"
                                            class="px-4 py-2 border-2 rounded-lg font-semibold transition-all">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity and Add to Cart -->
                    <div class="space-y-4" x-data="{ qty: 1, adding: false, added: false, error: '' }">
                        <div>
                            <h3 class="text-lg font-semibold text-royal-blue mb-3">Quantity</h3>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button @click="qty = Math.max(1, qty - 1)" class="px-3 py-2 text-gray-600 hover:text-royal-blue" {{ $totalStock <= 0 ? 'disabled' : '' }}>-</button>
                                    <span class="px-4 py-2 border-l border-r border-gray-300" x-text="qty"></span>
                                    <button @click="qty = Math.min({{ $totalStock > 0 ? $totalStock : 1 }}, qty + 1)" class="px-3 py-2 text-gray-600 hover:text-royal-blue" {{ $totalStock <= 0 ? 'disabled' : '' }}>+</button>
                                </div>
                                @if($totalStock > 0 && $totalStock <= 10)
                                    <span class="text-sm text-gray-600">Only {{ $totalStock }} left in stock</span>
                                @elseif($totalStock <= 0)
                                    <span class="text-sm text-divine-red font-medium">Out of Stock</span>
                                @endif
                            </div>
                        </div>

                        <p x-show="error" x-cloak class="text-sm text-divine-red" x-text="error"></p>

                        <div class="flex space-x-4">
                            <button
                                x-ref="addBtn"
                                @click="error = ''; adding = true; flyToCart($refs.addBtn, '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : '' }}'); fetch('{{ route('cart.add') }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                    body: JSON.stringify({ product_id: {{ $product->id }}, quantity: qty })
                                }).then(r => r.json()).then(d => {
                                    if (!d.success) { error = d.message; adding = false; return; }
                                    adding = false; added = true;
                                    showCartToast('{{ addslashes($product->title) }}', '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('images/karungulai.jpg') }}', qty, d.cartCount);
                                    setTimeout(() => added = false, 3000);
                                }).catch(() => adding = false)"
                                class="flex-1 bg-royal-blue text-pure-white py-4 px-6 rounded-full font-semibold hover:bg-deep-royal transition-all duration-300 sacred-glow {{ $totalStock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $totalStock <= 0 ? 'disabled' : '' }}
                                :disabled="adding"
                            >
                                <span x-show="!adding && !added">Add to Cart</span>
                                <span x-show="adding" x-cloak>Adding...</span>
                                <span x-show="added" x-cloak>✓ Added!</span>
                            </button>
                            <button class="px-6 py-4 border-2 border-royal-blue text-royal-blue rounded-full font-semibold hover:bg-royal-blue hover:text-pure-white transition-all duration-300">
                                ♡ Wishlist
                            </button>
                        </div>

                        @if(setting('energize_cost') !== null)
                        <!-- Energise Your Product - Product Page -->
                        <div x-data="{
                                energize: localStorage.getItem('energize_selected') === 'true',
                                cost: {{ (float) setting('energize_cost', 0) }},
                                toggle() {
                                    this.energize = !this.energize;
                                    localStorage.setItem('energize_selected', this.energize);
                                }
                            }"
                            @click="toggle()"
                            :class="energize ? 'border-amber-400 bg-gradient-to-r from-amber-50 to-orange-50 shadow-md' : 'border-amber-200 bg-white hover:border-amber-300 hover:bg-amber-50/40'"
                            class="cursor-pointer rounded-2xl border-2 p-4 transition-all duration-200 select-none">
                            <div class="flex items-center gap-3">
                                <!-- Icon -->
                                <div :class="energize ? 'bg-amber-400' : 'bg-amber-100'" class="flex-shrink-0 w-11 h-11 rounded-full flex items-center justify-center transition-colors">
                                    <svg :class="energize ? 'text-white' : 'text-amber-500'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                                    </svg>
                                </div>
                                <!-- Text -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-sm font-bold text-gray-900">⚡ Energise Your Product</span>
                                        @if((float) setting('energize_cost', 0) > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">+₹{{ number_format((float) setting('energize_cost', 0)) }}</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">FREE</span>
                                        @endif
                                        <!-- Selected badge -->
                                        <span x-show="energize" x-cloak class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-500 text-white">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Added
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5 leading-snug">{{ setting('energize_label', 'Energize my product with sacred mantras & intentions') }}</p>
                                </div>
                                <!-- Toggle indicator -->
                                <div :class="energize ? 'bg-amber-400' : 'bg-gray-200'" class="flex-shrink-0 w-10 h-6 rounded-full relative transition-colors duration-200">
                                    <div :class="energize ? 'translate-x-4 bg-white' : 'translate-x-0.5 bg-white'" class="absolute top-0.5 w-5 h-5 rounded-full shadow transition-transform duration-200"></div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Shipping cost may be applicable
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Delivery in 5–7 Days based on availability
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Return only if product is damaged
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Tabs -->
    @if($product->full_description)
    <section class="py-16 bg-soft-grey" x-data="{ tab: 'description' }">
        <div class="container max-w-7xl mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-8">
                    <button @click="tab = 'description'" :class="tab === 'description' ? 'border-royal-blue text-royal-blue' : 'border-transparent text-gray-600 hover:text-royal-blue'" class="px-6 py-3 border-b-2 font-semibold transition-colors">Description</button>
                    <button @click="tab = 'specifications'" :class="tab === 'specifications' ? 'border-royal-blue text-royal-blue' : 'border-transparent text-gray-600 hover:text-royal-blue'" class="px-6 py-3 border-b-2 font-semibold transition-colors">Specifications</button>
                    <button @click="tab = 'reviews'" :class="tab === 'reviews' ? 'border-royal-blue text-royal-blue' : 'border-transparent text-gray-600 hover:text-royal-blue'" class="px-6 py-3 border-b-2 font-semibold transition-colors">Reviews</button>
                </div>

                <!-- Tab Content -->
                <div>
                    <!-- Description Tab -->
                    <div x-show="tab === 'description'" class="space-y-6">
                        <h3 class="text-2xl font-venlury font-bold text-royal-blue mb-4">{{ $product->title }}</h3>
                        <div class="text-gray-600 leading-relaxed space-y-4">
                            {!! nl2br(e($product->full_description)) !!}
                        </div>
                        @if($product->shop_purpose && count($product->shop_purpose) > 0)
                            <h4 class="text-lg font-semibold text-royal-blue mb-3 mt-6">Spiritual Benefits:</h4>
                            <ul class="space-y-2 text-gray-600">
                                @foreach($product->shop_purpose as $purpose)
                                    <li>• Ideal for {{ $purpose }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Specifications Tab -->
                    <div x-show="tab === 'specifications'" class="space-y-4">
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-gray-200">
                                @if($product->sku)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">SKU</td><td class="py-3 text-gray-800">{{ $product->sku }}</td></tr>
                                @endif
                                @if($product->material)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Material</td><td class="py-3 text-gray-800">{{ $product->material }}</td></tr>
                                @endif
                                @if($product->weight)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Weight</td><td class="py-3 text-gray-800">{{ $product->weight }}</td></tr>
                                @endif
                                @if($product->dimensions)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Dimensions</td><td class="py-3 text-gray-800">{{ $product->dimensions }}</td></tr>
                                @endif
                                @if($product->brand_name)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Brand</td><td class="py-3 text-gray-800">{{ $product->brand_name }}</td></tr>
                                @endif
                                @if($product->size && count($product->size) > 0)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Available Sizes</td><td class="py-3 text-gray-800">{{ implode(', ', $product->size) }}</td></tr>
                                @endif
                                @if($product->shop_by_raashi && count($product->shop_by_raashi) > 0)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Suitable Raashi</td><td class="py-3 text-gray-800">{{ implode(', ', $product->shop_by_raashi) }}</td></tr>
                                @endif
                                @if($product->shop_by_numerology && count($product->shop_by_numerology) > 0)
                                    <tr><td class="py-3 font-medium text-gray-500 w-44">Numerology</td><td class="py-3 text-gray-800">{{ implode(', ', $product->shop_by_numerology) }}</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Reviews Tab -->
                    <div x-show="tab === 'reviews'" class="space-y-6">
                        <p class="text-gray-600">Reviews coming soon.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="py-16 bg-pure-white">
        <div class="container max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-venlury font-bold text-royal-blue mb-4">
                    Related Sacred Items
                </h2>
                <p class="text-lg text-gray-600">
                    Complete your spiritual collection with these complementary items
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <div class="bg-pure-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        <a href="{{ route('products.show', $related->slug) }}">
                            <div class="relative">
                                <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : asset('images/karungulai.jpg') }}" alt="{{ $related->title }}" class="w-full aspect-square object-cover">
                                @if($related->discount_percentage > 0)
                                    <div class="absolute top-4 right-4 bg-divine-red text-pure-white px-2 py-1 rounded-full text-sm font-semibold">
                                        {{ $related->discount_percentage }}% OFF
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-venlury font-semibold text-royal-blue mb-2">
                                    {{ $related->title }}
                                </h3>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg font-bold text-royal-blue">₹{{ number_format($related->selling_price) }}</span>
                                        @if($related->cost_price > $related->selling_price)
                                            <span class="text-sm text-gray-500 line-through">₹{{ number_format($related->cost_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="block w-full bg-royal-blue text-pure-white py-2 px-4 rounded-full font-semibold hover:bg-deep-royal transition-all duration-300 text-center">
                                    View Product
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@include('partials.footer')
