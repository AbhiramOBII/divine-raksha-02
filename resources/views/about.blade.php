@php
    $seoTitle = 'About Divine Raksha - Our Sacred Mission & Story | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = 'Learn about Divine Raksha, our founders, and our sacred mission to bring authentic spiritual protection and divine blessings to seekers worldwide through genuine Rudraksha and sacred artifacts.';
@endphp

@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">About Us</span>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-[#1a0a2e] via-[#2d1b4e] to-[#1a0a2e] py-16 sm:py-24 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-40 h-40 border border-sacred-gold/30 rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-60 h-60 border border-sacred-gold/20 rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-sacred-gold/10 rounded-full"></div>
        </div>

        <div class="container max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-sacred-gold/10 border border-sacred-gold/30 rounded-full mb-6">
                <svg class="w-4 h-4 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                <span class="text-sacred-gold text-xs font-semibold tracking-wider uppercase">Our Story</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-venlury font-bold text-white mb-4 leading-tight">About Divine Raksha</h1>
            <p class="text-lg sm:text-xl text-white/70 font-light max-w-2xl mx-auto">Where Faith, Energy, and Tradition Come Together</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 sm:py-20">
        <div class="container max-w-4xl mx-auto px-4 sm:px-6">
            <div class="prose prose-lg max-w-none">

                <!-- Intro -->
                <div class="mb-12">
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                        Divine Raksha was born from a simple yet powerful belief — spirituality should not remain distant, complicated, or inaccessible in today's fast-moving world. In an age where people constantly seek peace amidst chaos, emotional balance amidst pressure, and divine protection amidst uncertainty, Divine Raksha aims to become a trusted spiritual companion for every seeker.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        Built as a modern spiritual eCommerce platform rooted deeply in Indian traditions, Divine Raksha brings together sacred products, timeless wisdom, and authentic spiritual experiences for devotees across the globe. Whether it is a Rudraksha mala worn for spiritual focus, a Karungali mala believed to carry grounding energy, or devotional accessories that strengthen one's connection to the divine, every offering at Divine Raksha is carefully chosen with reverence, intention, and authenticity.
                    </p>
                </div>

                <!-- Founders Section -->
                <div class="bg-gradient-to-br from-sacred-gold/5 to-transparent border border-sacred-gold/20 rounded-2xl p-6 sm:p-10 mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-sacred-gold/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-venlury font-bold text-royal-blue">The People Behind Divine Raksha</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                        Divine Raksha is led by two passionate spiritual communicators — <strong>RJ Rajesh</strong>, fondly known by lakhs of listeners as "Love Guru," and <strong>Akshay Vasu</strong>, a modern spiritual voice who believes ancient wisdom can coexist beautifully with contemporary life. Over the years, both Rajesh and Akshay have connected deeply with audiences through conversations around emotions, relationships, inner healing, spirituality, self-awareness, and human transformation.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        Through Divine Raksha, they envision creating more than just an online store — they aim to build a meaningful spiritual ecosystem where people can discover products that resonate with their faith, energy, and personal journey.
                    </p>
                </div>

                <!-- Philosophy -->
                <div class="mb-12">
                    <h2 class="text-xl sm:text-2xl font-venlury font-bold text-royal-blue mb-5 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-royal-blue/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-royal-blue" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        </span>
                        Spirituality With Depth & Meaning
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                        At Divine Raksha, spirituality is not treated as a trend or merely as an aesthetic. It is viewed as an inner experience — something deeply personal, sacred, and transformative. Every product offered through the platform carries a deeper intention.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        Rudraksha beads have been revered for centuries in Hindu spiritual traditions for their connection to meditation, clarity, discipline, and divine consciousness. Karungali malas are believed by many to carry grounding and protective energies that help individuals stay balanced and spiritually aligned. Alongside these sacred items, Divine Raksha also curates spiritual bracelets, pendants, pooja essentials, and devotional accessories that are designed to help devotees carry a sense of spiritual connection into their daily lives.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        The focus is not simply on selling products, but on creating a bridge between tradition and the modern seeker.
                    </p>
                </div>

                <!-- Authenticity -->
                <div class="mb-12">
                    <h2 class="text-xl sm:text-2xl font-venlury font-bold text-royal-blue mb-5 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-royal-blue/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </span>
                        Commitment to Authenticity
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                        What truly differentiates Divine Raksha is its commitment to authenticity and spiritual integrity. In a marketplace crowded with mass-produced spiritual products lacking meaning or credibility, Divine Raksha aims to restore trust and reverence.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        Every product is selected with careful attention to quality, symbolism, spiritual significance, and traditional relevance. The platform believes that sacred objects should never lose their emotional and spiritual value in the process of commercialization. Instead, they should continue to inspire devotion, discipline, positivity, protection, and inner transformation for those who wear or use them with faith.
                    </p>
                </div>

                <!-- Vision -->
                <div class="mb-12">
                    <h2 class="text-xl sm:text-2xl font-venlury font-bold text-royal-blue mb-5 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-royal-blue/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-royal-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </span>
                        Our Vision
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                        The vision of Divine Raksha extends far beyond commerce. The founders aspire to create a vibrant spiritual community that encourages people to reconnect with themselves, their traditions, and the divine energies around them.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        Through spiritual storytelling, podcasts, educational content, devotional conversations, and community-driven engagement, Divine Raksha hopes to make spirituality more approachable and meaningful for younger generations as well. The platform seeks to create a space where ancient Indian wisdom can be experienced in a way that feels relevant, comforting, and empowering in modern life.
                    </p>
                </div>

                <!-- Core Values -->
                <div class="bg-gradient-to-br from-royal-blue/5 to-transparent border border-royal-blue/10 rounded-2xl p-6 sm:p-10 mb-12">
                    <h2 class="text-xl sm:text-2xl font-venlury font-bold text-royal-blue mb-6">Who Is Divine Raksha For?</h2>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg">
                        At its core, Divine Raksha stands for <strong>protection, positivity, faith, and spiritual grounding</strong>. It is for:
                    </p>
                    <ul class="mt-5 space-y-3">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-sacred-gold/20 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                            </span>
                            <span class="text-gray-700 text-base sm:text-lg">The individual searching for <strong>inner peace</strong> after a difficult day</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-sacred-gold/20 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                            </span>
                            <span class="text-gray-700 text-base sm:text-lg">The devotee seeking <strong>divine blessings</strong> before a new beginning</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-sacred-gold/20 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                            </span>
                            <span class="text-gray-700 text-base sm:text-lg">The spiritual seeker trying to <strong>reconnect with purpose</strong></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-sacred-gold/20 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                            </span>
                            <span class="text-gray-700 text-base sm:text-lg">Anyone who believes that <strong>faith has the power to transform lives</strong></span>
                        </li>
                    </ul>
                    <p class="text-gray-700 leading-relaxed text-base sm:text-lg mt-5">
                        Every mala, every sacred bead, every spiritual accessory offered through Divine Raksha carries with it a prayer — a silent intention to help people feel protected, guided, empowered, and spiritually connected.
                    </p>
                </div>

                <!-- Closing -->
                <div class="text-center border-t border-gray-100 pt-10">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-sacred-gold/10 mb-5">
                        <svg class="w-7 h-7 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                    </div>
                    <p class="text-gray-800 text-lg sm:text-xl font-venlury font-semibold italic max-w-2xl mx-auto leading-relaxed">
                        "Divine Raksha is not merely a brand. It is a journey of devotion, energy, and inner awakening — rooted in tradition, powered by faith, and created for the modern spiritual seeker."
                    </p>
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
