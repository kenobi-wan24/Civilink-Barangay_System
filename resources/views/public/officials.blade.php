@extends('layouts.public')
@section('title', 'Officials')

@section('content')

<main class="bg-[#F9FAF8] min-h-screen pb-20">

  {{-- Hero banner --}}
  <header class="bg-[#2D5A27] rounded-3xl mx-6 mt-8 px-8 py-16 text-center mb-14">
    <h1 class="text-4xl text-white mb-4"
        style="font-family:'Manrope',sans-serif;font-weight:700">
      The Barangay Council
    </h1>
    <p class="text-white/60 text-sm max-w-lg mx-auto leading-relaxed">
      Committed to transparency, servant leadership, and the sustainable
      growth of our community. Meet the dedicated individuals serving our barangay.
    </p>
  </header>

  <div class="max-w-5xl mx-auto px-6 space-y-16">

    {{-- ── Executive Leadership ── --}}
    <section>
      <div class="flex items-center gap-4 mb-8">
        <div class="flex-1 h-px bg-gray-200"></div>
        <h2 class="text-xs font-bold tracking-[.2em] text-gray-400 uppercase">
          Executive Leadership
        </h2>
        <div class="flex-1 h-px bg-gray-200"></div>
      </div>

      {{-- Captain card — TEMPLATE, data from DB --}}
      @if($captain)
      <article class="bg-white rounded-2xl border border-gray-100 p-6
                      flex flex-col md:flex-row items-start gap-6 shadow-sm">

        {{-- Photo slot --}}
        <div class="w-36 h-36 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
          @if($captain->photo)
            <img src="{{ asset('storage/'.$captain->photo) }}"
                 alt="{{ $captain->name }}"
                 class="w-full h-full object-cover"/>
          @else
            <div class="w-full h-full bg-[#E8F5E3] flex items-center justify-center">
              <span class="text-3xl font-bold text-[#2D5A27]">
                {{ strtoupper(substr($captain->name, 0, 1)) }}
              </span>
            </div>
          @endif
        </div>

        <div class="flex-1">
          <span class="inline-block bg-[#E8F5E3] text-[#2D5A27] text-xs
                       font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">
            Punong Barangay
          </span>
          {{-- Name from DB --}}
          <h3 class="text-2xl font-bold text-gray-900 mb-2"
              style="font-family:'Manrope',sans-serif">
            {{ $captain->name }}
          </h3>
          <p class="text-sm text-gray-500 leading-relaxed mb-4">
            Lead official overseeing all community initiatives, local
            administration, and public safety programs within the barangay.
          </p>
          <a href="{{ route('contact') }}"
             class="inline-flex items-center gap-2 text-sm text-[#2D5A27]
                    font-medium hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2
                       V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Contact Leader
          </a>
        </div>
      </article>
      @endif
    </section>

    {{-- ── Barangay Councilors ── --}}
    @if($councilors->isNotEmpty())
    <section>
      <div class="flex items-center gap-4 mb-8">
        <div class="flex-1 h-px bg-gray-200"></div>
        <h2 class="text-xs font-bold tracking-[.2em] text-gray-400 uppercase">
          Barangay Councilors
        </h2>
        <div class="flex-1 h-px bg-gray-200"></div>
      </div>

      {{-- Councilor grid — TEMPLATE, auto-fills from DB --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($councilors as $councilor)
        <article class="bg-white rounded-2xl border border-gray-100 p-5
                        flex flex-col items-center text-center
                        hover:shadow-md transition-shadow">

          {{-- Photo slot --}}
          <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 mb-4">
            @if($councilor->photo)
              <img src="{{ asset('storage/'.$councilor->photo) }}"
                   alt="{{ $councilor->name }}"
                   class="w-full h-full object-cover"/>
            @else
              <div class="w-full h-full bg-[#E8F5E3] flex items-center justify-center">
                <span class="text-xl font-bold text-[#2D5A27]">
                  {{ strtoupper(substr($councilor->name, 0, 1)) }}
                </span>
              </div>
            @endif
          </div>

          {{-- Position label from DB --}}
          <span class="text-xs font-bold tracking-widest text-gray-400
                       uppercase mb-1">
            Councilor
          </span>

          {{-- Name from DB --}}
          <h3 class="text-sm font-bold text-gray-900 leading-snug mb-1"
              style="font-family:'Manrope',sans-serif">
            {{ $councilor->name }}
          </h3>

          {{-- Position detail from DB --}}
          <p class="text-xs text-gray-400">{{ $councilor->position }}</p>
        </article>
        @endforeach
      </div>
    </section>
    @endif

    {{-- ── Administrative Core ── --}}
    @if($adminCore->isNotEmpty())
    <section>
      <div class="flex items-center gap-4 mb-8">
        <div class="flex-1 h-px bg-gray-200"></div>
        <h2 class="text-xs font-bold tracking-[.2em] text-gray-400 uppercase">
          Administrative Core
        </h2>
        <div class="flex-1 h-px bg-gray-200"></div>
      </div>

      {{-- Admin core — TEMPLATE, 2-col horizontal cards --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($adminCore as $staff)
        <article class="bg-white rounded-2xl border border-gray-100 p-5
                        flex items-center gap-4 border-l-4 border-l-[#2D5A27]">

          {{-- Photo slot --}}
          <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
            @if($staff->photo)
              <img src="{{ asset('storage/'.$staff->photo) }}"
                   alt="{{ $staff->name }}"
                   class="w-full h-full object-cover"/>
            @else
              <div class="w-full h-full bg-[#E8F5E3] flex items-center justify-center">
                <span class="text-lg font-bold text-[#2D5A27]">
                  {{ strtoupper(substr($staff->name, 0, 1)) }}
                </span>
              </div>
            @endif
          </div>

          <div>
            {{-- Name from DB --}}
            <h3 class="text-sm font-bold text-gray-900"
                style="font-family:'Manrope',sans-serif">
              {{ $staff->name }}
            </h3>
            {{-- Position from DB --}}
            <p class="text-xs font-bold text-[#2D5A27] uppercase
                      tracking-wider mb-1">
              {{ $staff->position }}
            </p>
            <p class="text-xs text-gray-400 leading-snug">
              @if(str_contains($staff->position, 'Secretary'))
                Records management, documentation, and certifications.
              @elseif(str_contains($staff->position, 'Treasurer'))
                Financial oversight, budget planning, and tax collection.
              @endif
            </p>
          </div>
        </article>
        @endforeach
      </div>
    </section>
    @endif

  </div>
</main>

@endsection