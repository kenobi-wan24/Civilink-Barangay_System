@extends('layouts.public')
@section('title', 'Announcements')

@section('content')

@php
  $categoryColors = [
    'events'     => 'bg-green-100 text-green-700',
    'advisories' => 'bg-red-100 text-red-700',
    'projects'   => 'bg-blue-100 text-blue-700',
    'meetings'   => 'bg-purple-100 text-purple-700',
    'environment'=> 'bg-emerald-100 text-emerald-700',
    'education'  => 'bg-pink-100 text-pink-700',
    'livelihood' => 'bg-orange-100 text-orange-700',
    'general'    => 'bg-gray-100 text-gray-700',
  ];
@endphp

<main class="bg-[#F9FAF8] min-h-screen pb-20">
  <div class="max-w-7xl mx-auto px-6 pt-12">

    {{-- Page header --}}
    <header class="mb-10">
      <div class="inline-flex items-center gap-1.5 bg-[#E8F5E3] text-[#2D5A27]
                  text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
        <span class="w-1.5 h-1.5 bg-[#2D5A27] rounded-full"></span>
        OFFICIAL BULLETINS
      </div>
      <h1 class="text-5xl text-gray-900 leading-tight mb-4"
          style="font-family:'Manrope',sans-serif;font-weight:800">
        Community<br/>Announcements
      </h1>
      <p class="text-gray-500 text-sm max-w-md leading-relaxed">
        Stay updated with the latest news, events, and important notices
        from your local Barangay CiviLink council.
      </p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      {{-- ── Left: featured + card grid ── --}}
      <section class="lg:col-span-2 space-y-8">

        {{-- Featured post — TEMPLATE: filled from DB --}}
        @if($featured)
        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100
                        shadow-sm">
          {{-- Image slot — shows placeholder if no image uploaded --}}
          @if($featured->image)
            <img src="{{ asset('storage/'.$featured->image) }}"
                 alt="{{ $featured->title }}"
                 class="w-full h-64 object-cover"/>
          @else
            <div class="w-full h-64 bg-gradient-to-br from-[#2D5A27] to-[#4A7C59]
                        flex items-center justify-center">
              <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor"
                   stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586
                         a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6
                         a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
          @endif

          <div class="p-6">
            {{-- Category badge + date — auto from DB --}}
            <div class="flex items-center gap-2 mb-3">
              @php $cat = strtolower($featured->category ?? 'general'); @endphp
              <span class="text-xs font-semibold px-2.5 py-1 rounded-full uppercase
                           {{ $categoryColors[$cat] ?? 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst($cat) }}
              </span>
              <span class="text-xs text-gray-400">
                {{ $featured->published_at?->format('F d, Y')
                   ?? $featured->created_at->format('F d, Y') }}
              </span>
            </div>

            {{-- Title + excerpt — auto from DB --}}
            <h2 class="text-2xl text-gray-900 font-bold leading-snug mb-3"
                style="font-family:'Manrope',sans-serif">
              {{ $featured->title }}
            </h2>
            <p class="text-sm text-gray-500 leading-relaxed mb-5">
              {{ Str::limit(strip_tags($featured->content), 220) }}
            </p>
            <a href="#"
               class="inline-flex items-center gap-1.5 text-sm font-semibold
                      text-[#2D5A27] hover:underline">
              Read full details
              <svg class="w-4 h-4" fill="none" stroke="currentColor"
                   stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
            </a>
          </div>
        </article>
        @endif

        {{-- Card grid — TEMPLATE: each card = one DB row --}}
        @if($announcements->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          @foreach($announcements as $ann)
          @php $cat = strtolower($ann->category ?? 'general'); @endphp

          <article class="bg-white rounded-2xl overflow-hidden border border-gray-100
                          hover:shadow-md transition-shadow flex flex-col">

            {{-- Card image slot --}}
            @if($ann->image)
              <img src="{{ asset('storage/'.$ann->image) }}"
                   alt="{{ $ann->title }}"
                   class="w-full h-40 object-cover"/>
            @else
              <div class="w-full h-40 bg-gradient-to-br from-[#E8F5E3] to-[#c8e6c0]"></div>
            @endif

            <div class="p-4 flex flex-col flex-1">
              {{-- Category tag + date --}}
              <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full uppercase
                             {{ $categoryColors[$cat] ?? 'bg-gray-100 text-gray-700' }}">
                  {{ ucfirst($cat) }}
                </span>
                <span class="text-xs text-gray-400 ml-auto">
                  {{ $ann->published_at?->format('M d, Y')
                     ?? $ann->created_at->format('M d, Y') }}
                </span>
              </div>

              {{-- Title --}}
              <h3 class="text-sm font-bold text-gray-900 leading-snug mb-2"
                  style="font-family:'Manrope',sans-serif">
                {{ $ann->title }}
              </h3>

              {{-- Excerpt --}}
              <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">
                {{ Str::limit(strip_tags($ann->content), 100) }}
              </p>

              {{-- CTA --}}
              <a href="#"
                 class="inline-flex items-center gap-1 text-xs font-semibold
                        text-[#2D5A27] mt-4 hover:underline">
                Read More
                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </a>
            </div>
          </article>
          @endforeach
        </div>
        @else
          <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <p class="text-gray-400 text-sm">No announcements found.</p>
          </div>
        @endif

        {{-- Pagination --}}
        @if($announcements->hasPages())
        <div class="flex items-center justify-center gap-2 pt-4">
          {{-- Prev --}}
          @if($announcements->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center rounded-full
                         border border-gray-200 text-gray-300 cursor-not-allowed text-sm">
              &lsaquo;
            </span>
          @else
            <a href="{{ $announcements->previousPageUrl() }}"
               class="w-8 h-8 flex items-center justify-center rounded-full
                      border border-gray-200 text-gray-500 hover:border-[#2D5A27]
                      hover:text-[#2D5A27] text-sm transition-colors">
              &lsaquo;
            </a>
          @endif

          {{-- Page numbers --}}
          @foreach($announcements->getUrlRange(1, $announcements->lastPage()) as $page => $url)
            <a href="{{ $url }}"
               class="w-8 h-8 flex items-center justify-center rounded-full text-sm
                      font-medium transition-colors
                      {{ $page == $announcements->currentPage()
                          ? 'bg-[#2D5A27] text-white'
                          : 'border border-gray-200 text-gray-500 hover:border-[#2D5A27] hover:text-[#2D5A27]' }}">
              {{ $page }}
            </a>
          @endforeach

          {{-- Next --}}
          @if($announcements->hasMorePages())
            <a href="{{ $announcements->nextPageUrl() }}"
               class="w-8 h-8 flex items-center justify-center rounded-full
                      border border-gray-200 text-gray-500 hover:border-[#2D5A27]
                      hover:text-[#2D5A27] text-sm transition-colors">
              &rsaquo;
            </a>
          @else
            <span class="w-8 h-8 flex items-center justify-center rounded-full
                         border border-gray-200 text-gray-300 cursor-not-allowed text-sm">
              &rsaquo;
            </span>
          @endif
        </div>
        @endif

      </section>

      {{-- ── Right: sidebar ── --}}
      <aside class="space-y-5">

        {{-- Filter widget — Vue component mounted here --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
          <div class="flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707
                       L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017
                       21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            <span class="text-sm font-semibold text-gray-700"
                  style="font-family:'Manrope',sans-serif">
              Refine Updates
            </span>
          </div>

          {{-- Vue AnnouncementFilter mounted here --}}
          <div
            id="announcement-filter"
            data-search="{{ request('search') }}"
            data-category="{{ request('category', 'all') }}"
            data-action="{{ route('announcements') }}"
          ></div>
        </div>

        {{-- Emergency hotlines widget --}}
        <div class="bg-[#2D5A27] rounded-2xl p-5 text-white">
          <div class="text-2xl mb-3">✱</div>
          <h3 class="font-bold text-base mb-1"
              style="font-family:'Manrope',sans-serif">
            Emergency Hotlines
          </h3>
          <p class="text-white/60 text-xs mb-5 leading-relaxed">
            Immediate assistance for health, fire, or security
            concerns within CiviLink.
          </p>
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-white/80 text-sm">Barangay Patrol</span>
              <span class="font-bold text-sm">911-5000</span>
            </div>
            <div class="border-t border-white/10"></div>
            <div class="flex items-center justify-between">
              <span class="text-white/80 text-sm">Health Center</span>
              <span class="font-bold text-sm">911-5022</span>
            </div>
          </div>
        </div>

      </aside>
    </div>
  </div>
</main>

@endsection