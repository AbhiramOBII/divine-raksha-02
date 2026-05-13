@php
    $seoTitle = 'Frequently Asked Questions | ' . setting('site_name', 'Divine Raksha');
    $seoDescription = 'Find answers to common questions about Rudraksha beads, Karungali malas, orders, shipping, payments, returns, and spiritual guidance at Divine Raksha.';
@endphp

@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">FAQ</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-3xl mx-auto px-4 sm:px-6">

            <!-- Page Header -->
            <div class="text-center mb-10 sm:mb-14">
                <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-3">Frequently Asked Questions</h1>
                <p class="text-gray-500 max-w-xl mx-auto">Find answers to common questions about our products, shipping, and spiritual guidance.</p>
            </div>

            <!-- FAQ Sections -->
            <div class="space-y-8">

                <!-- Orders & Shipping -->
                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Orders & Shipping
                    </h2>
                    <div class="space-y-3" x-data="{ open: null }">
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">How long does delivery take?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 1 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 1" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">We typically deliver within 5–7 business days across India. Metro cities may receive orders in 3–5 days. Once your order is shipped, you will receive a tracking link via SMS/email.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Do you ship internationally?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 2 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 2" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Currently, we ship only within India. International shipping will be available soon. Please follow our social media for updates on international delivery.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">How can I track my order?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 3 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 3" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">You can track your order using the <a href="{{ route('order.track') }}" class="text-royal-blue hover:underline">Track My Order</a> page. Simply enter your order number and email address to view real-time status updates.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">What are the shipping charges?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 4 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 4" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">We offer free shipping on all prepaid orders. For Cash on Delivery (COD) orders, a nominal handling fee may apply depending on the delivery location.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products & Authenticity -->
                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Products & Authenticity
                    </h2>
                    <div class="space-y-3" x-data="{ open: null }">
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Are your Rudraksha beads authentic?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 1 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 1" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Yes, absolutely. All Rudraksha beads sold on Divine Raksha are 100% natural and authentic. We source them from trusted suppliers and each bead is carefully inspected for quality, mukhi clarity, and natural formation before being listed on our platform.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">What is Karungali and why is it special?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 2 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 2" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Karungali (Ebony wood) is a sacred wood revered in South Indian spiritual traditions. It is believed to carry grounding and protective energies, helping the wearer maintain spiritual balance and ward off negative influences. Our Karungali malas are crafted from genuine ebony wood with traditional bead counts.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">How should I care for my mala or spiritual accessories?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 3 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 3" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Keep your mala away from water, chemicals, and perfumes. Store in a clean, dry place — preferably in the pouch provided. For Rudraksha, occasional oiling with a drop of sesame or coconut oil helps maintain its natural lustre. Treat your sacred items with reverence and they will serve you well for years.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">How do I choose the right product for me?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 4 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 4" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">You can browse our collections by purpose (protection, focus, prosperity, etc.), by your Raashi (zodiac sign), or by numerology. Each product page includes detailed spiritual significance to help you make an informed choice. If you need personal guidance, feel free to <a href="{{ route('contact') }}" class="text-royal-blue hover:underline">contact us</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payments & Returns -->
                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sacred-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Payments & Returns
                    </h2>
                    <div class="space-y-3" x-data="{ open: null }">
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">What payment methods do you accept?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 1 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 1" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">We accept UPI, Credit/Debit Cards, Net Banking, and Cash on Delivery (COD). All online payments are processed securely through trusted payment gateways.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Can I return or exchange a product?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 2 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 2" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Due to the sacred and personal nature of spiritual products, we generally do not accept returns. However, if you receive a damaged or incorrect item, please contact us within 48 hours of delivery with photos and we will resolve it promptly.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Is Cash on Delivery available?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 3 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 3" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Yes, COD is available for most pin codes across India. A small COD handling fee may apply. We recommend prepaid payment for faster processing and free shipping benefits.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spiritual Guidance -->
                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sacred-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        Spiritual Guidance
                    </h2>
                    <div class="space-y-3" x-data="{ open: null }">
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Do I need to perform any ritual before wearing a Rudraksha?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 1 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 1" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">While not strictly mandatory, it is traditionally recommended to wash your Rudraksha with clean water, offer a short prayer, and wear it with positive intention. Many devotees chant "Om Namah Shivaya" while wearing it for the first time. Detailed guidance is included with each order.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Can anyone wear a Rudraksha regardless of religion?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 2 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 2" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">Yes. Rudraksha is a natural seed with spiritual significance that transcends religious boundaries. Anyone who wears it with faith, respect, and positive intention can benefit from its energies. There are no restrictions based on gender, age, or religion.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="text-sm font-medium text-gray-900">Can I wear my mala while sleeping or bathing?</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="open === 3 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open === 3" x-collapse class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">It is best to remove your mala before bathing, swimming, or sleeping to preserve its quality and longevity. Store it in the cloth pouch provided when not wearing it. This also helps maintain the sacred energy of the beads.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Still Have Questions -->
            <div class="mt-12 text-center bg-gray-50 rounded-2xl p-8 sm:p-10 border border-gray-100">
                <h3 class="text-lg font-venlury font-semibold text-royal-blue mb-2">Still Have Questions?</h3>
                <p class="text-sm text-gray-500 mb-5">We're happy to help. Reach out to us and we'll get back to you within 24 hours.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-royal-blue text-white font-semibold text-sm rounded-lg hover:bg-deep-royal transition-colors duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contact Us
                </a>
            </div>

        </div>
    </section>

@include('partials.footer')
