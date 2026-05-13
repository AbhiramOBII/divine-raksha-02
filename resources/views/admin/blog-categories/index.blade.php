@extends('admin.layouts.app')

@section('title', 'Blog Categories')
@section('page-title', 'Blog Categories')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <p class="text-sm text-gray-500">Manage blog categories</p>
        </div>
        <a href="{{ route('admin.blog-categories.create') }}"
           class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Category
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Thumbnail</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Title</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Blogs</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    @if($category->thumbnail)
                                        <img src="{{ asset('storage/' . $category->thumbnail) }}" alt="{{ $category->title }}" class="w-14 h-14 rounded-lg object-cover">
                                    @else
                                        <img src="{{ asset('images/blog-placeholder.jpg') }}" alt="{{ $category->title }}" class="w-14 h-14 rounded-lg object-cover">
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $category->title }}</div>
                                    @if($category->short_description)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ Str::limit($category->short_description, 60) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-600">{{ $category->blogs_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($category->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                           class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST"
                                              onsubmit="return confirm('Delete this category? All blogs in this category will also be deleted.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-divine-red hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">No blog categories yet</h3>
                <p class="text-sm text-gray-500 mb-4">Create your first blog category to organize posts.</p>
                <a href="{{ route('admin.blog-categories.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Add Category
                </a>
            </div>
        @endif
    </div>
@endsection
