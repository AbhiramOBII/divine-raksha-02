@php
    $seoTitle = (isset($category) ? $category->title . ' - Blog' : 'Sacred Wisdom Blog') . ' | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = isset($category) ? $category->short_description : 'Explore spiritual insights, Rudraksha guides, chakra healing tips, and sacred lifestyle articles from Divine Raksha.';
    $seoCanonical = isset($category) ? route('blogs.category', $category) : route('blogs.index');
@endphp

@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gradient-to-r from-royal-blue to-[#011455] py-12 sm:py-16">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-pure-white mb-3">
                {{ isset($category) ? $category->title : 'Sacred Wisdom Blog' }}
            </h1>
            <p class="text-pure-white/80 text-base sm:text-lg max-w-2xl mx-auto">
                {{ isset($category) ? $category->short_description : 'Explore spiritual insights, Rudraksha guides, and sacred lifestyle tips' }}
            </p>
            <!-- Breadcrumb -->
            <nav class="mt-6 flex items-center justify-center space-x-2 text-sm text-pure-white/60">
                <a href="{{ route('home') }}" class="hover:text-sacred-gold transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('blogs.index') }}" class="{{ isset($category) ? 'hover:text-sacred-gold transition-colors' : 'text-sacred-gold' }}">Blog</a>
                @if(isset($category))
                    <span>/</span>
                    <span class="text-sacred-gold">{{ $category->title }}</span>
                @endif
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-14 bg-gray-50">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Blog Grid -->
                <div class="flex-1">
                    @if($blogs->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($blogs as $blog)
                                <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                                    <a href="{{ route('blogs.show', $blog) }}" class="block">
                                        <div class="aspect-[16/10] overflow-hidden">
                                            @if($blog->thumbnail)
                                                <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @else
                                                <img src="{{ asset('images/blog-placeholder.jpg') }}" alt="{{ $blog->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @endif
                                        </div>
                                    </a>
                                    <div class="p-5">
                                        <div class="flex items-center gap-3 mb-3">
                                            @if($blog->category)
                                                <a href="{{ route('blogs.category', $blog->category) }}"
                                                   class="text-xs font-semibold text-sacred-gold bg-sacred-gold/10 px-2.5 py-1 rounded-full hover:bg-sacred-gold/20 transition-colors">
                                                    {{ $blog->category->title }}
                                                </a>
                                            @endif
                                            <span class="text-xs text-gray-400">{{ $blog->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <a href="{{ route('blogs.show', $blog) }}">
                                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-royal-blue transition-colors duration-300 line-clamp-2 mb-2">
                                                {{ $blog->title }}
                                            </h3>
                                        </a>
                                        @if($blog->short_description)
                                            <p class="text-sm text-gray-600 line-clamp-2">{{ $blog->short_description }}</p>
                                        @endif
                                        <a href="{{ route('blogs.show', $blog) }}" class="inline-flex items-center mt-4 text-sm font-medium text-royal-blue hover:text-sacred-gold transition-colors">
                                            Read More
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($blogs->hasPages())
                            <div class="mt-10">
                                {{ $blogs->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No blog posts yet</h3>
                            <p class="text-gray-500">Check back soon for spiritual insights and guides.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="w-full lg:w-72 shrink-0">
                    <!-- Categories -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('blogs.index') }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors {{ !isset($category) ? 'bg-royal-blue/5 text-royal-blue font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <span>All Posts</span>
                                    <span class="text-xs bg-gray-100 px-2 py-0.5 rounded-full">{{ $blogs->total() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('blogs.category', $cat) }}"
                                       class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors {{ (isset($category) && $category->id === $cat->id) ? 'bg-royal-blue/5 text-royal-blue font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <span>{{ $cat->title }}</span>
                                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->blogs_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-gradient-to-br from-royal-blue to-[#011455] rounded-xl p-6 text-center">
                        <div class="w-12 h-12 bg-sacred-gold rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-royal-blue text-2xl font-bold">ॐ</span>
                        </div>
                        <h3 class="text-lg font-venlury font-bold text-pure-white mb-2">Explore Our Collection</h3>
                        <p class="text-pure-white/70 text-sm mb-4">Discover authentic Rudraksha, Karungali malas, and sacred accessories.</p>
                        <a href="{{ route('products.index') }}" class="inline-block px-5 py-2 bg-sacred-gold text-royal-blue text-sm font-semibold rounded-full hover:bg-sacred-gold/90 transition-colors">
                            Shop Now
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

@include('partials.footer')
