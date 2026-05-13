@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Shop by Numerology</span>
            </nav>
        </div>
    </div>

    <section class="py-8 sm:py-12" x-data="{ mobileFilters: false }">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Mobile Filter Toggle -->
                <div class="lg:hidden">
                    <button @click="mobileFilters = !mobileFilters" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-royal-blue text-white rounded-lg font-medium text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span x-text="mobileFilters ? 'Hide Filters' : 'Show Filters'"></span>
                    </button>
                </div>

                <!-- LEFT: Filter Sidebar -->
                <aside class="lg:w-64 flex-shrink-0" :class="mobileFilters ? '' : 'hidden lg:block'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-4">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900 text-base">Shop by Numerology</h3>
                        </div>
                        <div class="p-4 space-y-2">
                            <!-- All -->
                            <a href="{{ route('shop.numerology') }}" class="flex items-center justify-center w-full py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ !$number ? 'bg-royal-blue text-white' : 'hover:bg-gray-50 text-gray-700 border border-gray-200' }}">
                                All Numbers
                            </a>
                            <div class="grid grid-cols-3 gap-2 pt-2">
                                @foreach($numbers as $num)
                                    <a href="{{ route('shop.numerology', $num) }}" class="flex items-center justify-center w-full aspect-square rounded-xl text-lg font-bold transition-all duration-200 {{ $number == $num ? 'bg-royal-blue text-white shadow-md' : 'bg-gray-50 text-royal-blue hover:bg-royal-blue/10 border border-gray-200' }}">
                                        {{ $num }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- RIGHT: Product Grid -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-semibold text-gray-900">{{ $products->total() }}</span> products
                            @if($number)
                                for <span class="font-semibold text-royal-blue">Number {{ $number }}</span>
                            @endif
                        </p>
                    </div>

                    @if($products->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                            @foreach($products as $product)
                                @include('partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                        <div class="mt-10">{{ $products->links() }}</div>
                    @else
                        <div class="text-center py-20">
                            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-500">No products available for this number yet.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
