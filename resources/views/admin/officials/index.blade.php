@extends('layouts.admin')
@section('title', 'Officials')

@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"
            style="font-family:'Manrope',sans-serif">
            Officials
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage barangay officials. Changes reflect automatically on the public page.
        </p>
    </div>
    <a href="{{ route('admin.officials.create') }}"
       class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
              text-white text-sm font-semibold px-5 py-3 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Official
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Official</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Position</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Order</th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">Status</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($officials as $official)
            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden
                                    bg-[#E8F5E3] flex-shrink-0">
                            @if($official->photo)
                                <img src="{{ asset('storage/'.$official->photo) }}"
                                     class="w-full h-full object-cover"/>
                            @else
                                <div class="w-full h-full flex items-center
                                            justify-center text-[#2D5A27] text-xs
                                            font-bold">
                                    {{ strtoupper(substr($official->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $official->name }}
                        </p>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $official->position }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-400">
                    {{ $official->sort_order }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                 {{ $official->is_active
                                     ? 'bg-green-100 text-green-700'
                                     : 'bg-gray-100 text-gray-400' }}">
                        {{ $official->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.officials.edit', $official) }}"
                           class="text-xs font-semibold text-gray-500 border
                                  border-gray-200 px-3 py-1.5 rounded-lg
                                  hover:border-[#2D5A27] hover:text-[#2D5A27]
                                  transition-colors">
                            Edit
                        </a>
                        <form method="POST"
                              action="{{ route('admin.officials.destroy', $official) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Remove {{ $official->name }}?')"
                                    class="text-xs font-semibold text-red-400 border
                                           border-red-100 px-3 py-1.5 rounded-lg
                                           hover:bg-red-50 hover:border-red-300
                                           transition-colors">
                                Remove
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">
                    No officials yet.
                    <a href="{{ route('admin.officials.create') }}"
                       class="text-[#2D5A27] font-semibold hover:underline ml-1">
                        Add one
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection