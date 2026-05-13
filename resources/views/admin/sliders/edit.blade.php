@extends('admin.layouts.app')

@section('title', 'Edit Slider')
@section('page-title', 'Edit Slider')

@section('content')
    <div class="max-w-3xl">
        <!-- Back -->
        <div class="mb-6">
            <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-royal-blue transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Sliders
            </a>
        </div>

        <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Image Upload -->
            <div x-data="{ preview: '{{ asset('storage/' . $slider->image) }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Slider Image</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-royal-blue transition-colors">
                    <img :src="preview" class="mx-auto max-h-48 rounded-lg mb-3">
                    <input type="file" name="image" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-royal-blue file:text-white hover:file:bg-deep-royal"
                           @change="preview = URL.createObjectURL($event.target.files[0])">
                    <p class="text-xs text-gray-400 mt-2">Leave empty to keep current image. Max 5MB.</p>
                </div>
                @error('image')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('description', $slider->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- CTA Title & Link -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CTA Button Title</label>
                    <input type="text" name="cta_title" value="{{ old('cta_title', $slider->cta_title) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    @error('cta_title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CTA Link</label>
                    <input type="text" name="cta_link" value="{{ old('cta_link', $slider->cta_link) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    @error('cta_link')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sort Order & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                    <p class="text-xs text-gray-400 mt-1">Lower numbers appear first</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <label class="relative inline-flex items-center cursor-pointer mt-1">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" {{ old('status', $slider->status) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-royal-blue/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-royal-blue"></div>
                        <span class="ml-3 text-sm text-gray-600">Active</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Update Slider
                </button>
                <a href="{{ route('admin.sliders.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
