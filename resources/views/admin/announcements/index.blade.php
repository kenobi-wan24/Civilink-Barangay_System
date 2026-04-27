@extends('layouts.admin')
@section('title', 'Announcements')

@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"
            style="font-family:'Manrope',sans-serif">
            Announcements
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Published announcements appear on the public site automatically.
        </p>
    </div>
    <a href="{{ route('admin.announcements.create') }}"
       class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
              text-white text-sm font-semibold px-5 py-3 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        New Announcement
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Title</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Category</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Status</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Date</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($announcements as $ann)
            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($ann->image)
                            <img src="{{ asset('storage/'.$ann->image) }}"
                                 class="w-10 h-10 rounded-lg object-cover flex-shrink-0"/>
                        @else
                            <div class="w-10 h-10 rounded-lg bg-[#E8F5E3] flex items-center
                                        justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-[#2D5A27]" fill="none"
                                     stroke="currentColor" stroke-width="1.5"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592
                                             l-2.147-6.15M18 13a3 3 0 100-6M5.436
                                             13.683A4.001 4.001 0 017 6h1.832c4.1 0
                                             7.625-1.234 9.168-3v14c-1.543-1.766
                                             -5.067-3-9.168-3H7a3.988 3.988 0
                                             01-1.564-.317z"/>
                                </svg>
                            </div>
                        @endif
                        <p class="text-sm font-semibold text-gray-800 line-clamp-1">
                            {{ $ann->title }}
                        </p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                 bg-gray-100 text-gray-600 capitalize">
                        {{ $ann->category ?? 'general' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                 {{ $ann->is_published
                                     ? 'bg-green-100 text-green-700'
                                     : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $ann->is_published ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-xs text-gray-400">
                    {{ $ann->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.announcements.edit', $ann) }}"
                           class="text-xs font-semibold text-gray-500 border
                                  border-gray-200 px-3 py-1.5 rounded-lg
                                  hover:border-[#2D5A27] hover:text-[#2D5A27]
                                  transition-colors">
                            Edit
                        </a>
                        <form method="POST"
                              action="{{ route('admin.announcements.destroy', $ann) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this announcement?')"
                                    class="text-xs font-semibold text-red-400 border
                                           border-red-100 px-3 py-1.5 rounded-lg
                                           hover:bg-red-50 hover:border-red-300
                                           transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">
                    No announcements yet.
                    <a href="{{ route('admin.announcements.create') }}"
                       class="text-[#2D5A27] font-semibold hover:underline ml-1">
                        Create one
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $announcements->links() }}
    </div>
</div>

@endsection
