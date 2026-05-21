@extends('layouts.admin')
@section('title', 'Inquiry')

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-5">
    <a href="{{ route('admin.inquiries.index') }}" class="hover:text-gray-600">
        Inquiries
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">{{ $inquiry->name }}</span>
</nav>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">

        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900"
                    style="font-family:'Manrope',sans-serif">
                    {{ $inquiry->name }}
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">{{ $inquiry->email }}</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                             bg-gray-100 text-gray-600">
                    {{ $inquiry->purpose ?? 'General Inquiry' }}
                </span>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                             {{ $inquiry->is_read
                                 ? 'bg-green-100 text-green-700'
                                 : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $inquiry->is_read ? 'Read' : 'Unread' }}
                </span>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                Message
            </p>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $inquiry->message }}
            </p>
        </div>

        <div class="border-t border-gray-100 mt-6 pt-4 flex items-center
                    justify-between">
            <p class="text-xs text-gray-400">
                Received
                {{ \Carbon\Carbon::parse($inquiry->created_at)->format('F d, Y \a\t h:i A') }}
            </p>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.inquiries.index') }}"
                   class="text-sm font-semibold text-gray-500 border border-gray-200
                          px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                    ← Back
                </a>
                <form method="POST"
                      action="{{ route('admin.inquiries.update', $inquiry) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="text-sm font-semibold px-4 py-2 rounded-xl
                                   border transition-colors
                                   {{ $inquiry->is_read
                                       ? 'border-gray-200 text-gray-500 hover:bg-gray-50'
                                       : 'bg-[#2D5A27] text-white border-[#2D5A27]
                                          hover:bg-[#3d7a35]' }}">
                        {{ $inquiry->is_read ? 'Mark as unread' : 'Mark as read' }}
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection