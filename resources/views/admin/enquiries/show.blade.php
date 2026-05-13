@extends('admin.layouts.app')

@section('title', 'Enquiry Details')
@section('page-title', 'Enquiry Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.enquiries.index') }}" class="text-sm text-gray-500 hover:text-royal-blue transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Enquiries
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Message -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ $enquiry->subject }}</h2>
                <p class="text-sm text-gray-400 mb-6">Received {{ $enquiry->created_at->format('M d, Y \a\t h:i A') }}</p>

                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($enquiry->message)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contact Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Contact Info</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Name</p>
                        <p class="text-sm font-medium text-gray-900">{{ $enquiry->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Email</p>
                        <a href="mailto:{{ $enquiry->email }}" class="text-sm text-royal-blue hover:underline">{{ $enquiry->email }}</a>
                    </div>
                    @if($enquiry->phone)
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Phone</p>
                        <a href="tel:{{ $enquiry->phone }}" class="text-sm text-royal-blue hover:underline">{{ $enquiry->phone }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="mailto:{{ $enquiry->email }}?subject=Re: {{ urlencode($enquiry->subject) }}"
                       class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-royal-blue text-white text-sm font-medium rounded-lg hover:bg-deep-royal transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V10z"></path></svg>
                        Reply via Email
                    </a>

                    <form method="POST" action="{{ route('admin.enquiries.destroy', $enquiry) }}" onsubmit="return confirm('Delete this enquiry?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete Enquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
