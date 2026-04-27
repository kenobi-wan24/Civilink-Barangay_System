@extends('layouts.admin')
@section('title', 'Residents')

@section('content')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-600">
        Main Portal
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">Resident Registry</span>
</nav>

{{-- Header row --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;
            gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div>
        <h1 class="text-3xl font-bold text-gray-900"
            style="font-family:'Manrope',sans-serif">
            Resident Management
        </h1>
        <p class="text-sm text-gray-500 mt-1 max-w-lg">
            Efficiently manage, filter, and track community members within
            the Barangay CiviLink ecosystem.
        </p>
    </div>
    <a href="{{ route('admin.residents.create') }}"
       class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
              text-white text-sm font-semibold px-5 py-3 rounded-xl
              transition-colors flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0
                     018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Add Resident
    </a>
</div>

{{-- Filters + total card --}}
<div style="display:flex;align-items:stretch;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">

    {{-- Vue filter dropdowns --}}
    <div id="resident-filter"
         data-action="{{ route('admin.residents.index') }}"
         data-zone="{{ request('zone') }}"
         data-gender="{{ request('gender') }}"
         data-status="{{ request('status') }}"
         data-search="{{ request('search') }}">
    </div>

    {{-- Total card --}}
    <div class="bg-[#2D5A27] rounded-xl px-6 py-3 flex items-center gap-4
                min-w-[180px] ml-auto">
        <div>
            <p class="text-white/60 text-xs font-semibold uppercase tracking-wider">
                Total Registered
            </p>
            <p class="text-white text-2xl font-bold"
               style="font-family:'Manrope',sans-serif">
                {{ number_format($total) }}
            </p>
        </div>
        <svg class="w-10 h-10 text-white/20 flex-shrink-0" fill="currentColor"
             viewBox="0 0 24 24">
            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656
                     -.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7
                     20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0
                     019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0
                     11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
    </div>
</div>

{{-- Search bar --}}
<form method="GET" action="{{ route('admin.residents.index') }}"
      class="mb-5 flex gap-3">
    <input type="hidden" name="zone"   value="{{ request('zone') }}"/>
    <input type="hidden" name="gender" value="{{ request('gender') }}"/>
    <input type="hidden" name="status" value="{{ request('status') }}"/>
    <div class="relative flex-1 max-w-md">
        <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                 stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M17 11A6 6 0 111 11a6 6 0 0116 0z"/>
            </svg>
        </span>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search the community directory..."
               class="w-full bg-white border border-gray-200 rounded-xl pl-10
                      pr-4 py-2.5 text-sm text-gray-700 placeholder-gray-400
                      focus:outline-none focus:border-[#2D5A27] transition-all"/>
    </div>
    <button type="submit"
            class="bg-[#2D5A27] text-white text-sm font-semibold px-6
                   py-2.5 rounded-xl hover:bg-[#3d7a35] transition-colors">
        Search
    </button>
</form>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-4">
                    Resident Name
                </th>
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-4">
                    Age
                </th>
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-4">
                    Residential Address
                </th>
                <th class="text-left text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-4">
                    Classification Tags
                </th>
                <th class="text-right text-xs font-semibold text-gray-400
                           uppercase tracking-wider px-6 py-4">
                    Profile & Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($residents as $resident)
            @php
                $avatarColors = [
                    'bg-[#4A7C59] text-white',
                    'bg-gray-200 text-gray-600',
                    'bg-pink-200 text-pink-700',
                    'bg-blue-200 text-blue-700',
                    'bg-amber-200 text-amber-700',
                    'bg-purple-200 text-purple-700',
                ];
                $colorClass = $avatarColors[$resident->id % count($avatarColors)];
                $initials   = strtoupper(
                    substr($resident->first_name, 0, 1) .
                    substr($resident->last_name,  0, 1)
                );
            @endphp

            {{-- Row dims out if inactive --}}
            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors
                       {{ !$resident->is_active ? 'opacity-60' : '' }}">

                {{-- Name + ID --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-full flex items-center
                                    justify-center text-sm font-bold
                                    flex-shrink-0 overflow-hidden
                                    {{ $colorClass }}">
                            @if($resident->profile_picture)
                                <img src="{{ asset('storage/'.$resident->profile_picture) }}"
                                     alt="{{ $resident->full_name }}"
                                     class="w-full h-full object-cover"/>
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-gray-900">
                                    {{ $resident->full_name }}
                                </p>
                                {{-- Inactive badge --}}
                                @if(!$resident->is_active)
                                    <span class="text-xs font-semibold px-2 py-0.5
                                                 rounded-full bg-gray-100 text-gray-400">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">
                                ID: {{ $resident->resident_code }}
                            </p>
                        </div>
                    </div>
                </td>

                {{-- Age --}}
                <td class="px-6 py-4">
                    <span class="text-sm font-semibold text-gray-700">
                        {{ $resident->age }}
                    </span>
                </td>

                {{-- Address --}}
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-700">{{ $resident->purok_zone }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Since {{ $resident->created_at->format('Y') }}
                    </p>
                </td>

                {{-- Tags --}}
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1.5">
                        @if($resident->is_senior_citizen)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-purple-100 text-purple-700">
                                Senior Citizen
                            </span>
                        @endif
                        @if($resident->is_voter)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-[#E8F5E3] text-[#2D5A27]">
                                Voter
                            </span>
                        @endif
                        @if($resident->is_pwd)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-orange-100 text-orange-700">
                                PWD
                            </span>
                        @endif
                        @if($resident->is_solo_parent)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-pink-100 text-pink-700">
                                Solo Parent
                            </span>
                        @endif
                        @if(!$resident->is_voter && !$resident->is_senior_citizen
                            && !$resident->is_pwd && !$resident->is_solo_parent)
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </div>
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.residents.show', $resident) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold
                                  text-gray-600 border border-gray-200 px-3 py-1.5
                                  rounded-lg hover:border-[#2D5A27] hover:text-[#2D5A27]
                                  transition-colors bg-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0
                                         8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542
                                         7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Profile
                        </a>
                        {{-- Only show edit button for active residents --}}
                        @if($resident->is_active)
                            <a href="{{ route('admin.residents.edit', $resident) }}"
                               class="w-8 h-8 flex items-center justify-center border
                                      border-gray-200 rounded-lg hover:border-[#2D5A27]
                                      hover:text-[#2D5A27] text-gray-400 transition-colors
                                      bg-white">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2
                                             0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828
                                             L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @else
                            {{-- Reactivate quick action --}}
                            <form method="POST"
                                  action="{{ route('admin.residents.reactivate', $resident) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Reactivate {{ $resident->full_name }}?')"
                                        class="w-8 h-8 flex items-center justify-center border
                                               border-green-200 rounded-lg hover:border-[#2D5A27]
                                               hover:text-[#2D5A27] text-green-500 transition-colors
                                               bg-white"
                                        title="Reactivate Resident">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582
                                                 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0
                                                 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-14 text-center">
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-10 h-10 text-gray-200" fill="none"
                             stroke="currentColor" stroke-width="1.5"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10
                                     0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3
                                     3 0 015.356-1.857M7 20v-2c0-.656.126-1.283
                                     .356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3
                                     3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm text-gray-400">No residents found.</p>
                        <a href="{{ route('admin.residents.create') }}"
                           class="text-xs text-[#2D5A27] font-semibold hover:underline mt-1">
                            Add the first resident
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-100 flex items-center
                justify-between flex-wrap gap-3">
        <p class="text-xs text-gray-400">
            Showing {{ $residents->firstItem() ?? 0 }}–{{ $residents->lastItem() ?? 0 }}
            of {{ number_format($residents->total()) }} residents
        </p>
        @if($residents->hasPages())
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($residents->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center rounded-full
                             border border-gray-100 text-gray-300 text-sm
                             cursor-not-allowed">‹</span>
            @else
                <a href="{{ $residents->previousPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded-full
                          border border-gray-200 text-gray-500 text-sm
                          hover:border-[#2D5A27] hover:text-[#2D5A27] transition-colors">
                   ‹
                </a>
            @endif

            {{-- Pages --}}
            @foreach($residents->getUrlRange(1, $residents->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="w-8 h-8 flex items-center justify-center rounded-full
                          text-sm font-semibold transition-colors
                          {{ $page == $residents->currentPage()
                              ? 'bg-[#2D5A27] text-white'
                              : 'border border-gray-200 text-gray-500
                                 hover:border-[#2D5A27] hover:text-[#2D5A27]' }}">
                    {{ $page }}
                </a>
            @endforeach

            {{-- Next --}}
            @if($residents->hasMorePages())
                <a href="{{ $residents->nextPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center rounded-full
                          border border-gray-200 text-gray-500 text-sm
                          hover:border-[#2D5A27] hover:text-[#2D5A27] transition-colors">
                   ›
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded-full
                             border border-gray-100 text-gray-300 text-sm
                             cursor-not-allowed">›</span>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection