<div class="group w-full" x-data="{ adding: false, added: false }">
    <div class="relative overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <!-- Image -->
            <div class="relative aspect-square overflow-hidden">
                @if($product->featured_image)
                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif

                <!-- Badges -->
                <div class="absolute top-2 left-2 flex flex-col gap-1">
                    @if($product->new_product)
                        <span class="px-2 py-0.5 bg-green-500 text-white text-xs font-semibold rounded-full">New</span>
                    @endif
                    @if($product->discount_percentage > 0)
                        <span class="px-2 py-0.5 bg-divine-red text-white text-xs font-semibold rounded-full">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 pb-2">
                <p class="text-xs text-sacred-gold font-medium mb-1">{{ $product->category->title ?? '' }}</p>
                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-2 group-hover:text-royal-blue transition-colors">{{ $product->title }}</h3>
                <div class="flex items-center gap-2">
                    <span class="text-lg font-bold text-royal-blue">₹{{ number_format($product->selling_price) }}</span>
                    @if($product->cost_price > $product->selling_price)
                        <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->cost_price) }}</span>
                    @endif
                </div>
            </div>
        </a>

        <!-- Add to Cart Button -->
        <div class="px-4 pb-4 pt-1">
            <button
                x-ref="cardCartBtn"
                @click.prevent="adding = true; flyToCart($refs.cardCartBtn, '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : '' }}'); fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ product_id: {{ $product->id }}, quantity: 1 })
                }).then(r => r.json()).then(d => {
                    adding = false; added = true;
                    showCartToast('{{ addslashes($product->title) }}', '{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('images/karungulai.jpg') }}', 1, d.cartCount);
                    setTimeout(() => added = false, 2000);
                }).catch(() => adding = false)"
                :disabled="adding"
                class="w-full py-2.5 rounded-lg text-xs sm:text-sm font-semibold transition-all duration-300 flex items-center justify-center gap-1.5"
                :class="added ? 'bg-green-500 text-white' : 'bg-royal-blue text-white hover:bg-deep-royal'"
            >
                <template x-if="!adding && !added">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                        Add to Cart
                    </span>
                </template>
                <template x-if="adding">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Adding...
                    </span>
                </template>
                <template x-if="added">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Added!
                    </span>
                </template>
            </button>
        </div>
    </div>
</div>
