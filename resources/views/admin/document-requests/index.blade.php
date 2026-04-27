@extends('layouts.admin')
@section('title', 'Document Requests')

@section('content')

{{-- Header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div>
        <h1 class="text-2xl font-bold text-gray-900"
            style="font-family:'Manrope',sans-serif">
            Document Requests
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Manage and process community certificate applications.
        </p>
    </div>
</div>

{{-- Status counter cards --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem">

    {{-- Pending --}}
    <a href="{{ route('admin.document-requests.index', ['status' => 'pending']) }}"
       class="bg-white rounded-2xl border p-5 flex items-center gap-5
              hover:shadow-sm transition-all
              {{ request('status') === 'pending' ? 'border-yellow-300 bg-yellow-50' : 'border-gray-100' }}">
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center
                    justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                 stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1
                         1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0
                         01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                Pending
            </p>
            <p class="text-3xl font-bold text-gray-900"
               style="font-family:'Manrope',sans-serif">
                {{ number_format($counts['pending']) }}
            </p>
        </div>
    </a>

    {{-- Approved --}}
    <a href="{{ route('admin.document-requests.index', ['status' => 'approved']) }}"
       class="bg-white rounded-2xl border p-5 flex items-center gap-5
              hover:shadow-sm transition-all
              {{ request('status') === 'approved' ? 'border-blue-300 bg-blue-50' : 'border-gray-100' }}">
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center
                    justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                 stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                Approved
            </p>
            <p class="text-3xl font-bold text-gray-900"
               style="font-family:'Manrope',sans-serif">
                {{ number_format($counts['approved']) }}
            </p>
        </div>
    </a>

    {{-- Released --}}
    <a href="{{ route('admin.document-requests.index', ['status' => 'released']) }}"
       class="bg-white rounded-2xl border p-5 flex items-center gap-5
              hover:shadow-sm transition-all
              {{ request('status') === 'released' ? 'border-green-300 bg-green-50' : 'border-gray-100' }}">
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center
                    justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                 stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2
                         2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0
                         012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                Released
            </p>
            <p class="text-3xl font-bold text-gray-900"
               style="font-family:'Manrope',sans-serif">
                {{ number_format($counts['released']) }}
            </p>
        </div>
    </a>

</div>

{{-- Search + filter bar --}}
<form method="GET" action="{{ route('admin.document-requests.index') }}"
      class="flex items-center gap-3 mb-5 flex-wrap">

    <div class="relative flex-1 min-w-[200px]">
        <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                 stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M17 11A6 6 0 111 11a6 6 0 0116 0z"/>
            </svg>
        </span>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search resident name or request code..."
               class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4
                      py-2.5 text-sm text-gray-700 placeholder-gray-400
                      focus:outline-none focus:border-[#2D5A27] transition-all"/>
    </div>

    {{-- Status filter pills --}}
    <div class="flex items-center gap-2">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved',
                  'released' => 'Released', 'rejected' => 'Rejected'] as $val => $label)
            <a href="{{ route('admin.document-requests.index',
                        array_merge(request()->except('status','page'),
                        $val !== 'all' ? ['status' => $val] : [])) }}"
               class="text-xs font-semibold px-4 py-2 rounded-full border transition-all
                      {{ (request('status', 'all') === $val || ($val === 'all' && !request('status')))
                          ? 'bg-[#2D5A27] text-white border-[#2D5A27]'
                          : 'bg-white text-gray-600 border-gray-200 hover:border-[#2D5A27]
                             hover:text-[#2D5A27]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

</form>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">
                    Resident Name
                </th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">
                    Document Type
                </th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">
                    Request Date
                </th>
                <th class="text-left text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">
                    Status
                </th>
                <th class="text-right text-xs font-semibold text-gray-400 uppercase
                           tracking-wider px-6 py-4">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            @php
                $avatarColors = [
                    'bg-[#4A7C59] text-white',
                    'bg-gray-200 text-gray-600',
                    'bg-pink-200 text-pink-700',
                    'bg-blue-200 text-blue-700',
                    'bg-amber-200 text-amber-700',
                ];
                $colorClass = $avatarColors[$req->resident->id % count($avatarColors)];
                $initials   = strtoupper(
                    substr($req->resident->first_name, 0, 1) .
                    substr($req->resident->last_name,  0, 1)
                );

                $statusConfig = match($req->status) {
                    'pending'  => ['bg-red-100 text-red-700',    'Pending'],
                    'approved' => ['bg-blue-100 text-blue-700',  'Approved'],
                    'released' => ['bg-green-100 text-green-700','Released'],
                    'rejected' => ['bg-gray-100 text-gray-500',  'Rejected'],
                    default    => ['bg-gray-100 text-gray-500',  ucfirst($req->status)],
                };
            @endphp
            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">

                {{-- Resident --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center
                                    text-xs font-bold flex-shrink-0 overflow-hidden
                                    {{ $colorClass }}">
                            @if($req->resident->profile_picture)
                                <img src="{{ asset('storage/'.$req->resident->profile_picture) }}"
                                     class="w-full h-full object-cover"/>
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $req->resident->full_name }}
                            </p>
                            <p class="text-xs text-gray-400 font-mono">
                                {{ $req->request_code }}
                            </p>
                        </div>
                    </div>
                </td>

                {{-- Document type --}}
                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $req->documentType->name }}
                </td>

                {{-- Date --}}
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $req->requested_at->format('M d, Y') }}
                </td>

                {{-- Status --}}
                <td class="px-6 py-4">
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full
                                 {{ $statusConfig[0] }}">
                        {{ $statusConfig[1] }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">

                        {{-- Approve (only if pending) --}}
                        @if($req->status === 'pending')
                        <form method="POST"
                              action="{{ route('admin.document-requests.approve', $req) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Approve this request?')"
                                    class="w-8 h-8 flex items-center justify-center
                                           border border-gray-200 rounded-lg text-gray-400
                                           hover:border-green-400 hover:text-green-600
                                           hover:bg-green-50 transition-colors"
                                    title="Approve">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                        </form>
                        @else
                        <span class="w-8 h-8 flex items-center justify-center
                                     text-gray-200" title="Already processed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        @endif

                        {{-- View --}}
                        <a href="{{ route('admin.document-requests.show', $req) }}"
                           class="w-8 h-8 flex items-center justify-center
                                  border border-gray-200 rounded-lg text-gray-400
                                  hover:border-[#2D5A27] hover:text-[#2D5A27]
                                  hover:bg-[#E8F5E3] transition-colors"
                           title="View request">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0
                                         8.268 2.943 9.542 7-1.274 4.057-5.064
                                         7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        {{-- Reject (only if pending or approved) --}}
                        @if(in_array($req->status, ['pending', 'approved']))
                        <a href="{{ route('admin.document-requests.show', $req) }}#reject"
                           class="w-8 h-8 flex items-center justify-center
                                  border border-gray-200 rounded-lg text-gray-400
                                  hover:border-red-400 hover:text-red-500
                                  hover:bg-red-50 transition-colors"
                           title="Reject">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9
                                         9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </a>
                        @else
                        <span class="w-8 h-8 flex items-center justify-center text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9
                                         9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        @endif

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-14 text-center">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none"
                         stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1
                                 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0
                                 01-2 2z"/>
                    </svg>
                    <p class="text-sm text-gray-400">No requests found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-100 flex items-center
                justify-between flex-wrap gap-3">
        <p class="text-xs text-gray-400">
            Showing {{ $requests->firstItem() ?? 0 }}–{{ $requests->lastItem() ?? 0 }}
            of {{ number_format($requests->total()) }} requests
        </p>
        @if($requests->hasPages())
        <div class="flex items-center gap-1">
            @if($requests->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-full
                             border border-gray-100 text-gray-300 text-sm">‹</span>
            @else
                <a href="{{ $requests->previousPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded-full
                          border border-gray-200 text-gray-500 text-sm
                          hover:border-[#2D5A27] hover:text-[#2D5A27] transition-colors">
                    ‹
                </a>
            @endif
            @foreach($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="w-8 h-8 flex items-center justify-center rounded-full
                          text-sm font-semibold transition-colors
                          {{ $page == $requests->currentPage()
                              ? 'bg-[#2D5A27] text-white'
                              : 'border border-gray-200 text-gray-500
                                 hover:border-[#2D5A27] hover:text-[#2D5A27]' }}">
                    {{ $page }}
                </a>
            @endforeach
            @if($requests->hasMorePages())
                <a href="{{ $requests->nextPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded-full
                          border border-gray-200 text-gray-500 text-sm
                          hover:border-[#2D5A27] hover:text-[#2D5A27] transition-colors">
                    ›
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded-full
                             border border-gray-100 text-gray-300 text-sm">›</span>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection