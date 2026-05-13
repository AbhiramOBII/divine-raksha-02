@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Privacy Policy</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-3xl mx-auto px-4 sm:px-6">
            <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-2">Privacy Policy</h1>
            <p class="text-sm text-gray-400 mb-10">Last updated: {{ date('F Y') }}</p>

            <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 space-y-8">

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">1. Introduction</h2>
                    <p>Divine Raksha ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, store, and protect your personal information when you visit our website or make a purchase.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">2. Information We Collect</h2>
                    <p>We may collect the following types of information:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li><strong>Personal Information:</strong> Name, email address, phone number, shipping address, and billing details provided during checkout or account registration.</li>
                        <li><strong>Order Information:</strong> Products purchased, order history, and payment transaction details.</li>
                        <li><strong>Device Information:</strong> IP address, browser type, operating system, and browsing behaviour on our website.</li>
                        <li><strong>Communication Data:</strong> Messages sent through our contact form or customer support channels.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">3. How We Use Your Information</h2>
                    <p>We use the collected information to:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Process and fulfil your orders</li>
                        <li>Send order confirmations, shipping updates, and delivery notifications</li>
                        <li>Respond to your enquiries and provide customer support</li>
                        <li>Improve our website, products, and services</li>
                        <li>Send promotional emails and newsletters (only with your consent)</li>
                        <li>Prevent fraud and ensure website security</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">4. Data Sharing</h2>
                    <p>We do not sell, trade, or rent your personal information to third parties. We may share your information only with:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li><strong>Shipping Partners:</strong> To deliver your orders.</li>
                        <li><strong>Payment Gateways:</strong> To process secure payments.</li>
                        <li><strong>Legal Authorities:</strong> When required by law or to protect our rights.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">5. Data Security</h2>
                    <p>We implement industry-standard security measures to protect your personal data from unauthorized access, alteration, or disclosure. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">6. Cookies</h2>
                    <p>Our website uses cookies to enhance your browsing experience, remember your preferences, and analyse site traffic. You can control cookie settings through your browser. Disabling cookies may affect some website functionality.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">7. Your Rights</h2>
                    <p>You have the right to:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Access the personal information we hold about you</li>
                        <li>Request correction of inaccurate data</li>
                        <li>Request deletion of your personal data (subject to legal obligations)</li>
                        <li>Opt out of marketing communications at any time</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">8. Third-Party Links</h2>
                    <p>Our website may contain links to external websites. We are not responsible for the privacy practices or content of those third-party sites. We encourage you to review their privacy policies independently.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">9. Changes to This Policy</h2>
                    <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated revision date. Continued use of our website constitutes acceptance of the revised policy.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">10. Contact Us</h2>
                    <p>If you have any questions or concerns about this Privacy Policy, please <a href="{{ route('contact') }}" class="text-royal-blue hover:underline">contact us</a>.</p>
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
