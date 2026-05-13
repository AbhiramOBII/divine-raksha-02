@extends('admin.layouts.app')

@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-royal-blue mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Products
        </a>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Section 1: Basic Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Product Title <span class="text-divine-red">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('title') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="auto-generated-from-title">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate</p>
                        @error('slug') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU <span class="text-divine-red">*</span></label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="DR-001">
                        @error('sku') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-divine-red">*</span></label>
                        <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="brand_name" class="block text-sm font-medium text-gray-700 mb-2">Brand Name</label>
                        <input type="text" name="brand_name" id="brand_name" value="{{ old('brand_name') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('brand_name') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                        <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="Brief summary (max 255 chars)">
                        @error('short_description') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="full_description" class="block text-sm font-medium text-gray-700 mb-2">Full Description</label>
                        <textarea name="full_description" id="full_description" rows="5"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('full_description') }}</textarea>
                        @error('full_description') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section 2: Pricing --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Pricing</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-2">Cost / MRP (₹) <span class="text-divine-red">*</span></label>
                        <input type="number" step="0.01" name="cost_price" id="cost_price" value="{{ old('cost_price', '0') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('cost_price') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">Selling Price (₹) <span class="text-divine-red">*</span></label>
                        <input type="number" step="0.01" name="selling_price" id="selling_price" value="{{ old('selling_price', '0') }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('selling_price') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section 3: Images --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Images</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                        <input type="file" name="featured_image" id="featured_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue file:mr-4 file:py-1 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-royal-blue/10 file:text-royal-blue hover:file:bg-royal-blue/20">
                        <p class="mt-1 text-xs text-gray-500">Max 2MB. JPEG, PNG, WebP.</p>
                        @error('featured_image') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                        <input type="file" name="gallery_images[]" id="gallery_images" accept="image/jpeg,image/png,image/jpg,image/webp" multiple
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue file:mr-4 file:py-1 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-royal-blue/10 file:text-royal-blue hover:file:bg-royal-blue/20">
                        <p class="mt-1 text-xs text-gray-500">Select multiple images. Max 2MB each.</p>
                        @error('gallery_images.*') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section 4: Flags & Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Flags & Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-divine-red">*</span></label>
                        <select name="status" id="status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-6">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                            <span class="text-sm text-gray-700">Featured</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="new_product" value="1" {{ old('new_product') ? 'checked' : '' }}
                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                            <span class="text-sm text-gray-700">New Product</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="bestseller" value="1" {{ old('bestseller') ? 'checked' : '' }}
                                   class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                            <span class="text-sm text-gray-700">Bestseller</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Section 5: Physical Details --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Physical Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <input type="text" name="material" id="material" value="{{ old('material') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('material') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                        <input type="text" name="weight" id="weight" value="{{ old('weight') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="e.g. 250g">
                        @error('weight') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-2">Dimensions</label>
                        <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                               placeholder="e.g. 10x5x3 cm">
                        @error('dimensions') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Section 6: Sacred Attributes (Multi-select dropdowns) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Sacred Attributes</h3>
                <p class="text-xs text-gray-500 mb-6">Select multiple values for each attribute</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @include('admin.components.multi-select', [
                        'name' => 'attributes',
                        'label' => 'Attributes',
                        'options' => ['Handcrafted' => 'Handcrafted', 'Natural' => 'Natural', 'Organic' => 'Organic', 'Blessed' => 'Blessed'],
                        'selected' => old('attributes', []),
                    ])

                    @include('admin.components.multi-select', [
                        'name' => 'size',
                        'label' => 'Size',
                        'options' => ['Small' => 'Small', 'Medium' => 'Medium', 'Large' => 'Large', 'Extra Large' => 'Extra Large'],
                        'selected' => old('size', []),
                    ])

                    @include('admin.components.multi-select', [
                        'name' => 'shop_purpose',
                        'label' => 'Shop Purpose',
                        'options' => [
                            'Wealth' => 'Wealth', 'Love' => 'Love', 'Health' => 'Health', 'Luck' => 'Luck',
                            'Protection' => 'Protection', 'Peace' => 'Peace', 'Courage' => 'Courage', 'Balance' => 'Balance',
                        ],
                        'selected' => old('shop_purpose', []),
                    ])

                    @include('admin.components.multi-select', [
                        'name' => 'shop_by_raashi',
                        'label' => 'Shop by Raashi',
                        'options' => [
                            'Mesha' => 'Mesha (Aries)', 'Vrishabha' => 'Vrishabha (Taurus)', 'Mithuna' => 'Mithuna (Gemini)',
                            'Karka' => 'Karka (Cancer)', 'Simha' => 'Simha (Leo)', 'Kanya' => 'Kanya (Virgo)',
                            'Tula' => 'Tula (Libra)', 'Vrischika' => 'Vrischika (Scorpio)', 'Dhanu' => 'Dhanu (Sagittarius)',
                            'Makara' => 'Makara (Capricorn)', 'Kumbha' => 'Kumbha (Aquarius)', 'Meena' => 'Meena (Pisces)',
                        ],
                        'selected' => old('shop_by_raashi', []),
                    ])

                    <div class="md:col-span-2">
                        @include('admin.components.multi-select', [
                            'name' => 'shop_by_numerology',
                            'label' => 'Shop by Numerology',
                            'options' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'],
                            'selected' => old('shop_by_numerology', []),
                        ])
                    </div>
                </div>
            </div>

            {{-- Section 7: SEO --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">SEO</h3>
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        @error('meta_title') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('meta_description') }}</textarea>
                        @error('meta_description') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit"
                        class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">Create Product</button>
            </div>
        </form>
    </div>
@endsection
