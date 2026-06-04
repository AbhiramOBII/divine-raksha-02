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

        <form action="{{ route('admin.products.store') }}" method="POST">
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

            {{-- Section 3: Images (Media Library Picker) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6" x-data="mediaPicker()">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Images</h3>

                <!-- Featured Image -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                    <input type="hidden" name="featured_image_path" :value="featuredImage">
                    <div class="flex items-start gap-4">
                        <div x-show="featuredImage" class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                            <img :src="'/storage/' + featuredImage" class="w-full h-full object-cover">
                            <button type="button" @click="featuredImage = ''" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">&times;</button>
                        </div>
                        <button type="button" @click="openPicker('featured')"
                                class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span x-text="featuredImage ? 'Change Image' : 'Select from Media'"></span>
                        </button>
                    </div>
                    @error('featured_image_path') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                </div>

                <!-- Gallery Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                    <template x-for="(img, index) in galleryImages" :key="index">
                        <input type="hidden" name="gallery_image_paths[]" :value="img">
                    </template>

                    <div class="flex flex-wrap gap-3 mb-3" x-show="galleryImages.length > 0">
                        <template x-for="(img, index) in galleryImages" :key="index">
                            <div class="relative w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                <img :src="'/storage/' + img" class="w-full h-full object-cover">
                                <button type="button" @click="galleryImages.splice(index, 1)" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">&times;</button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="openPicker('gallery')"
                            class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add from Media
                    </button>
                    @error('gallery_image_paths') <p class="mt-1 text-sm text-divine-red">{{ $message }}</p> @enderror
                </div>

                <!-- Media Picker Modal -->
                <div x-show="showPicker" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showPicker = false">
                    <div class="fixed inset-0 bg-black/50" @click="showPicker = false"></div>
                    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[80vh] flex flex-col" @click.stop>
                        <div class="flex items-center justify-between p-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Select from Media Library</h3>
                            <button type="button" @click="showPicker = false" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Search & Filter -->
                        <div class="p-4 border-b border-gray-100 flex gap-3">
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="loadMedia()" placeholder="Search images..."
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                            <select x-model="folderFilter" @change="loadMedia()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                                <option value="">All Folders</option>
                                <template x-for="f in folders" :key="f">
                                    <option :value="f" x-text="f.charAt(0).toUpperCase() + f.slice(1)"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Image Grid -->
                        <div class="flex-1 overflow-y-auto p-4">
                            <div x-show="loading" class="text-center py-8 text-gray-500">Loading...</div>
                            <div x-show="!loading && mediaItems.length === 0" class="text-center py-8 text-gray-500">No images found</div>
                            <div x-show="!loading" class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-3">
                                <template x-for="item in mediaItems" :key="item.id">
                                    <div @click="selectMedia(item)"
                                         class="aspect-square rounded-lg overflow-hidden border-2 cursor-pointer transition-all hover:shadow-md"
                                         :class="isSelected(item) ? 'border-royal-blue ring-2 ring-royal-blue/30' : 'border-gray-200 hover:border-gray-400'">
                                        <img :src="'/storage/' + item.path" :alt="item.original_name" class="w-full h-full object-cover" loading="lazy">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="p-4 border-t border-gray-200 flex items-center justify-between">
                            <p class="text-sm text-gray-500"><span x-text="pickerMode === 'gallery' ? tempSelected.length + ' selected' : (tempSelected.length ? '1 selected' : 'None selected')"></span></p>
                            <div class="flex gap-3">
                                <button type="button" @click="showPicker = false" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                                <button type="button" @click="confirmSelection()" class="px-4 py-2 text-sm text-white bg-royal-blue rounded-lg hover:bg-deep-royal">Confirm</button>
                            </div>
                        </div>
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
                            'Education' => 'Education', 'Spiritual Growth' => 'Spiritual Growth', 'Career' => 'Career', 'Emotional Healing' => 'Emotional Healing',
                            'Creativity' => 'Creativity', 'Success' => 'Success', 'Focus' => 'Focus', 'Relationships' => 'Relationships',
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

    @include('admin.components.media-picker-script')
@endsection
