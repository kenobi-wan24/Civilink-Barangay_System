@extends('layouts.admin')
@section('title', 'Inquiries')

@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"
            style="font-family:'Manrope',sans-serif">
            Inquiries
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Messages submitted through the public contact form.
        </p>
    </div>
    @if($unreadCount > 0)
    <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-700
                 text-xs font-semibold px-3 py-1.5 rounded-full">
        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
        {{ $unreadCount }} unread
    </span>
    @endif
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">From</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Purpose</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Message</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Date</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inquiry)
            <tr class="border-b border-gray-50 transition-colors
                       {{ !$inquiry->is_read ? 'bg-yellow-50/40' : 'hover:bg-gray-50/50' }}">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if(!$inquiry->is_read)
                            <span class="w-2 h-2 rounded-full bg-yellow-400
                                         flex-shrink-0"></span>
                        @else
                            <span class="w-2 h-2 flex-shrink-0"></span>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $inquiry->name }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $inquiry->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                 bg-gray-100 text-gray-600">
                        {{ $inquiry->purpose ?? 'General Inquiry' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                    {{ Str::limit($inquiry->message, 60) }}
                </td>
                <td class="px-6 py-4 text-xs text-gray-400">
                    {{ \Carbon\Carbon::parse($inquiry->created_at)->format('M d, Y') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                           class="text-xs font-semibold text-gray-500 border
                                  border-gray-200 px-3 py-1.5 rounded-lg
                                  hover:border-[#2D5A27] hover:text-[#2D5A27]
                                  transition-colors">
                            View
                        </a>
                        <form method="POST"
                              action="{{ route('admin.inquiries.update', $inquiry) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg
                                           border transition-colors
                                           {{ $inquiry->is_read
                                               ? 'border-gray-200 text-gray-400
                                                  hover:border-yellow-300
                                                  hover:text-yellow-600'
                                               : 'border-green-200 text-green-600
                                                  hover:bg-green-50' }}">
                                {{ $inquiry->is_read ? 'Unread' : 'Mark read' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">
                    No inquiries yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $inquiries->links() }}
    </div>
</div>

@endsection