@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Disclaimer</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-3xl mx-auto px-4 sm:px-6">
            <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-2">Disclaimer</h1>
            <p class="text-sm text-gray-400 mb-10">Last updated: {{ date('F Y') }}</p>

            <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 space-y-8">

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">1. General Information</h2>
                    <p>The information provided on the Divine Raksha website is for general informational and spiritual purposes only. While we strive to keep the information accurate and up-to-date, we make no representations or warranties of any kind — express or implied — about the completeness, accuracy, or reliability of any information on this website.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">2. Spiritual & Religious Claims</h2>
                    <p>The spiritual benefits, properties, and significance of products described on this website (including Rudraksha beads, Karungali malas, gemstones, and other sacred items) are based on traditional Hindu spiritual beliefs, ancient scriptures, and cultural practices. These descriptions reflect faith-based traditions and are not intended as scientific, medical, or therapeutic claims.</p>
                    <p class="mt-3">We do not claim that any product can cure, treat, or prevent any physical or mental health condition. If you have a medical concern, please consult a qualified healthcare professional.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">3. Product Variations</h2>
                    <p>Natural spiritual products such as Rudraksha beads and Karungali wood are naturally formed items. Each piece is unique and may vary slightly in size, colour, texture, and appearance from the images shown on the website. Such variations are natural and do not constitute a defect.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">4. No Guarantee of Results</h2>
                    <p>While many devotees and users report positive spiritual experiences with sacred items, individual results may vary. Spiritual benefits depend on personal faith, intention, practice, and individual circumstances. Divine Raksha does not guarantee any specific spiritual, emotional, or material outcomes from the use of our products.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">5. External Links</h2>
                    <p>Our website may contain links to third-party websites or content. These links are provided for convenience only. We do not endorse, control, or take responsibility for the content, privacy policies, or practices of any third-party websites.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">6. Limitation of Liability</h2>
                    <p>In no event shall Divine Raksha, its founders, or its team be liable for any loss or damage — including but not limited to indirect or consequential loss — arising out of or in connection with the use of this website or reliance on any information provided herein.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">7. Changes to This Disclaimer</h2>
                    <p>We reserve the right to modify this Disclaimer at any time. Changes will be effective immediately upon posting on this page. Your continued use of the website constitutes acceptance of the revised Disclaimer.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">8. Contact</h2>
                    <p>If you have any questions about this Disclaimer, please <a href="{{ route('contact') }}" class="text-royal-blue hover:underline">contact us</a>.</p>
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
