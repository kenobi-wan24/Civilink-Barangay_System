@extends('layouts.public')
@section('title', 'Home')

@section('content')

{{-- ── Hero ── --}}
<section class="relative w-full h-[580px] overflow-hidden">
    {{-- Replace with your actual hero image --}}
    <img src="{{ asset('images/aerial_shot(1).png') }}" alt="Barangay aerial view"
         class="absolute inset-0 w-full h-full object-cover"/>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/60"></div>

    <div class="relative z-10 h-full flex flex-col justify-end pb-16 px-8 max-w-7xl mx-auto">
        <span class="inline-flex items-center gap-1.5 bg-[#2D5A27]/80 text-[#a8d5a2] text-xs font-medium px-3 py-1.5 rounded-full mb-5 w-fit border border-[#4A7C59]/40">
            <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
            OFFICIAL COMMUNITY PORTAL
        </span>
        <h1 class="text-white text-5xl md:text-6xl leading-tight mb-4"
            style="font-family:'Manrope',sans-serif;font-weight:800">
            Welcome to<br/>
            <span class="text-[#7ec87a]">CiviLink<br/>Service Hub</span>
        </h1>
        <p class="text-white/80 text-base max-w-md mb-8 leading-relaxed">
            Manage resident records, request documents, and access community services
            through a centralized digital platform designed for efficiency and transparency.
        </p>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 border border-white/70 text-white text-sm font-medium px-5 py-2.5 rounded-full hover:bg-white/10 transition-colors">
                Register as Resident
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('announcements') }}"
               class="inline-flex items-center gap-2 border border-white/50 text-white/80 text-sm font-medium px-5 py-2.5 rounded-full hover:bg-white/10 transition-colors">
                View Public Records
            </a>
        </div>
    </div>
</section>

{{-- ── Legacy / Stats ── --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: stats --}}
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl p-8">
                <h2 class="text-2xl text-gray-900 mb-2" style="font-family:'Manrope',sans-serif;font-weight:700">
                    A Legacy of Service
                </h2>
                <p class="text-sm text-gray-500 leading-relaxed mb-8 max-w-lg">
                    CiviLink has been a model of civic excellence for over three decades. We pride ourselves on transparent governance and active community participation.
                </p>
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <p class="text-3xl font-bold text-[#2D5A27]" style="font-family:'Manrope',sans-serif">
                            {{ number_format($residentCount) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Active Residents</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-[#2D5A27]" style="font-family:'Manrope',sans-serif">0%</p>
                        <p class="text-xs text-gray-400 mt-1">Unresolved Blotters</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-[#2D5A27]" style="font-family:'Manrope',sans-serif">45+</p>
                        <p class="text-xs text-gray-400 mt-1">Green Initiatives</p>
                    </div>
                </div>
            </div>

            {{-- Right: report card --}}
            <div class="bg-[#2D5A27] rounded-2xl p-8 flex flex-col justify-between">
                <div>
                    <h3 class="text-white text-lg mb-2" style="font-family:'Manrope',sans-serif;font-weight:700">
                        Sustainability Report 2024
                    </h3>
                    <p class="text-white/60 text-xs leading-relaxed">
                        Download our latest environmental impact report and see how we're going green.
                    </p>
                </div>
                <a href="#"
                   class="mt-6 inline-block bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-medium px-5 py-2.5 rounded-full transition-colors w-fit">
                    Download PDF
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ── Community Announcements ── --}}
<section class="py-16 bg-[#F9FAF8]">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex items-end justify-between mb-10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-6 h-px bg-gray-400"></span>
                    <span class="text-xs text-gray-400 font-medium tracking-widest uppercase">News & Updates</span>
                </div>
                <h2 class="text-3xl text-gray-900" style="font-family:'Manrope',sans-serif;font-weight:700">
                    Community Announcements
                </h2>
            </div>
            <a href="{{ route('announcements') }}"
               class="hidden md:inline-flex items-center gap-1.5 text-sm text-[#2D5A27] font-medium hover:underline">
                View All News
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @if($announcements->isEmpty())
            <p class="text-gray-400 text-sm text-center py-12">No announcements yet.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($announcements as $ann)
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    @if($ann->image)
                        <img src="{{ asset('storage/'.$ann->image) }}"
                             alt="{{ $ann->title }}"
                             class="w-full h-full object-cover"/>
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#E8F5E3] to-[#c8e6c0] flex items-center justify-center">
                            <svg class="w-10 h-10 text-[#4A7C59]/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"/>
                            </svg>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-[#2D5A27] text-white text-xs font-medium px-2.5 py-1 rounded-full">
                        Community
                    </span>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        {{ $ann->published_at?->format('F d, Y') ?? $ann->created_at->format('F d, Y') }}
                    </div>
                    <h3 class="text-gray-900 text-sm font-semibold leading-snug mb-2" style="font-family:'Manrope',sans-serif">
                        {{ $ann->title }}
                    </h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                        {{ Str::limit(strip_tags($ann->content), 120) }}
                    </p>
                    <a href="{{ route('announcements') }}" class="inline-flex items-center gap-1 text-xs text-[#2D5A27] font-medium mt-4 hover:underline">
                        Read More
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @endif

    </div>
</section>

{{-- ── Stay Connected CTA ── --}}
<section class="py-6 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-[#2D5A27] rounded-3xl px-8 py-14 text-center">
            <h2 class="text-white text-3xl mb-3" style="font-family:'Manrope',sans-serif;font-weight:700">
                Stay Connected with CiviLink
            </h2>
            <p class="text-white/60 text-sm max-w-md mx-auto mb-8 leading-relaxed">
                Receive instant SMS and email notifications for emergency alerts, community events, and official advisories.
            </p>
            <div class="flex items-center justify-center gap-3 max-w-sm mx-auto">
                <input type="email" placeholder="Your email address"
                       class="flex-1 bg-white/10 border border-white/20 text-white placeholder-white/40 text-sm rounded-full px-5 py-2.5 outline-none focus:border-white/50"/>
                <button class="bg-[#5a9a50] hover:bg-[#4a8a40] text-white text-sm font-medium px-6 py-2.5 rounded-full transition-colors whitespace-nowrap">
                    Connect
                </button>
            </div>
        </div>
    </div>
</section>

{{-- Spacer before footer --}}
<div class="h-8"></div>

@endsection
