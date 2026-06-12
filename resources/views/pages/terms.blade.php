@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Terms of Use</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-3xl mx-auto px-4 sm:px-6">
            <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-2">Terms of Use</h1>
            <p class="text-sm text-gray-400 mb-10">Last updated: {{ date('F Y') }}</p>

            <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 space-y-8">

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">1. Acceptance of Terms</h2>
                    <p>By accessing and using the Divine Raksha website ({{ url('/') }}), you accept and agree to be bound by these Terms of Use. If you do not agree with any part of these terms, please do not use our website or services.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">2. Use of Website</h2>
                    <p>You agree to use this website only for lawful purposes and in a way that does not infringe the rights of others. You must not:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Use the website in any way that breaches applicable laws or regulations</li>
                        <li>Attempt to gain unauthorized access to any part of the website</li>
                        <li>Use the website to transmit harmful, offensive, or misleading content</li>
                        <li>Reproduce, duplicate, or resell any part of the website without permission</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">3. Products & Descriptions</h2>
                    <p>We make every effort to display our products as accurately as possible. However, actual colours and appearance may vary slightly depending on your device settings. Product descriptions are provided for informational purposes and reflect traditional spiritual beliefs — they are not medical or scientific claims.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">4. Pricing & Payments</h2>
                    <p>All prices listed on the website are in Indian Rupees (INR) and inclusive of applicable taxes unless stated otherwise. We reserve the right to modify prices without prior notice. Payment must be completed through our accepted payment methods at the time of checkout.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">5. Orders & Cancellation</h2>
                    <p>We reserve the right to refuse or cancel any order at our discretion, including but not limited to cases of suspected fraud, pricing errors, or product unavailability. If your order is cancelled, you will receive a full refund to your original payment method.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">6. Shipping & Delivery</h2>
                    <p>Shipping charges may be applicable depending on your order value and delivery location. The applicable shipping cost, if any, will be displayed clearly at checkout before you complete your purchase.</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Orders are typically delivered within <strong>5–7 business days</strong> from the date of dispatch, subject to product availability.</li>
                        <li>Delivery timelines may vary due to remote locations, public holidays, or unforeseen logistics delays.</li>
                        <li>We will notify you via email once your order has been dispatched.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">7. Returns & Refunds</h2>
                    <p>Due to the sacred and personal nature of our products, <strong>returns are accepted only if the product is received in a damaged or broken condition</strong> due to transit or handling. We do not accept returns for change of mind, incorrect size selection, or subjective dissatisfaction.</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Damaged items must be reported within <strong>48 hours</strong> of delivery with photographic evidence.</li>
                        <li>Approved claims will be resolved with a free replacement or full refund.</li>
                        <li>Please refer to our <a href="{{ route('return-policy') }}" class="text-royal-blue hover:underline">Return Policy</a> page for the complete process.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">8. Intellectual Property</h2>
                    <p>All content on this website — including text, graphics, logos, images, and software — is the property of Divine Raksha or its content suppliers and is protected by intellectual property laws. You may not use, copy, or distribute any content without our prior written consent.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">9. User Accounts</h2>
                    <p>If you create an account on our website, you are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You must notify us immediately of any unauthorized use.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">10. Limitation of Liability</h2>
                    <p>Divine Raksha shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the website or purchase of products. Our total liability shall not exceed the amount paid by you for the specific product or service in question.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">11. Modifications</h2>
                    <p>We reserve the right to update or modify these Terms of Use at any time without prior notice. Continued use of the website after changes constitutes acceptance of the revised terms.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">12. Governing Law</h2>
                    <p>These terms shall be governed by and construed in accordance with the laws of India. Any disputes arising from these terms shall be subject to the exclusive jurisdiction of the courts in Chennai, Tamil Nadu.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">13. Contact</h2>
                    <p>If you have any questions about these Terms of Use, please <a href="{{ route('contact') }}" class="text-royal-blue hover:underline">contact us</a>.</p>
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
