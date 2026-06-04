@extends('admin.layouts.app')

@section('title', 'Create Order')
@section('page-title', 'Create Order')

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-royal-blue mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Orders
        </a>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.orders.store') }}" method="POST" x-data="orderForm()" x-init="init()">
            @csrf

            {{-- Customer Information --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Customer Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-divine-red">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('customer_name') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-divine-red">*</span></label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('customer_email') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone <span class="text-divine-red">*</span></label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('customer_phone') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Shipping Address</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-divine-red">*</span></label>
                        <textarea name="shipping_address" rows="2" required
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City <span class="text-divine-red">*</span></label>
                        <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('shipping_city') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State <span class="text-divine-red">*</span></label>
                        <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('shipping_state') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pincode <span class="text-divine-red">*</span></label>
                        <input type="text" name="shipping_pincode" value="{{ old('shipping_pincode') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('shipping_pincode') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Order Items</h3>
                    <button type="button" @click="addItem()"
                            class="inline-flex items-center px-3 py-1.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Item
                    </button>
                </div>

                @error('items') <p class="mb-4 text-sm text-divine-red">{{ $message }}</p> @enderror

                <template x-for="(item, index) in items" :key="index">
                    <div class="flex flex-col md:flex-row gap-3 mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Product</label>
                            <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" required
                                    @change="updatePrice(index)"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                                <option value="">Select product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }} — ₹{{ number_format($product->selling_price) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-24">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Qty</label>
                            <input type="number" :name="'items[' + index + '][quantity]'" x-model.number="item.quantity" min="1" required
                                   @input="calculateTotal()"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        </div>
                        <div class="w-28">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Size</label>
                            <input type="text" :name="'items[' + index + '][size]'" x-model="item.size" placeholder="Optional"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        </div>
                        <div class="w-28">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                            <p class="px-3 py-2 text-sm font-medium text-gray-700" x-text="'₹' + (item.price * item.quantity).toLocaleString('en-IN')"></p>
                        </div>
                        <div class="flex items-end">
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Payment & Totals --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Payment & Totals</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method <span class="text-divine-red">*</span></label>
                        <select name="payment_method" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <option value="cod" {{ old('payment_method') === 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                            <option value="online" {{ old('payment_method') === 'online' ? 'selected' : '' }}>Online Payment</option>
                            <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status <span class="text-divine-red">*</span></label>
                        <select name="payment_status" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <option value="paid" {{ old('payment_status', 'paid') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ old('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('payment_status') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Charge</label>
                        <input type="number" name="shipping_charge" x-model.number="shippingCharge" @input="calculateTotal()" step="0.01" min="0"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount</label>
                        <input type="number" name="discount" x-model.number="discount" @input="calculateTotal()" step="0.01" min="0"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="2"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium" x-text="'₹' + subtotal.toLocaleString('en-IN')"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Shipping</span>
                                <span class="font-medium" x-text="'₹' + shippingCharge.toLocaleString('en-IN')"></span>
                            </div>
                            <div class="flex justify-between text-sm" x-show="discount > 0">
                                <span class="text-gray-500">Discount</span>
                                <span class="font-medium text-green-600" x-text="'-₹' + discount.toLocaleString('en-IN')"></span>
                            </div>
                            <div class="flex justify-between text-base font-bold pt-2 border-t border-gray-200">
                                <span>Total</span>
                                <span class="text-royal-blue" x-text="'₹' + total.toLocaleString('en-IN')"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-royal-blue text-white rounded-lg text-sm font-medium hover:bg-deep-royal transition-colors">
                    Create Order
                </button>
            </div>
        </form>
    </div>

@endsection

@push('head')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderForm', () => ({
            items: [{ product_id: '', quantity: 1, size: '', price: 0 }],
            shippingCharge: 0,
            discount: 0,
            subtotal: 0,
            total: 0,
            productPrices: @json($products->mapWithKeys(fn($p) => [$p->id => (float) $p->selling_price])),

            init() {},

            addItem() {
                this.items.push({ product_id: '', quantity: 1, size: '', price: 0 });
            },

            removeItem(index) {
                this.items.splice(index, 1);
                this.calculateTotal();
            },

            updatePrice(index) {
                const pid = this.items[index].product_id;
                this.items[index].price = this.productPrices[pid] || 0;
                this.calculateTotal();
            },

            calculateTotal() {
                this.subtotal = this.items.reduce((sum, item) => sum + ((item.price || 0) * (item.quantity || 0)), 0);
                this.total = this.subtotal + (this.shippingCharge || 0) - (this.discount || 0);
            }
        }));
    });
</script>
@endpush
