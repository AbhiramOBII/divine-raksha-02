@extends('admin.layouts.app')

@section('title', 'Edit Blog Category')
@section('page-title', 'Edit Blog Category')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.blog-categories.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-royal-blue transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Blog Categories
            </a>
        </div>

        <form method="POST" action="{{ route('admin.blog-categories.update', $blog_category) }}" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Thumbnail -->
            <div x-data="{ preview: {{ $blog_category->thumbnail ? '\'' . asset('storage/' . $blog_category->thumbnail) . '\'' : 'null' }} }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-royal-blue transition-colors"
                     :class="preview ? 'border-green-300' : ''">
                    <template x-if="preview">
                        <img :src="preview" class="mx-auto max-h-48 rounded-lg mb-3">
                    </template>
                    <template x-if="!preview">
                        <div class="mb-3">
                            <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </template>
                    <input type="file" name="thumbnail" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-royal-blue file:text-white hover:file:bg-deep-royal"
                           @change="preview = URL.createObjectURL($event.target.files[0])">
                    <p class="text-xs text-gray-400 mt-2">Max 2MB. JPG, PNG or WebP. Leave empty to keep current.</p>
                </div>
                @error('thumbnail')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $blog_category->title) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Short Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                <input type="text" name="short_description" value="{{ old('short_description', $blog_category->short_description) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">
                @error('short_description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Full Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Description</label>
                <textarea name="full_description" rows="4"
                          class="ckeditor w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-royal-blue focus:border-royal-blue">{{ old('full_description', $blog_category->full_description) }}</textarea>
                @error('full_description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <label class="relative inline-flex items-center cursor-pointer mt-1">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status', $blog_category->status) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-royal-blue/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-royal-blue"></div>
                    <span class="ml-3 text-sm text-gray-600">Active</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Update Category
                </button>
                <a href="{{ route('admin.blog-categories.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@include('admin.partials.ckeditor')
