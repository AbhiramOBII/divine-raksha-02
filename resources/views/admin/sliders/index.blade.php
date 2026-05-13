@extends('admin.layouts.app')

@section('title', 'Sliders')
@section('page-title', 'Sliders')

@section('content')
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <p class="text-sm text-gray-500">Manage homepage hero slider banners</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}"
           class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Slider
        </a>
    </div>

    <!-- Sliders List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($sliders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Order</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Image</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Title</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">CTA</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-600">Status</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($sliders as $slider)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-600">{{ $slider->sort_order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-32 h-16 rounded-lg object-cover">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $slider->title }}</div>
                                    @if($slider->description)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ Str::limit($slider->description, 60) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($slider->cta_title)
                                        <span class="text-xs text-gray-700 bg-gray-100 px-2 py-1 rounded">{{ $slider->cta_title }}</span>
                                        @if($slider->cta_link)
                                            <p class="text-xs text-gray-400 mt-1">{{ Str::limit($slider->cta_link, 30) }}</p>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">No CTA</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($slider->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.sliders.edit', $slider) }}"
                                           class="p-2 text-gray-500 hover:text-royal-blue hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                                              onsubmit="return confirm('Delete this slider?')">
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
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-sm font-medium text-gray-900 mb-1">No sliders yet</h3>
                <p class="text-sm text-gray-500 mb-4">Add your first homepage slider banner.</p>
                <a href="{{ route('admin.sliders.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                    Add Slider
                </a>
            </div>
        @endif
    </div>
@endsection
