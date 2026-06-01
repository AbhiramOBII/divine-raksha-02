@include('partials.header')

    <!-- ============================================ -->
    <!-- Offer Marquee                                -->
    <!-- ============================================ -->
    @if(setting('marquee_enabled') == '1' && setting('marquee_text'))
    <div class="bg-gradient-to-r from-sacred-gold via-yellow-500 to-sacred-gold overflow-hidden">
        <div class="marquee-container py-2">
            <div class="marquee-content">
                @php
                    $messages = array_map('trim', explode('|', setting('marquee_text')));
                @endphp
                @foreach($messages as $msg)
                    <span class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-900 whitespace-nowrap px-8">
                        <span class="text-divine-red">&#9733;</span>
                        {{ $msg }}
                    </span>
                @endforeach
                @foreach($messages as $msg)
                    <span class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-900 whitespace-nowrap px-8">
                        <span class="text-divine-red">&#9733;</span>
                        {{ $msg }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .marquee-container { width: 100%; overflow: hidden; }
        .marquee-content {
            display: inline-flex;
            animation: marquee-scroll 30s linear infinite;
        }
        .marquee-content:hover { animation-play-state: paused; }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>
    @endif

    <!-- ============================================ -->
    <!-- ROW 1: Hero Slider                           -->
    <!-- ============================================ -->
    <section class="relative">
        @php
            $slideData = $sliders->map(function($s) {
                return [
                    'image' => asset('storage/' . $s->image),
                    'title' => $s->title,
                    'description' => $s->description ?? '',
                    'cta' => $s->cta_title ?? '',
                    'link' => $s->cta_link ?? '#',
                ];
            })->values()->toArray();

            // Fallback if no sliders in DB
            if (empty($slideData)) {
                $slideData = [
                    [
                        'image' => asset('images/Slider-01.jpg'),
                        'title' => 'Divine Protection for Your Sacred Journey',
                        'description' => 'Authentic Rudraksha, Gemstones & Spiritual Artifacts',
                        'cta' => 'Explore Collection',
                        'link' => '#',
                    ]
                ];
            }
        @endphp
        <div x-data="{
            current: 0,
            slides: {{ Js::from($slideData) }},
            init() {
                if (this.slides.length > 1) {
                    setInterval(() => { this.current = (this.current + 1) % this.slides.length }, 5000);
                }
            }
        }" class="relative h-[400px] sm:h-[500px] lg:h-[600px] overflow-hidden">
            <!-- Slides -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="current === index"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute inset-0">
                    <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-royal-blue/80 via-royal-blue/50 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="container max-w-7xl mx-auto px-6 sm:px-8">
                            <div class="max-w-xl">
                                <p class="text-sacred-gold font-medium text-sm sm:text-base mb-3 tracking-wider uppercase" x-text="slide.description"></p>
                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-pure-white leading-tight mb-6" x-text="slide.title"></h1>
                                <template x-if="slide.cta">
                                    <a :href="slide.link" class="inline-flex items-center px-6 py-3 bg-sacred-gold text-royal-blue font-semibold rounded-full hover:bg-sacred-gold/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                                        <span x-text="slide.cta"></span>
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Dots -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                <template x-for="(slide, index) in slides" :key="'dot-'+index">
                    <button @click="current = index"
                            :class="current === index ? 'bg-sacred-gold w-8' : 'bg-white/50 w-3 hover:bg-white/80'"
                            class="h-3 rounded-full transition-all duration-300"></button>
                </template>
            </div>

            <!-- Arrows -->
            <button @click="current = (current - 1 + slides.length) % slides.length"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 backdrop-blur-sm text-white rounded-full flex items-center justify-center hover:bg-white/40 transition-colors z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="current = (current + 1) % slides.length"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 backdrop-blur-sm text-white rounded-full flex items-center justify-center hover:bg-white/40 transition-colors z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- ROW 2: Bestsellers Carousel                  -->
    <!-- ============================================ -->
    @if($bestsellers->count() > 0)
    <section class="py-12 sm:py-16 new-om-bg">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-10">
                <p class="text-sacred-gold text-sm font-semibold tracking-widest uppercase mb-2">Most Loved</p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-venlury font-bold text-royal-blue">Our Bestsellers</h2>
                <div class="w-16 h-1 bg-sacred-gold mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Carousel -->
            <div x-data="{
                scrollContainer: null,
                init() { this.scrollContainer = this.$refs.carousel; },
                scrollLeft() { this.scrollContainer.scrollBy({left: -(this.scrollContainer.offsetWidth / 4 + 20), behavior: 'smooth'}); },
                scrollRight() { this.scrollContainer.scrollBy({left: (this.scrollContainer.offsetWidth / 4 + 20), behavior: 'smooth'}); }
            }">
                <div class="relative">
                    <div x-ref="carousel" class="flex gap-5 overflow-x-auto pb-4 scroll-smooth snap-x snap-mandatory" style="-ms-overflow-style:none;scrollbar-width:none;-webkit-overflow-scrolling:touch;">
                        @foreach($bestsellers as $product)
                            <div class="snap-start flex-shrink-0 w-[48%] sm:w-[31%] lg:w-[calc(25%-15px)]">
                                @include('partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                    <!-- Scroll Buttons -->
                    <button @click="scrollLeft()"
                            class="hidden sm:flex absolute -left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white shadow-lg text-royal-blue rounded-full items-center justify-center hover:bg-royal-blue hover:text-white transition-colors z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="scrollRight()"
                            class="hidden sm:flex absolute -right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white shadow-lg text-royal-blue rounded-full items-center justify-center hover:bg-royal-blue hover:text-white transition-colors z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ============================================ -->
    <!-- ROW 3: Shop by Purpose                       -->
    <!-- ============================================ -->
    <section class="py-12 sm:py-16 lg:py-20 new-om-bg">
            <div class="container max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
                <div class="text-center mb-10 sm:mb-14">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                        <span class="text-sacred-gold text-2xl">ॐ</span>
                        <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-royal-blue mb-3 sm:mb-4">
                        Shop By Purpose
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                        Find the perfect spiritual solution for your specific needs
                    </p>
                </div>

                <!-- Purpose Icons Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4 sm:gap-5 lg:gap-6 max-w-7xl mx-auto">
                    <!-- Wealth -->
                    <a href="{{ route('shop.purpose', 'Wealth') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Wealth</span>
                    </a>

                    <!-- Love -->
                    <a href="{{ route('shop.purpose', 'Love') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Love</span>
                    </a>

                    <!-- Health -->
                    <a href="{{ route('shop.purpose', 'Health') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Health</span>
                    </a>

                    <!-- Luck -->
                    <a href="{{ route('shop.purpose', 'Luck') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l2.4 7.4h7.6l-6 4.6 2.3 7-6.3-4.7-6.3 4.7 2.3-7-6-4.6h7.6z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Luck</span>
                    </a>

                    <!-- Protection -->
                    <a href="{{ route('shop.purpose', 'Protection') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Protection</span>
                    </a>

                    <!-- Peace -->
                    <a href="{{ route('shop.purpose', 'Peace') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Peace</span>
                    </a>

                    <!-- Courage -->
                    <a href="{{ route('shop.purpose', 'Courage') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Courage</span>
                    </a>

                    <!-- Balance -->
                    <a href="{{ route('shop.purpose', 'Balance') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-9 sm:h-9 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm6 9.09c0 4-2.55 7.7-6 8.83-3.45-1.13-6-4.82-6-8.83V6.31l6-2.12 6 2.12v4.78z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Balance</span>
                    </a>
                </div>
            </div>
        </section>

    <!-- ============================================ -->
    <!-- ROW 4: Shop by Raashi                        -->
    <!-- ============================================ -->
    <section class="py-12 sm:py-16 lg:py-20 bg-soft-grey">
            <div class="container mx-auto px-4 sm:px-6 relative z-10">
                <div class="text-center mb-10 sm:mb-14">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                        <span class="text-sacred-gold text-2xl">ॐ</span>
                        <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-royal-blue mb-3 sm:mb-4">
                        Shop By Raashi
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                        Discover sacred items aligned with your Hindu zodiac sign
                    </p>
                </div>

                <!-- Raashi Icons Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-5 lg:gap-6 max-w-5xl mx-auto">
                    <!-- Mesha (Aries) -->
                    <a href="{{ route('shop.raashi', 'mesha') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/aries.svg') }}" alt="Mesha" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Mesha</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Aries</span>
                    </a>

                    <!-- Vrishabha (Taurus) -->
                    <a href="{{ route('shop.raashi', 'vrishabha') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/taurus.svg') }}" alt="Vrishabha" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Vrishabha</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Taurus</span>
                    </a>

                    <!-- Mithuna (Gemini) -->
                    <a href="{{ route('shop.raashi', 'mithuna') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/gemini.svg') }}" alt="Mithuna" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Mithuna</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Gemini</span>
                    </a>

                    <!-- Karka (Cancer) -->
                    <a href="{{ route('shop.raashi', 'karka') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/cancer.svg') }}" alt="Karka" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Karka</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Cancer</span>
                    </a>

                    <!-- Simha (Leo) -->
                    <a href="{{ route('shop.raashi', 'simha') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/leo.svg') }}" alt="Simha" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Simha</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Leo</span>
                    </a>

                    <!-- Kanya (Virgo) -->
                    <a href="{{ route('shop.raashi', 'kanya') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/virgo.svg') }}" alt="Kanya" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Kanya</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Virgo</span>
                    </a>

                    <!-- Tula (Libra) -->
                    <a href="{{ route('shop.raashi', 'tula') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/libra.svg') }}" alt="Tula" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Tula</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Libra</span>
                    </a>

                    <!-- Vrischika (Scorpio) -->
                    <a href="{{ route('shop.raashi', 'vrischika') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/scorpio.svg') }}" alt="Vrishchika" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Vrishchika</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Scorpio</span>
                    </a>

                    <!-- Dhanu (Sagittarius) -->
                    <a href="{{ route('shop.raashi', 'dhanu') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/sagittarius.svg') }}" alt="Dhanu" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Dhanu</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Sagittarius</span>
                    </a>

                    <!-- Makara (Capricorn) -->
                    <a href="{{ route('shop.raashi', 'makara') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/capricorn.svg') }}" alt="Makara" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Makara</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Capricorn</span>
                    </a>

                    <!-- Kumbha (Aquarius) -->
                    <a href="{{ route('shop.raashi', 'kumbha') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/aquarius.svg') }}" alt="Kumbha" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Kumbha</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Aquarius</span>
                    </a>

                    <!-- Meena (Pisces) -->
                    <a href="{{ route('shop.raashi', 'meena') }}" class="flex flex-col items-center group">
                        <div class="relative mb-3 transition-all duration-300 group-hover:-translate-y-1">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-28 lg:h-28 rounded-xl bg-white flex items-center justify-center shadow-md border border-gray-100 group-hover:shadow-xl group-hover:border-sacred-gold/40 transition-all duration-300">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                                    <img src="{{ asset('images/pisces.svg') }}" alt="Meena" class="w-8 h-8 sm:w-9 sm:h-9">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-royal-blue transition-colors duration-300">Meena</span>
                        <span class="text-[10px] sm:text-xs text-gray-400">Pisces</span>
                    </a>
                </div>
            </div>
        </section>

    <!-- ============================================ -->
    <!-- ROW 5: Shop by Numerology                    -->
    <!-- ============================================ -->
    <section class="py-12 sm:py-16 lg:py-20 new-om-bg">
            <div class="container mx-auto px-4 sm:px-6 relative z-10">
                <div class="text-center mb-10 sm:mb-14">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                        <span class="text-sacred-gold text-2xl">ॐ</span>
                        <span class="block w-12 sm:w-16 h-px bg-sacred-gold"></span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-royal-blue mb-3 sm:mb-4">
                        Shop By Numerology
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto px-4">
                        Find sacred items matching your ruling number and cosmic vibration
                    </p>
                </div>

                <!-- Numerology Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 max-w-6xl mx-auto">
                    <!-- Number 1 -->
                    <a href="{{ route('shop.numerology', 1) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">1</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 1</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Leadership, Independence, Ambition, Individuality</p>
                        </div>
                    </a>

                    <!-- Number 2 -->
                    <a href="{{ route('shop.numerology', 2) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">2</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 2</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Partnership, Sensitivity, Balance, Diplomacy</p>
                        </div>
                    </a>

                    <!-- Number 3 -->
                    <a href="{{ route('shop.numerology', 3) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">3</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 3</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Creativity, Expression, Joy, Communication</p>
                        </div>
                    </a>

                    <!-- Number 4 -->
                    <a href="{{ route('shop.numerology', 4) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">4</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 4</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Discipline, Stability, Hard Work, Structure</p>
                        </div>
                    </a>

                    <!-- Number 5 -->
                    <a href="{{ route('shop.numerology', 5) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">5</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 5</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Freedom, Adventure, Change, Versatility</p>
                        </div>
                    </a>

                    <!-- Number 6 -->
                    <a href="{{ route('shop.numerology', 6) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">6</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 6</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Responsibility, Family, Care, Harmony</p>
                        </div>
                    </a>

                    <!-- Number 7 -->
                    <a href="{{ route('shop.numerology', 7) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">7</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 7</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Spirituality, Introspection, Wisdom, Analysis</p>
                        </div>
                    </a>

                    <!-- Number 8 -->
                    <a href="{{ route('shop.numerology', 8) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">8</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 8</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Power, Success, Authority, Material Growth</p>
                        </div>
                    </a>

                    <!-- Number 9 -->
                    <a href="{{ route('shop.numerology', 9) }}" class="group flex items-center gap-4 bg-white rounded-xl p-4 sm:p-5 shadow-md border border-gray-100 hover:shadow-xl hover:border-sacred-gold/40 transition-all duration-300 hover:-translate-y-0.5">
                        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg bg-gradient-to-br from-royal-blue to-[#011455] flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-venlury font-bold text-sacred-gold">9</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm sm:text-base font-semibold text-royal-blue group-hover:text-sacred-gold transition-colors duration-300">Number 9</p>
                            <p class="text-xs sm:text-sm text-gray-500 leading-snug">Compassion, Completion, Service, Humanity</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

    <!-- ============================================ -->
    <!-- Meet Our Founders                            -->
    <!-- ============================================ -->
    <section class="py-16 om-background">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10 sm:mb-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-venlury font-bold text-pure-white mb-4">
                    Meet Our Founders
                </h2>
                <p class="text-base sm:text-lg text-pure-white/80 max-w-3xl mx-auto">
                    United by their deep devotion to Sanatana Dharma, our founders embarked on a sacred mission to bring authentic spiritual protection and divine blessings to seekers worldwide.
                </p>
            </div>

            <!-- Three Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center max-w-7xl mx-auto">
                <!-- Column 1: Rajesh Photo -->
                <div class="flex justify-center">
                    <div class="relative">
                        <img src="{{ asset('images/rajesh-rj.png') }}" alt="RJ Rajesh - Co-Founder" class="w-72 h-72 sm:w-96 sm:h-96 object-cover rounded-lg shadow-lg">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-royal-blue/90 to-transparent p-4 rounded-b-lg">
                            <h3 class="text-xl font-venlury font-bold text-pure-white mb-1">RJ Rajesh</h3>
                            <p class="text-sacred-gold font-semibold text-sm">Co-Founder &amp; Spiritual Guide</p>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Common Content -->
                <div class="text-center px-4 sm:px-6">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-sacred-gold rounded-full flex items-center justify-center">
                            <span class="text-royal-blue text-3xl font-bold">ॐ</span>
                        </div>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-venlury font-bold text-pure-white mb-6">Our Sacred Mission</h3>
                    <p class="text-pure-white/90 text-base sm:text-lg leading-relaxed mb-6">
                        United by their deep devotion to Sanatana Dharma, Rajesh and Akshay embarked on a sacred mission to bring authentic spiritual protection and divine blessings to seekers worldwide.
                    </p>
                    <p class="text-pure-white/80 leading-relaxed mb-8">
                        Together, they combine ancient Vedic wisdom with modern accessibility, ensuring every sacred artifact carries genuine divine energy and reaches those who seek spiritual protection and growth.
                    </p>
                    <div class="flex items-center justify-center gap-6 sm:gap-8 text-sm text-pure-white/70">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sacred-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            Authentic Blessings
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sacred-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Global Reach
                        </span>
                    </div>
                </div>

                <!-- Column 3: Akshay Photo -->
                <div class="flex justify-center">
                    <div class="relative">
                        <img src="{{ asset('images/Akshay-vasu-new.png') }}" alt="Akshay Vasu - Co-Founder" class="w-72 h-72 sm:w-96 sm:h-96 object-cover rounded-lg shadow-lg">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-royal-blue/90 to-transparent p-4 rounded-b-lg">
                            <h3 class="text-xl font-venlury font-bold text-pure-white mb-1">Akshay Vasu</h3>
                            <p class="text-sacred-gold font-semibold text-sm">Co-Founder &amp; Business Visionary</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Founders Mission Statement -->
            <div class="mt-12 sm:mt-16 text-center">
                <div class="bg-pure-white rounded-lg shadow-lg p-6 sm:p-8 max-w-4xl mx-auto">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-12 h-12 bg-sacred-gold rounded-full flex items-center justify-center">
                            <span class="text-royal-blue text-2xl font-bold">ॐ</span>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-venlury font-bold text-royal-blue mb-4">Our Sacred Mission</h3>
                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-6">
                        "Together, we are committed to preserving the sacred traditions of Sanatana Dharma while making authentic spiritual protection accessible to modern seekers. Every artifact we offer is blessed with genuine intention and carries the divine energy needed for your spiritual journey."
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-8 text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sacred-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            Authentic Blessings
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sacred-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Verified Authenticity
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-sacred-gold" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Global Reach
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- Latest from Our Blog                         -->
    <!-- ============================================ -->
    @if($latestBlogs->count() > 0)
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-10">
                <p class="text-sacred-gold text-sm font-semibold tracking-widest uppercase mb-2">Sacred Wisdom</p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-venlury font-bold text-royal-blue">Latest from Our Blog</h2>
                <div class="w-16 h-1 bg-sacred-gold mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Blog Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestBlogs as $blog)
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
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center gap-2 mb-2">
                                @if($blog->category)
                                    <span class="text-xs font-semibold text-sacred-gold bg-sacred-gold/10 px-2 py-0.5 rounded-full">
                                        {{ $blog->category->title }}
                                    </span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $blog->created_at->format('M d, Y') }}</span>
                            </div>
                            <a href="{{ route('blogs.show', $blog) }}">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 group-hover:text-royal-blue transition-colors duration-300 line-clamp-2 mb-2">
                                    {{ $blog->title }}
                                </h3>
                            </a>
                            @if($blog->short_description)
                                <p class="text-xs text-gray-500 line-clamp-2">{{ $blog->short_description }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- View All -->
            <div class="text-center mt-8 sm:mt-10">
                <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-royal-blue text-royal-blue font-semibold rounded-full hover:bg-royal-blue hover:text-white transition-all duration-300">
                    View All Articles
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

@include('partials.footer')
