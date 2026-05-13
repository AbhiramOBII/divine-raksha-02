@extends('admin.layouts.app')

@section('title', 'Enquiries')
@section('page-title', 'Enquiries')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.enquiries.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('filter') ? 'bg-royal-blue text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }} transition-colors">
                All ({{ $enquiries->total() }})
            </a>
            <a href="{{ route('admin.enquiries.index', ['filter' => 'unread']) }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') === 'unread' ? 'bg-royal-blue text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }} transition-colors">
                Unread ({{ $unreadCount }})
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($enquiries->count())
            <div class="divide-y divide-gray-100">
                @foreach($enquiries as $enquiry)
                    <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors {{ !$enquiry->is_read ? 'bg-blue-50/50' : '' }}">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    @if(!$enquiry->is_read)
                                        <span class="w-2 h-2 rounded-full bg-royal-blue shrink-0"></span>
                                    @endif
                                    <h3 class="text-sm font-semibold text-gray-900 truncate {{ !$enquiry->is_read ? '' : 'font-medium' }}">{{ $enquiry->subject }}</h3>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">{{ $enquiry->name }} &middot; <span class="text-gray-400">{{ $enquiry->email }}</span></p>
                                <p class="text-sm text-gray-400 truncate">{{ Str::limit($enquiry->message, 100) }}</p>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap shrink-0">{{ $enquiry->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-gray-100">
                {{ $enquiries->withQueryString()->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <p class="text-gray-500 text-sm">No enquiries yet.</p>
            </div>
        @endif
    </div>
@endsection
