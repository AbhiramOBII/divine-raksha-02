@php
    $seoTitle = 'Shop Authentic Rudraksha, Karungali Malas & Spiritual Accessories | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = 'Browse our collection of authentic Rudraksha beads, Karungali malas, spiritual bracelets, pendants and sacred accessories. Energized & blessed for divine protection.';
    $seoCanonical = route('products.index');
@endphp

@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Products</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <section class="py-8 sm:py-12" x-data="{ mobileFilters: false }">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- ===================================== -->
                <!-- LEFT: Filters Sidebar                 -->
                <!-- ===================================== -->
                
                <!-- Mobile Filter Toggle -->
                <div class="lg:hidden">
                    <button @click="mobileFilters = !mobileFilters" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-royal-blue text-white rounded-lg font-medium text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span x-text="mobileFilters ? 'Hide Filters' : 'Show Filters'"></span>
                    </button>
                </div>

                <!-- Sidebar -->
                <aside class="lg:w-72 flex-shrink-0" :class="mobileFilters ? '' : 'hidden lg:block'">
                    <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-4">
                            <!-- Filter Header -->
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 text-base">Filters</h3>
                                <a href="{{ route('products.index') }}" class="text-xs text-divine-red hover:underline font-medium">Clear All</a>
                            </div>

                            <!-- Category Filter -->
                            <div class="border-b border-gray-100" x-data="{ open: true }">
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800">Category</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-collapse class="px-5 pb-4 space-y-2">
                                    @foreach($categories as $category)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="radio" name="category" value="{{ $category->id }}"
                                                   {{ request('category') == $category->id ? 'checked' : '' }}
                                                   class="w-4 h-4 text-royal-blue border-gray-300 focus:ring-royal-blue">
                                            <span class="text-sm text-gray-600 group-hover:text-royal-blue transition-colors">{{ $category->title }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Attribute Filter -->
                            <div class="border-b border-gray-100" x-data="{ open: true }">
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800">Attribute</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-collapse class="px-5 pb-4 space-y-2">
                                    @foreach($attributes as $attr)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="checkbox" name="attribute[]" value="{{ $attr }}"
                                                   {{ in_array($attr, (array) request('attribute')) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                                            <span class="text-sm text-gray-600 group-hover:text-royal-blue transition-colors">{{ $attr }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Size Filter -->
                            <div class="border-b border-gray-100" x-data="{ open: true }">
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800">Size</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-collapse class="px-5 pb-4 space-y-2">
                                    @foreach($sizes as $size)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="checkbox" name="size[]" value="{{ $size }}"
                                                   {{ in_array($size, (array) request('size')) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                                            <span class="text-sm text-gray-600 group-hover:text-royal-blue transition-colors">{{ $size }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Purpose Filter -->
                            <div class="border-b border-gray-100" x-data="{ open: false }">
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800">Purpose</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-collapse class="px-5 pb-4 space-y-2">
                                    @foreach($purposes as $purpose)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="checkbox" name="purpose[]" value="{{ $purpose }}"
                                                   {{ in_array($purpose, (array) request('purpose')) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                                            <span class="text-sm text-gray-600 group-hover:text-royal-blue transition-colors">{{ $purpose }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Raashi Filter -->
                            <div class="border-b border-gray-100" x-data="{ open: false }">
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800">Raashi</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-collapse class="px-5 pb-4 space-y-2">
                                    @foreach($raashis as $raashi)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="checkbox" name="raashi[]" value="{{ $raashi }}"
                                                   {{ in_array($raashi, (array) request('raashi')) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                                            <span class="text-sm text-gray-600 group-hover:text-royal-blue transition-colors">{{ $raashi }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Numerology Filter -->
                            <div x-data="{ open: false }">
                                <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                                    <span class="text-sm font-semibold text-gray-800">Numerology</span>
                                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" x-collapse class="px-5 pb-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($numerology as $num)
                                            <label class="cursor-pointer">
                                                <input type="checkbox" name="numerology[]" value="{{ $num }}" class="hidden peer"
                                                       {{ in_array($num, (array) request('numerology')) ? 'checked' : '' }}>
                                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 peer-checked:bg-royal-blue peer-checked:text-white peer-checked:border-royal-blue hover:border-royal-blue transition-all">{{ $num }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Apply Button -->
                            <div class="px-5 py-4 border-t border-gray-100">
                                <button type="submit" class="w-full py-2.5 bg-royal-blue text-white text-sm font-semibold rounded-lg hover:bg-deep-royal transition-colors">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </aside>

                <!-- ===================================== -->
                <!-- RIGHT: Product Grid                    -->
                <!-- ===================================== -->
                <div class="flex-1 min-w-0">
                    <!-- Top Bar: Count + Sort -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-semibold text-gray-900">{{ $products->total() }}</span> products
                        </p>
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-500">Sort by:</label>
                            <select onchange="window.location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    @if($products->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                            @foreach($products as $product)
                                <div>
                                    @include('partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-10">
                            {{ $products->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-20">
                            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-500 mb-6">Try adjusting your filters to find what you're looking for.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-5 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                                Clear All Filters
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
