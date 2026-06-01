<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $seoTitle = $seoTitle ?? setting('site_name', 'Divine Raksha') . ' - ' . setting('site_description', 'Sacred Protection & Spiritual Balance');
        $seoDescription = $seoDescription ?? setting('site_description', 'Authentic Rudraksha, Karungali Malas & Spiritual Accessories for Sacred Protection & Spiritual Balance');
        $seoKeywords = $seoKeywords ?? setting('site_keywords', 'rudraksha, karungali mala, spiritual accessories, sacred protection, gemstones, divine raksha');
        $seoCanonical = $seoCanonical ?? url()->current();
        $seoImage = $seoImage ?? asset('images/og-default.jpg');
        $seoType = $seoType ?? 'website';
        $seoRobots = $seoRobots ?? 'index, follow';
    @endphp

    {{-- Dynamic SEO Title --}}
    <title>{{ $seoTitle }}</title>

    {{-- Meta Description --}}
    <meta name="description" content="{{ $seoDescription }}">

    {{-- Meta Keywords --}}
    <meta name="keywords" content="{{ $seoKeywords }}">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $seoCanonical }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:site_name" content="{{ setting('site_name', 'Divine Raksha') }}">
    <meta property="og:locale" content="en_IN">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    {{-- Additional SEO --}}
    <meta name="robots" content="{{ $seoRobots }}">
    <meta name="author" content="{{ setting('site_name', 'Divine Raksha') }}">
    <meta name="theme-color" content="#1e3a8a">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- JSON-LD Organization Schema --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "{{ setting('site_name', 'Divine Raksha') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "description": "{{ setting('site_description', 'Sacred Protection & Spiritual Balance') }}",
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "{{ setting('phone', '') }}",
            "contactType": "customer service",
            "availableLanguage": ["English", "Hindi", "Tamil"]
        },
        "sameAs": [
            "{{ setting('facebook_url', '') }}",
            "{{ setting('instagram_url', '') }}",
            "{{ setting('youtube_url', '') }}"
        ]
    }
    </script>

    {!! $seoSchema ?? '' !!}

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'royal-blue': '#1e3a8a',
                        'deep-royal': '#1e40af',
                        'sacred-gold': '#d4af37',
                        'divine-red': '#dc2626',
                        'pure-white': '#ffffff',
                        'soft-grey': '#f8fafc'
                    },
                    fontFamily: {
                        'venlury': ['Playfair Display', 'serif'],
                        'coolvetica': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .sacred-glow {
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }
        .divine-gradient {
               background: linear-gradient(135deg, #1e3a8a 0%, #011455 100%);
        }
        .om-background {
            background: linear-gradient(135deg, #1e3a8a 0%, #011455 100%);
            position: relative;
        }
        .om-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("images/om.svg");
            background-size: 60px 60px;
            background-repeat: repeat;
            opacity: 0.05;
            pointer-events: none;
        }

        .new-om-bg 
        {
            background: linear-gradient(135deg, #ebebec 0%, #fdfdff 100%);
            position: relative;
        }

        .new-om-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("images/om.svg");
            background-size: 60px 60px;
            background-repeat: repeat;
            opacity: 0.05;
            pointer-events: none;
        }


        .om-symbol::before {
            content: "ॐ";
            font-size: 1.2rem;
            color: #d4af37;
            margin-right: 0.5rem;
        }

        /* Mobile-specific utilities */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Mobile menu animation */
        .mobile-menu-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .mobile-menu-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 300ms, transform 300ms;
        }

        /* Responsive hero height */
        @media (max-width: 640px) {
            .hero-mobile {
                height: 350px !important;
                min-height: 350px !important;
            }
        }

        /* Cart animations */
        @keyframes cartBounce {
            0% { transform: scale(1); }
            20% { transform: scale(1.35) rotate(-5deg); }
            40% { transform: scale(0.85) rotate(3deg); }
            60% { transform: scale(1.2) rotate(-2deg); }
            80% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
        @keyframes badgePop {
            0% { transform: scale(0) rotate(-45deg); opacity: 0; }
            60% { transform: scale(1.5) rotate(10deg); opacity: 1; }
            80% { transform: scale(0.85) rotate(-5deg); }
            100% { transform: scale(1) rotate(0); opacity: 1; }
        }
        @keyframes cartGlow {
            0% { box-shadow: 0 0 0 0 rgba(212,175,55,0.6); }
            50% { box-shadow: 0 0 20px 10px rgba(212,175,55,0.3); }
            100% { box-shadow: 0 0 0 0 rgba(212,175,55,0); }
        }
        @keyframes sparkle {
            0% { transform: translate(0,0) scale(1); opacity: 1; }
            100% { opacity: 0; }
        }
        @keyframes rippleOut {
            0% { transform: scale(0.5); opacity: 0.6; }
            100% { transform: scale(3); opacity: 0; }
        }
        @keyframes successPulse {
            0% { box-shadow: 0 0 0 0 rgba(34,197,94,0.5); }
            70% { box-shadow: 0 0 0 15px rgba(34,197,94,0); }
            100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
        }
        .cart-bounce { animation: cartBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .badge-pop { animation: badgePop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .cart-glow { animation: cartGlow 0.8s ease-out; border-radius: 50%; }
        .success-pulse { animation: successPulse 0.8s ease-out; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-pure-white font-coolvetica">
    <!-- Header -->
    <header class="relative z-50">
        <!-- Top Bar -->
        <div class="bg-[#cc1b1a] border-b border-sacred-gold/20">
            <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-2">
                <div class="flex items-center justify-between text-xs sm:text-sm">
                    <!-- Contact Info -->
                    <div class="flex items-center space-x-2 sm:space-x-6">
                        <div class="flex items-center space-x-1 sm:space-x-2 text-pure-white/80">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>{{ setting('site_phone', '+91 98765 43210') }}</span>
                        </div>
                        <div class="hidden md:block text-pure-white/60">|</div>
                        <div class="hidden md:block text-pure-white/80">
                            Sacred Support: Mon-Sat 9AM-7PM IST
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <span class="hidden lg:block text-pure-white/60 text-xs">Follow Our Sacred Journey:</span>
                        <div class="flex space-x-2 sm:space-x-3">
                            <!-- Twitter -->
                            <a href="#" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <!-- Instagram -->
                            <a href="{{ setting('social_instagram', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.40z"/>
                                </svg>
                            </a>
                            <!-- YouTube -->
                            <a href="{{ setting('social_youtube', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo Row -->
        <div class="om-background shadow-lg">
            <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo & Brand -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/logo-divine-raksha.webp') }}" alt="Divine Raksha Logo" class="h-16 sm:h-20 lg:h-24 w-auto">
                        </a>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Search -->
                        <button onclick="window.dispatchEvent(new CustomEvent('open-search'))" class="text-pure-white hover:text-sacred-gold transition-colors duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>

                        <!-- User Account -->
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-pure-white hover:text-sacred-gold transition-colors duration-300">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                    <p class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">{{ Auth::user()->name }}</p>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-pure-white hover:text-sacred-gold transition-colors duration-300">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </a>
                        @endauth

                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" id="header-cart-icon" class="text-pure-white hover:text-sacred-gold transition-colors duration-300 relative">
                            <img src="{{ asset('images/shopping-cart.svg') }}" alt="Shopping Cart" class="w-6 h-6 sm:w-8 sm:h-8">
                            @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                            <span id="cart-count" class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 bg-divine-red text-pure-white text-xs rounded-full h-5 w-5 flex items-center justify-center text-[10px] font-bold {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
                        </a>

                        <!-- Mobile Menu Button -->
                        <button class="lg:hidden text-pure-white hover:text-sacred-gold transition-colors duration-300" id="mobile-menu-button">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Row -->
        <div class="bg-royal-blue/95 border-t border-sacred-gold/20">
            <div class="container max-w-7xl mx-auto px-4 sm:px-6">
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center justify-center lg:justify-start space-x-8 py-3">
                    <a href="{{ route('shop.purpose') }}" class="text-pure-white hover:text-sacred-gold transition-colors duration-300 font-medium py-2 border-b-2 border-transparent hover:border-sacred-gold">Shop by Purpose</a>
                    <a href="{{ route('shop.raashi') }}" class="text-pure-white hover:text-sacred-gold transition-colors duration-300 font-medium py-2 border-b-2 border-transparent hover:border-sacred-gold">Shop by Raashi</a>
                    <a href="{{ route('shop.numerology') }}" class="text-pure-white hover:text-sacred-gold transition-colors duration-300 font-medium py-2 border-b-2 border-transparent hover:border-sacred-gold">Shop by Numerology</a>
                    <a href="{{ route('products.index') }}" class="text-pure-white hover:text-sacred-gold transition-colors duration-300 font-medium py-2 border-b-2 border-transparent hover:border-sacred-gold">All Products</a>
                    <a href="{{ route('shop.bestsellers') }}" class="text-pure-white hover:text-sacred-gold transition-colors duration-300 font-medium py-2 border-b-2 border-transparent hover:border-sacred-gold">Best Sellers</a>
                </nav>
                
                <!-- Mobile Slide-out Menu Overlay -->
                <div class="lg:hidden fixed inset-0 z-50 hidden" id="mobile-menu-overlay">
                    <!-- Background Overlay -->
                    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300" id="menu-backdrop"></div>
                    
                    <!-- Slide-out Menu -->
                    <div class="fixed top-0 right-0 h-full w-80 max-w-sm transform translate-x-full transition-transform duration-300 ease-in-out" id="mobile-menu">
                        <div class="om-background h-full shadow-xl">
                            <!-- Menu Header -->
                            <div class="flex items-center justify-between p-6 border-b border-sacred-gold/20">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('images/logo-divine-raksha.webp') }}" alt="Divine Raksha" class="h-10 w-auto">
                                    </a>
                                </div>
                                <button class="text-pure-white hover:text-sacred-gold transition-colors duration-300" id="close-menu-btn">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Menu Content -->
                            <div class="flex flex-col h-full">
                                <!-- Navigation Links -->
                                <nav class="flex-1 px-6 py-6">
                                    <div class="space-y-1">
                                        <a href="{{ route('shop.purpose') }}" class="flex items-center px-4 py-3 text-pure-white hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300 group">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                            </svg>
                                            <span class="font-medium">Shop by Purpose</span>
                                        </a>
                                        
                                        <a href="{{ route('shop.raashi') }}" class="flex items-center px-4 py-3 text-pure-white hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300 group">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            <span class="font-medium">Shop by Raashi</span>
                                        </a>
                                        
                                        <a href="{{ route('shop.numerology') }}" class="flex items-center px-4 py-3 text-pure-white hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300 group">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                            </svg>
                                            <span class="font-medium">Shop by Numerology</span>
                                        </a>
                                        
                                        <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 text-pure-white hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300 group">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <span class="font-medium">All Products</span>
                                        </a>
                                        
                                        <a href="{{ route('shop.bestsellers') }}" class="flex items-center px-4 py-3 text-pure-white hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300 group">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                            </svg>
                                            <span class="font-medium">Best Sellers</span>
                                        </a>
                                    </div>
                                    
                                    <!-- Divider -->
                                    <div class="border-t border-sacred-gold/20 my-6"></div>
                                    
                                    <!-- Additional Menu Items -->
                                    <div class="space-y-1">
                                        <a href="{{ route('order.track') }}" class="flex items-center px-4 py-3 text-pure-white/80 hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <span class="text-sm">Track My Order</span>
                                        </a>
                                        
                                        <a href="{{ route('about') }}" class="flex items-center px-4 py-3 text-pure-white/80 hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm">About Us</span>
                                        </a>
                                        
                                        <a href="{{ route('contact') }}" class="flex items-center px-4 py-3 text-pure-white/80 hover:text-sacred-gold hover:bg-pure-white/10 rounded-lg transition-all duration-300">
                                            <svg class="w-5 h-5 mr-3 text-sacred-gold/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-sm">Contact Us</span>
                                        </a>
                                    </div>
                                </nav>
                                
                                <!-- Menu Footer -->
                                <div class="px-6 py-4 border-t border-sacred-gold/20">
                                    <div class="flex items-center justify-center space-x-4 mb-4">
                                        <a href="{{ setting('social_facebook', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ setting('social_instagram', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ setting('social_youtube', '#') }}" class="text-pure-white/60 hover:text-sacred-gold transition-colors duration-300" target="_blank">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <p class="text-center text-pure-white/60 text-xs">
                                        Sacred Support: {{ setting('site_phone', '+91 98765 43210') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Overlay -->
    <div x-data="searchOverlay()" @open-search.window="open()" x-show="isOpen" x-cloak
         class="fixed inset-0 z-[100] flex items-start justify-center pt-20 sm:pt-32"
         @keydown.escape.window="close()">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="close()" x-show="isOpen" x-transition.opacity></div>

        <!-- Search Panel -->
        <div class="relative w-full max-w-2xl mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden" x-show="isOpen" x-transition>
            <!-- Search Input -->
            <div class="flex items-center border-b border-gray-100">
                <svg class="w-5 h-5 ml-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-ref="searchInput" x-model="query" @input.debounce.300ms="search()"
                       @keydown.enter="goToResults()"
                       placeholder="Search for products..."
                       class="w-full px-4 py-5 text-lg border-0 focus:ring-0 focus:outline-none placeholder-gray-400">
                <button @click="close()" class="mr-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Results -->
            <div class="max-h-80 overflow-y-auto">
                <!-- Loading -->
                <div x-show="loading" class="p-6 text-center text-sm text-gray-500">Searching...</div>

                <!-- Suggestions -->
                <template x-if="!loading && results.length > 0">
                    <div class="py-2">
                        <template x-for="item in results" :key="item.url">
                            <a :href="item.url" class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900" x-text="item.title"></span>
                                <span class="text-sm text-royal-blue font-semibold" x-text="item.price"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- No Results -->
                <div x-show="!loading && searched && results.length === 0" class="p-6 text-center text-sm text-gray-500">
                    No products found for "<span x-text="query"></span>"
                </div>

                <!-- View All -->
                <div x-show="!loading && results.length > 0" class="border-t border-gray-100 p-3">
                    <a :href="'/products?q=' + encodeURIComponent(query)"
                       class="block text-center text-sm font-medium text-royal-blue hover:text-deep-royal py-2 rounded-lg hover:bg-royal-blue/5 transition-colors">
                        View all results &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchOverlay() {
            return {
                isOpen: false,
                query: '',
                results: [],
                loading: false,
                searched: false,
                open() {
                    this.isOpen = true;
                    this.searched = false;
                    this.$nextTick(() => { if(this.$refs.searchInput) this.$refs.searchInput.focus(); });
                },
                close() {
                    this.isOpen = false;
                    this.query = '';
                    this.results = [];
                    this.searched = false;
                },
                goToResults() {
                    if (this.query.trim().length >= 2) {
                        window.location.href = '/products?q=' + encodeURIComponent(this.query.trim());
                    }
                },
                search() {
                    const q = this.query.trim();
                    if (q.length < 2) {
                        this.results = [];
                        this.searched = false;
                        return;
                    }
                    this.loading = true;
                    this.searched = true;
                    const self = this;
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '/search/suggestions?q=' + encodeURIComponent(q));
                    xhr.setRequestHeader('Accept', 'application/json');
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.onload = function() {
                        self.loading = false;
                        try {
                            self.results = JSON.parse(xhr.responseText);
                        } catch(e) {
                            self.results = [];
                        }
                    };
                    xhr.onerror = function() {
                        self.loading = false;
                        self.results = [];
                    };
                    xhr.send();
                }
            }
        }
    </script>

