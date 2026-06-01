@include('partials.header')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-100">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-royal-blue transition-colors">Home</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('cart.index') }}" class="hover:text-royal-blue transition-colors">Cart</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-royal-blue font-medium">Checkout</span>
            </nav>
        </div>
    </div>

    <section class="py-10 sm:py-14">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <h1 class="text-2xl sm:text-3xl font-venlury font-bold text-royal-blue mb-8">Checkout</h1>

            <!-- Auth Prompt for Guest -->
            @guest
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-royal-blue flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <p class="text-sm text-gray-700">Already have an account? <a href="{{ route('login') }}?redirect=checkout" class="font-semibold text-royal-blue hover:underline">Login</a> for faster checkout, or continue as guest below.</p>
                    </div>
                    <a href="{{ route('register') }}?redirect=checkout" class="text-sm font-semibold text-royal-blue hover:underline whitespace-nowrap">Create Account</a>
                </div>
            @endguest

            <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="POST" class="flex flex-col lg:flex-row gap-8" x-data="checkoutForm()" @submit.prevent="handleSubmit">
                @csrf

                <!-- Left: Customer & Shipping -->
                <div class="flex-1 space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm">
                                @error('customer_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm">
                                @error('customer_email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm" placeholder="+91 98765 43210">
                                @error('customer_phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                <textarea name="shipping_address" rows="3" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm" placeholder="House/Flat No., Street, Locality">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm">
                                @error('shipping_city') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                                <select name="shipping_state" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm">
                                    <option value="">Select State</option>
                                    @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Delhi','Jammu & Kashmir','Ladakh'] as $state)
                                        <option value="{{ $state }}" {{ old('shipping_state') === $state ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                                @error('shipping_state') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pincode *</label>
                                <input type="text" name="shipping_pincode" value="{{ old('shipping_pincode') }}" required maxlength="6" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm" placeholder="600001">
                                @error('shipping_pincode') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>
                        <div class="space-y-3">
                            <input type="hidden" name="payment_method" value="online">
                            <label class="flex items-center gap-4 p-4 border border-royal-blue bg-royal-blue/5 rounded-xl">
                                <input type="radio" name="payment_method_display" value="online" checked disabled class="w-4 h-4 text-royal-blue focus:ring-royal-blue">
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-gray-900">Online Payment</span>
                                    <p class="text-xs text-gray-500">UPI, Credit/Debit Card, Net Banking</p>
                                </div>
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </label>
                        </div>
                        @error('payment_method') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Notes (Optional)</h3>
                        <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm" placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="lg:w-96">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                        <!-- Items -->
                        <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                            @foreach($cartItems as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                        <img src="{{ $item['product']->featured_image ? asset('storage/' . $item['product']->featured_image) : asset('images/karungulai.jpg') }}" alt="{{ $item['product']->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item['product']->title }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900">₹{{ number_format($item['subtotal']) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Code -->
                        <div class="border-t border-gray-200 pt-4 mb-4" x-data="couponHandler()">
                            <div x-show="!applied" class="flex gap-2">
                                <input type="text" x-model="code" placeholder="Coupon code" class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue uppercase" @keydown.enter.prevent="applyCoupon()">
                                <button type="button" @click="applyCoupon()" :disabled="loading || !code" class="px-4 py-2 bg-royal-blue text-white text-sm rounded-lg hover:bg-deep-royal transition-colors disabled:opacity-50 whitespace-nowrap">
                                    <span x-show="!loading">Apply</span>
                                    <span x-show="loading">...</span>
                                </button>
                            </div>
                            <div x-show="applied" x-cloak class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                <div>
                                    <span class="text-xs font-semibold text-green-700" x-text="appliedCode"></span>
                                    <span class="text-xs text-green-600 ml-1">- ₹<span x-text="discountAmount"></span></span>
                                </div>
                                <button type="button" @click="removeCoupon()" class="text-red-500 hover:text-red-700 text-xs font-medium">Remove</button>
                            </div>
                            <p x-show="message" x-cloak class="text-xs mt-1.5" :class="applied ? 'text-green-600' : 'text-red-500'" x-text="message"></p>
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-3 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium text-gray-900">₹{{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="font-medium {{ $shipping == 0 ? 'text-green-600' : 'text-gray-900' }}">{{ $shipping == 0 ? 'FREE' : '₹' . number_format($shipping) }}</span>
                            </div>
                            <div x-data="{ couponDisc: {{ $couponDiscount }} }" x-show="couponDisc > 0" x-cloak class="flex justify-between text-green-600">
                                <span>Coupon Discount</span>
                                <span class="font-medium" id="coupon-discount-row">-₹<span id="coupon-discount-val">{{ number_format($couponDiscount) }}</span></span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="font-bold text-xl text-royal-blue" id="order-total">₹{{ number_format($total) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="mt-6 block w-full bg-royal-blue text-white text-center py-4 rounded-full font-semibold hover:bg-deep-royal transition-colors sacred-glow disabled:opacity-50 disabled:cursor-not-allowed" :disabled="processing">
                            <span x-show="!processing">Place Order</span>
                            <span x-show="processing" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Processing...
                            </span>
                        </button>

                        <p class="text-xs text-gray-500 text-center mt-3">By placing this order, you agree to our Terms & Conditions.</p>

                        <!-- Error message -->
                        <div x-show="errorMessage" x-cloak class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-xs text-red-600 text-center" x-text="errorMessage"></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function couponHandler() {
            return {
                code: '',
                loading: false,
                applied: {{ $coupon ? 'true' : 'false' }},
                appliedCode: '{{ $coupon["code"] ?? "" }}',
                discountAmount: '{{ number_format($couponDiscount) }}',
                message: '',

                async applyCoupon() {
                    if (!this.code.trim()) return;
                    this.loading = true;
                    this.message = '';

                    try {
                        const res = await fetch('{{ route("coupon.apply") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ code: this.code }),
                        });
                        const data = await res.json();

                        if (data.success) {
                            this.applied = true;
                            this.appliedCode = data.coupon_code;
                            this.discountAmount = new Intl.NumberFormat('en-IN').format(data.discount);
                            this.message = data.message;
                            // Reload to recalculate totals
                            window.location.reload();
                        } else {
                            this.message = data.message;
                        }
                    } catch (e) {
                        this.message = 'Failed to apply coupon.';
                    }
                    this.loading = false;
                },

                async removeCoupon() {
                    try {
                        await fetch('{{ route("coupon.remove") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                        });
                        this.applied = false;
                        this.appliedCode = '';
                        this.discountAmount = '0';
                        this.code = '';
                        this.message = '';
                        window.location.reload();
                    } catch (e) {
                        this.message = 'Failed to remove coupon.';
                    }
                }
            }
        }

        function checkoutForm() {
            return {
                processing: false,
                errorMessage: '',

                async handleSubmit() {
                    this.processing = true;
                    this.errorMessage = '';

                    const form = document.getElementById('checkout-form');
                    const formData = new FormData(form);
                    const paymentMethod = formData.get('payment_method');

                    try {
                        // Submit the form to create the order
                        const response = await fetch('{{ route("checkout.placeOrder") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            // Validation errors
                            if (data.errors) {
                                const firstError = Object.values(data.errors)[0][0];
                                this.errorMessage = firstError;
                            } else {
                                this.errorMessage = data.message || 'Something went wrong.';
                            }
                            this.processing = false;
                            return;
                        }

                        // Handle COD - redirect to success
                        if (data.payment_method === 'cod') {
                            window.location.href = data.redirect;
                            return;
                        }

                        // If online payment, initiate Razorpay
                        if (data.payment_method === 'online') {
                            await this.initiateRazorpay(data.order_id);
                        }
                    } catch (error) {
                        this.errorMessage = 'Network error. Please try again.';
                        this.processing = false;
                    }
                },

                async initiateRazorpay(orderId) {
                    try {
                        // Create Razorpay order
                        const response = await fetch('{{ route("payment.createOrder") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ order_id: orderId }),
                        });

                        const data = await response.json();

                        if (!data.success) {
                            this.errorMessage = 'Failed to create payment order.';
                            this.processing = false;
                            return;
                        }

                        // Open Razorpay Checkout
                        const options = {
                            key: data.key,
                            amount: data.amount,
                            currency: data.currency,
                            name: data.name,
                            description: data.description,
                            order_id: data.order_id,
                            prefill: data.prefill,
                            theme: {
                                color: '#1a237e',
                            },
                            handler: async (response) => {
                                await this.verifyPayment(response);
                            },
                            modal: {
                                ondismiss: () => {
                                    this.errorMessage = 'Payment was cancelled. Your order is saved — you can retry payment.';
                                    this.processing = false;
                                }
                            }
                        };

                        const rzp = new Razorpay(options);
                        rzp.on('payment.failed', (response) => {
                            this.errorMessage = 'Payment failed: ' + response.error.description;
                            this.processing = false;
                        });
                        rzp.open();
                    } catch (error) {
                        this.errorMessage = 'Failed to initialize payment gateway.';
                        this.processing = false;
                    }
                },

                async verifyPayment(razorpayResponse) {
                    try {
                        const response = await fetch('{{ route("payment.verify") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                razorpay_order_id: razorpayResponse.razorpay_order_id,
                                razorpay_payment_id: razorpayResponse.razorpay_payment_id,
                                razorpay_signature: razorpayResponse.razorpay_signature,
                            }),
                        });

                        const data = await response.json();

                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            this.errorMessage = data.message || 'Payment verification failed.';
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            }
                            this.processing = false;
                        }
                    } catch (error) {
                        this.errorMessage = 'Verification failed. Please contact support.';
                        this.processing = false;
                    }
                }
            }
        }
    </script>

@include('partials.footer')
