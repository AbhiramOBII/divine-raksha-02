@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Return Policy</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-16">
        <div class="container max-w-3xl mx-auto px-4 sm:px-6">
            <h1 class="text-3xl sm:text-4xl font-venlury font-bold text-royal-blue mb-2">Return Policy</h1>
            <p class="text-sm text-gray-400 mb-10">Last updated: {{ date('F Y') }}</p>

            <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 space-y-8">

                <!-- Important Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        <div>
                            <p class="font-semibold text-amber-800 text-sm mb-1">Important Notice</p>
                            <p class="text-sm text-amber-700">Due to the sacred and personal nature of spiritual products, we follow a <strong>strict no-return policy</strong>. Returns are accepted <strong>only</strong> if items are received damaged or broken during transit.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">1. No Returns Policy</h2>
                    <p>All sales on Divine Raksha are final. We do not accept returns or exchanges for reasons including but not limited to:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Change of mind after purchase</li>
                        <li>Dissatisfaction with product appearance (natural variations in beads, wood, or stones are expected)</li>
                        <li>Incorrect size selection by the buyer</li>
                        <li>Products already worn, used, or energized</li>
                    </ul>
                    <p class="mt-3">Spiritual items are considered deeply personal and sacred. Once dispatched, they cannot be resold or reused for other customers. We encourage you to carefully read product descriptions and reach out with any questions before placing your order.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">2. Damaged or Broken Items</h2>
                    <p>If you receive an item that is <strong>damaged, broken, or defective</strong> due to shipping or handling, we will gladly offer a replacement or refund. To claim this:</p>
                    <ol class="list-decimal pl-5 mt-3 space-y-2">
                        <li><strong>Report within 48 hours</strong> — Contact us within 48 hours of receiving the package.</li>
                        <li><strong>Provide photographic evidence</strong> — Send clear photos of the damaged item and the shipping packaging showing visible damage.</li>
                        <li><strong>Do not discard the item</strong> — Keep the damaged product and its original packaging until the claim is resolved.</li>
                        <li><strong>Await our response</strong> — Our team will review your claim and respond within 2–3 business days.</li>
                    </ol>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">3. Resolution Options</h2>
                    <p>If your damage claim is approved, we will offer one of the following resolutions:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li><strong>Free Replacement:</strong> We will ship a new item at no additional cost.</li>
                        <li><strong>Full Refund:</strong> If a replacement is not available, we will issue a full refund to your original payment method within 7–10 business days.</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">4. Non-Eligible Claims</h2>
                    <p>The following situations do not qualify for a return or refund:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Minor natural variations in colour, texture, or bead size</li>
                        <li>Damage caused by the buyer after delivery (improper handling, exposure to water/chemicals)</li>
                        <li>Claims reported after the 48-hour window</li>
                        <li>Items without photographic evidence of damage</li>
                        <li>Products with tampered or missing packaging</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">5. Order Cancellation</h2>
                    <p>You may request an order cancellation before it has been shipped. Once the order is dispatched, cancellation is no longer possible. To request cancellation, contact us immediately with your order number.</p>
                </div>

                <div>
                    <h2 class="text-lg font-venlury font-semibold text-royal-blue mb-3">6. How to Report an Issue</h2>
                    <p>To report a damaged item, please <a href="{{ route('contact') }}" class="text-royal-blue hover:underline">contact us</a> with:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Your order number</li>
                        <li>Clear photos of the damaged item</li>
                        <li>Photo of the shipping package (showing external damage if any)</li>
                        <li>Brief description of the issue</li>
                    </ul>
                    <p class="mt-3">We aim to resolve all issues with care and fairness. Your trust and satisfaction matter deeply to us.</p>
                </div>

            </div>
        </div>
    </section>

@include('partials.footer')
