<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Divine Raksha</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('head')
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
                        'soft-grey': '#f8fafc',
                        'sidebar-dark': '#0f172a'
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
        .om-background {
            background: linear-gradient(135deg, #1e3a8a 0%, #011455 100%);
            position: relative;
        }
        .om-background::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("{{ asset('images/om.svg') }}");
            background-size: 60px 60px;
            background-repeat: repeat;
            opacity: 0.05;
            pointer-events: none;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-soft-grey font-coolvetica min-h-screen">
    <!-- Top Header -->
    <header class="om-background text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Top Row: Brand + Actions -->
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-divine-raksha.webp') }}" alt="Divine Raksha" class="h-10 w-auto">
                    <span class="text-sacred-gold font-venlury font-semibold text-sm">Admin Panel</span>
                </a>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center mr-2">
                        <div class="w-7 h-7 rounded-full bg-sacred-gold/20 flex items-center justify-center mr-2">
                            <span class="text-sacred-gold text-xs font-semibold">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm text-white/70">{{ Auth::guard('admin')->user()->name }}</span>
                    </div>

                    <a href="{{ url('/') }}" target="_blank" class="text-sm text-white/70 hover:text-sacred-gold transition-colors hidden sm:flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Site
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-white/70 hover:text-divine-red transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>

                    <!-- Mobile nav toggle -->
                    <button class="sm:hidden text-white/70 hover:text-sacred-gold" id="mobile-nav-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation Row -->
            <nav class="hidden sm:flex items-center space-x-1 pb-3 overflow-x-auto" id="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Categories
                </a>
                <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Orders
                </a>
                <a href="{{ route('admin.stocks.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.stocks.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Stock
                </a>
                <a href="{{ route('admin.coupons.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.coupons.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Coupons
                </a>
                <span class="text-white/20 px-1">|</span>
                <a href="{{ route('admin.sliders.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.sliders.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Sliders
                </a>
                <a href="{{ route('admin.blog-categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.blog-categories.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Blog Categories
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.blogs.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Blogs
                </a>
                <span class="text-white/20 px-1">|</span>
                <a href="{{ route('admin.enquiries.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.enquiries.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Enquiries
                </a>
                <a href="{{ route('admin.media.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.media.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Media
                </a>
                <span class="text-white/20 px-1">|</span>
                <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Settings
                </a>
            </nav>

            <!-- Mobile Navigation (hidden by default) -->
            <nav class="sm:hidden pb-3 hidden" id="mobile-admin-nav">
                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Products</a>
                    <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Categories</a>
                    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Orders</a>
                    <a href="{{ route('admin.stocks.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.stocks.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Stock</a>
                    <a href="{{ route('admin.coupons.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.coupons.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Coupons</a>
                    <a href="{{ route('admin.sliders.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.sliders.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Sliders</a>
                    <a href="{{ route('admin.blog-categories.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.blog-categories.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Blog Cat.</a>
                    <a href="{{ route('admin.blogs.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.blogs.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Blogs</a>
                    <a href="{{ route('admin.enquiries.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.enquiries.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Enquiries</a>
                    <a href="{{ route('admin.media.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.media.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Media</a>
                    <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded-lg text-xs font-medium text-center transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-white/15 text-sacred-gold' : 'text-white/70 hover:bg-white/10' }}">Settings</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Page Title Bar -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <h1 class="text-xl font-venlury font-semibold text-royal-blue">@yield('page-title', 'Dashboard')</h1>
        </div>
    </div>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Mobile nav toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('mobile-nav-toggle');
            const nav = document.getElementById('mobile-admin-nav');
            if (toggle && nav) {
                toggle.addEventListener('click', function () {
                    nav.classList.toggle('hidden');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
