@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Best Sellers</span>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <section class="py-12 sm:py-16 new-om-bg">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                    <span class="text-sacred-gold text-2xl">ॐ</span>
                    <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-royal-blue mb-3 sm:mb-4">
                    Best Sellers
                </h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                    Our most loved sacred items, chosen by devotees worldwide
                </p>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-10 sm:py-14">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-gray-600">Showing <span class="font-semibold text-gray-900">{{ $products->total() }}</span> best selling products</p>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-10">{{ $products->links() }}</div>
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No bestsellers yet</h3>
                    <p class="text-gray-500 mb-6">Check back soon for our most popular items.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-5 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">Browse All Products</a>
                </div>
            @endif
        </div>
    </section>

@include('partials.footer')
