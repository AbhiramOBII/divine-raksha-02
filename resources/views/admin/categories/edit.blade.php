@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
    <div class="max-w-3xl">
        <!-- Back Link -->
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-royal-blue mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Categories
        </a>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Category Details</h3>

                <!-- Title -->
                <div class="mb-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Category Title <span class="text-divine-red">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $category->title) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="Enter category title">
                    @error('title')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-5">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="auto-generated-from-title">
                    <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="mb-5">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Category</label>
                    <select name="parent_id" id="parent_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        <option value="">None (Top-level category)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Description -->
                <div class="mb-5">
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $category->short_description) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="Brief description (max 255 characters)">
                    @error('short_description')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Description -->
                <div class="mb-5">
                    <label for="full_description" class="block text-sm font-medium text-gray-700 mb-2">Full Description</label>
                    <textarea name="full_description" id="full_description" rows="5"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                              placeholder="Detailed description of the category">{{ old('full_description', $category->full_description) }}</textarea>
                    @error('full_description')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Image & Settings</h3>

                <!-- Current Image -->
                @if($category->image)
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                            <p class="text-xs text-gray-500">Upload a new image below to replace this one</p>
                        </div>
                    </div>
                @endif

                <!-- Image -->
                <div class="mb-5">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">{{ $category->image ? 'Replace Image' : 'Category Image' }}</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue file:mr-4 file:py-1 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-royal-blue/10 file:text-royal-blue hover:file:bg-royal-blue/20">
                    <p class="mt-1 text-xs text-gray-500">Accepted: JPEG, PNG, JPG, WebP. Max 2MB.</p>
                    @error('image')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-5">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-divine-red">*</span></label>
                    <select name="status" id="status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                        <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div class="mb-5">
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue"
                           placeholder="0">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-divine-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Update Category
                </button>
            </div>
        </form>
    </div>
@endsection
