@php
    $seoTitle = 'Contact Us - Get in Touch | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = 'Contact Divine Raksha for enquiries about Rudraksha, spiritual accessories, orders, or spiritual guidance. Reach us by phone, email, or through our contact form.';
@endphp

@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Contact Us</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-6xl mx-auto px-4 sm:px-6">

            <!-- Page Header -->
            <div class="text-center mb-10 sm:mb-14">
                <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-3">Get In Touch</h1>
                <p class="text-gray-500 max-w-xl mx-auto">Have questions about our sacred offerings or need spiritual guidance? We'd love to hear from you.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

                <!-- Contact Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Phone -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
                        <div class="w-11 h-11 rounded-lg bg-royal-blue/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">Phone</h3>
                            <a href="tel:{{ setting('site_phone', '+91 98765 43210') }}" class="text-gray-600 hover:text-royal-blue transition-colors">
                                {{ setting('site_phone', '+91 98765 43210') }}
                            </a>
                            <p class="text-xs text-gray-400 mt-1">Mon – Sat, 9 AM – 7 PM IST</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
                        <div class="w-11 h-11 rounded-lg bg-sacred-gold/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">Email</h3>
                            <a href="mailto:{{ setting('site_email', 'info@divineraksha.com') }}" class="text-gray-600 hover:text-royal-blue transition-colors">
                                {{ setting('site_email', 'info@divineraksha.com') }}
                            </a>
                            <p class="text-xs text-gray-400 mt-1">We usually reply within 24 hours</p>
                        </div>
                    </div>

                    <!-- Address -->
                    @if(setting('site_address'))
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
                        <div class="w-11 h-11 rounded-lg bg-divine-red/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-divine-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">Address</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ setting('site_address') }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Social -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Follow Us</h3>
                        <div class="flex items-center space-x-3">
                            @if(setting('social_facebook'))
                            <a href="{{ setting('social_facebook') }}" target="_blank" class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white hover:opacity-80 transition-opacity">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            @endif
                            @if(setting('social_instagram'))
                            <a href="{{ setting('social_instagram') }}" target="_blank" class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white hover:opacity-80 transition-opacity">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            @endif
                            @if(setting('social_youtube'))
                            <a href="{{ setting('social_youtube') }}" target="_blank" class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center text-white hover:opacity-80 transition-opacity">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Enquiry Form -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sm:p-8">
                        <h2 class="text-xl font-venlury font-semibold text-royal-blue mb-1">Send Us a Message</h2>
                        <p class="text-sm text-gray-500 mb-6">Fill out the form below and we'll respond as soon as possible.</p>

                        @if(session('success'))
                            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Your Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors @error('name') border-red-400 @enderror"
                                           placeholder="Full name">
                                    @error('name')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors @error('email') border-red-400 @enderror"
                                           placeholder="you@example.com">
                                    @error('email')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors @error('phone') border-red-400 @enderror"
                                           placeholder="+91 98765 43210">
                                    @error('phone')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Subject <span class="text-red-500">*</span></label>
                                    <input type="text" name="subject" value="{{ old('subject') }}" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors @error('subject') border-red-400 @enderror"
                                           placeholder="What is this regarding?">
                                    @error('subject')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Message <span class="text-red-500">*</span></label>
                                <textarea name="message" rows="5" required
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors resize-none @error('message') border-red-400 @enderror"
                                          placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full sm:w-auto px-8 py-3 bg-royal-blue text-white font-semibold rounded-lg hover:bg-deep-royal transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
