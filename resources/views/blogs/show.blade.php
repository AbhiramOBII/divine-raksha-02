@php
    $seoTitle = ($blog->meta_title ?: $blog->title) . ' | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = $blog->meta_description ?: Str::limit(strip_tags($blog->short_description ?: $blog->full_description), 160);
    $seoType = 'article';
    $seoImage = $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : asset('images/blog-placeholder.jpg');
    $seoCanonical = route('blogs.show', $blog);
    $seoSchema = '<script type="application/ld+json">' . json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $blog->title,
        'description' => $seoDescription,
        'image' => $seoImage,
        'datePublished' => $blog->created_at->toIso8601String(),
        'dateModified' => $blog->updated_at->toIso8601String(),
        'author' => ['@type' => 'Organization', 'name' => setting('site_name', 'Divine Raksha')],
        'publisher' => ['@type' => 'Organization', 'name' => setting('site_name', 'Divine Raksha'), 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')]],
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $seoCanonical],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
@endphp

@include('partials.header')

    <!-- Breadcrumb Banner -->
    <div class="bg-gradient-to-r from-royal-blue to-[#011455] py-8 sm:py-10">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <nav class="flex items-center space-x-2 text-sm text-pure-white/60">
                <a href="{{ route('home') }}" class="hover:text-sacred-gold transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('blogs.index') }}" class="hover:text-sacred-gold transition-colors">Blog</a>
                @if($blog->category)
                    <span>/</span>
                    <a href="{{ route('blogs.category', $blog->category) }}" class="hover:text-sacred-gold transition-colors">{{ $blog->category->title }}</a>
                @endif
                <span>/</span>
                <span class="text-sacred-gold line-clamp-1">{{ Str::limit($blog->title, 40) }}</span>
            </nav>
        </div>
    </div>

    <article class="py-10 sm:py-14 bg-gray-50">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Main Content -->
                <div class="flex-1 max-w-none">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Featured Image -->
                        <div class="aspect-[21/9] overflow-hidden">
                            @if($blog->thumbnail)
                                <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/blog-placeholder.jpg') }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="p-6 sm:p-8 lg:p-10">
                            <!-- Meta -->
                            <div class="flex flex-wrap items-center gap-3 mb-5">
                                @if($blog->category)
                                    <a href="{{ route('blogs.category', $blog->category) }}"
                                       class="text-xs font-semibold text-sacred-gold bg-sacred-gold/10 px-3 py-1 rounded-full hover:bg-sacred-gold/20 transition-colors">
                                        {{ $blog->category->title }}
                                    </a>
                                @endif
                                <span class="text-sm text-gray-400">{{ $blog->created_at->format('F d, Y') }}</span>
                            </div>

                            <!-- Title -->
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-venlury font-bold text-gray-900 mb-6 leading-tight">
                                {{ $blog->title }}
                            </h1>

                            @if($blog->short_description)
                                <p class="text-lg text-gray-600 mb-8 border-l-4 border-sacred-gold pl-4 italic">
                                    {{ $blog->short_description }}
                                </p>
                            @endif

                            <!-- Content -->
                            <div class="prose prose-lg max-w-none
                                        prose-headings:font-venlury prose-headings:text-royal-blue
                                        prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4
                                        prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3
                                        prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-4
                                        prose-a:text-royal-blue prose-a:underline hover:prose-a:text-sacred-gold
                                        prose-ul:my-4 prose-li:text-gray-700
                                        prose-strong:text-gray-900
                                        prose-blockquote:border-sacred-gold prose-blockquote:bg-gray-50 prose-blockquote:rounded-r-lg prose-blockquote:py-2">
                                {!! $blog->full_description !!}
                            </div>

                            <!-- Share -->
                            <div class="mt-10 pt-6 border-t border-gray-100">
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-600">Share this article:</span>
                                    <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . route('blogs.show', $blog)) }}" target="_blank" rel="noopener"
                                       class="w-9 h-9 flex items-center justify-center rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blogs.show', $blog)) }}" target="_blank" rel="noopener"
                                       class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(route('blogs.show', $blog)) }}" target="_blank" rel="noopener"
                                       class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-800 text-white hover:bg-gray-900 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($relatedBlogs->count() > 0)
                        <div class="mt-10">
                            <h2 class="text-2xl font-venlury font-bold text-gray-900 mb-6">Related Articles</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($relatedBlogs as $related)
                                    <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                                        <a href="{{ route('blogs.show', $related) }}" class="block">
                                            <div class="aspect-[16/10] overflow-hidden">
                                                @if($related->thumbnail)
                                                    <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->title }}"
                                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <img src="{{ asset('images/blog-placeholder.jpg') }}" alt="{{ $related->title }}"
                                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @endif
                                            </div>
                                        </a>
                                        <div class="p-4">
                                            <span class="text-xs text-gray-400">{{ $related->created_at->format('M d, Y') }}</span>
                                            <a href="{{ route('blogs.show', $related) }}">
                                                <h3 class="text-base font-semibold text-gray-900 group-hover:text-royal-blue transition-colors line-clamp-2 mt-1">
                                                    {{ $related->title }}
                                                </h3>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="w-full lg:w-72 shrink-0">
                    <!-- Categories -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                        <ul class="space-y-2">
                            @php
                                $sideCategories = \App\Models\BlogCategory::active()->withCount('blogs')->orderBy('title')->get();
                            @endphp
                            @foreach($sideCategories as $cat)
                                <li>
                                    <a href="{{ route('blogs.category', $cat) }}"
                                       class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors {{ ($blog->category_id === $cat->id) ? 'bg-royal-blue/5 text-royal-blue font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <span>{{ $cat->title }}</span>
                                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->blogs_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- CTA -->
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
    </article>

@include('partials.footer')
