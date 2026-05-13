@extends('admin.layouts.app')

@section('title', 'Blogs')
@section('page-title', 'Blogs')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <p class="text-sm text-gray-500">Manage blog posts</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}"
           class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Blog Post
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($blogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Thumbnail</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Title</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Category</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Date</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($blogs as $blog)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    @if($blog->thumbnail)
                                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-16 h-12 rounded-lg object-cover">
                                    @else
                                        <img src="{{ asset('images/blog-placeholder.jpg') }}" alt="{{ $blog->title }}" class="w-16 h-12 rounded-lg object-cover">
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $blog->title }}</div>
                                    @if($blog->short_description)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ Str::limit($blog->short_description, 60) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($blog->category)
                                        <span class="text-xs text-gray-700 bg-gray-100 px-2 py-1 rounded">{{ $blog->category->title }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($blog->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Draft</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $blog->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                                           class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                              onsubmit="return confirm('Delete this blog post?')">
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
            @if($blogs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">No blog posts yet</h3>
                <p class="text-sm text-gray-500 mb-4">Create your first blog post.</p>
                <a href="{{ route('admin.blogs.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Add Blog Post
                </a>
            </div>
        @endif
    </div>
@endsection
