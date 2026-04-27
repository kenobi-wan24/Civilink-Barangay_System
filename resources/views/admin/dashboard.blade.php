@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- Welcome banner --}}
<div class="bg-[#2D5A27] rounded-2xl px-9 py-7 mb-6 relative overflow-hidden">
    <div class="absolute right-0 top-0 bottom-0 w-64 opacity-10 pointer-events-none">
        <svg viewBox="0 0 200 200" class="w-full h-full">
            <circle cx="150" cy="50"  r="80"  fill="white"/>
            <circle cx="50"  cy="150" r="60"  fill="white"/>
        </svg>
    </div>
    <div class="relative flex items-start justify-between gap-6 flex-wrap">
        <div>
            <p class="text-white/50 text-xs font-semibold uppercase tracking-widest mb-1">
                Management Portal
            </p>
            <h1 class="text-white text-2xl font-bold mb-1"
                style="font-family:'Manrope',sans-serif">
                Welcome back, {{ explode(' ', auth()->user()->name)[0] }}.
            </h1>
            <p class="text-white/60 text-sm leading-relaxed max-w-sm">
                Your community overview for today.
                @if($stats['pending'] > 0)
                    There are
                    <span class="text-white font-semibold">
                        {{ $stats['pending'] }} pending
                    </span>
                    document {{ Str::plural('request', $stats['pending']) }}
                    awaiting review.
                @else
                    All document requests are up to date.
                @endif
            </p>
        </div>

        {{-- Time + date --}}
        <div class="flex items-center gap-3">
            <div class="bg-white/10 border border-white/10 rounded-xl
                        px-5 py-3 text-center min-w-[90px]">
                <p class="text-white/50 text-xs uppercase tracking-wider mb-1">
                    Local time
                </p>
                <p class="text-white text-xl font-bold"
                   style="font-family:'Manrope',sans-serif"
                   id="live-time">--:--</p>
            </div>
            <div class="bg-white/10 border border-white/10 rounded-xl
                        px-5 py-3 text-center min-w-[90px]">
                <p class="text-white/50 text-xs uppercase tracking-wider mb-1">
                    Date
                </p>
                <p class="text-white text-sm font-bold"
                   style="font-family:'Manrope',sans-serif"
                   id="live-date">--</p>
            </div>
        </div>
    </div>
</div>

{{-- Stat cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">

    {{-- Total residents --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-[#E8F5E3] flex items-center
                        justify-center">
                <svg class="w-5 h-5 text-[#2D5A27]" fill="none"
                     stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10
                             0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3
                             3 0 015.356-1.857M7 20v-2c0-.656.126-1.283
                             .356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3
                             3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-green-500 bg-green-50
                         px-2 py-0.5 rounded-full">
                Active
            </span>
        </div>
        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">
            Total Residents
        </p>
        <p class="text-3xl font-bold text-gray-900"
           style="font-family:'Manrope',sans-serif">
            {{ number_format($stats['total_residents']) }}
        </p>
    </div>

    {{-- Pending documents --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center
                        justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none"
                     stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1
                             1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0
                             01-2 2z"/>
                </svg>
            </div>
            @if($stats['pending'] > 0)
                <span class="text-xs font-semibold text-red-500 bg-red-50
                             px-2 py-0.5 rounded-full">
                    {{ $stats['pending'] }} Urgent
                </span>
            @endif
        </div>
        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">
            Pending Documents
        </p>
        <p class="text-3xl font-bold text-gray-900"
           style="font-family:'Manrope',sans-serif">
            {{ $stats['pending'] }}
        </p>
    </div>

    {{-- Released --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center
                        justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none"
                     stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2
                             2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0
                             012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-blue-500 bg-blue-50
                         px-2 py-0.5 rounded-full">
                Steady
            </span>
        </div>
        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">
            Total Released
        </p>
        <p class="text-3xl font-bold text-gray-900"
           style="font-family:'Manrope',sans-serif">
            {{ number_format($stats['released']) }}
        </p>
    </div>

    {{-- New this month --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center
                        justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none"
                     stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0
                             018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-purple-500 bg-purple-50
                         px-2 py-0.5 rounded-full">
                +{{ $stats['new_this_month'] }} New
            </span>
        </div>
        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">
            New This Month
        </p>
        <p class="text-3xl font-bold text-gray-900"
           style="font-family:'Manrope',sans-serif">
            {{ $stats['new_this_month'] }}
        </p>
    </div>

</div>

{{-- Chart + Activity --}}
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;margin-bottom:1.5rem">

    {{-- Chart card --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-bold text-gray-900"
                    style="font-family:'Manrope',sans-serif">
                    Community Growth
                </h2>
                <p class="text-xs text-gray-400 mt-0.5">
                    Resident registrations — last 7 months
                </p>
            </div>
            <span class="text-xs font-semibold text-gray-400 bg-gray-50
                         border border-gray-100 px-3 py-1.5 rounded-full">
                Residents
            </span>
        </div>

        {{-- Vue chart mounted here --}}
        <div
            id="dashboard-chart"
            data-labels="{{ json_encode(array_column($chartData, 'month')) }}"
            data-values="{{ json_encode(array_column($chartData, 'count')) }}"
        ></div>
    </div>

    {{-- Recent activity --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-bold text-gray-900"
                style="font-family:'Manrope',sans-serif">
                Recent Activity
            </h2>
            <a href="{{ route('admin.document-requests.index') }}"
               class="text-xs text-[#2D5A27] font-semibold hover:underline">
                View All
            </a>
        </div>

        <div class="space-y-4">
            @forelse($recentActivity as $log)
            <div class="flex items-start gap-3">
                {{-- Icon by action type --}}
                @php
                    $iconBg = match(true) {
                        str_contains($log->action, 'approved')  => 'bg-green-100',
                        str_contains($log->action, 'rejected')  => 'bg-red-100',
                        str_contains($log->action, 'released')  => 'bg-blue-100',
                        str_contains($log->action, 'created')   => 'bg-purple-100',
                        default                                  => 'bg-gray-100',
                    };
                    $iconColor = match(true) {
                        str_contains($log->action, 'approved')  => 'text-green-600',
                        str_contains($log->action, 'rejected')  => 'text-red-600',
                        str_contains($log->action, 'released')  => 'text-blue-600',
                        str_contains($log->action, 'created')   => 'text-purple-600',
                        default                                  => 'text-gray-500',
                    };
                @endphp
                <div class="w-8 h-8 rounded-xl {{ $iconBg }} flex items-center
                            justify-center flex-shrink-0">
                    <svg class="w-4 h-4 {{ $iconColor }}" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1
                                 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-800 leading-snug">
                        {{ Str::limit($log->description ?? ucfirst($log->action), 45) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $log->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @empty
            {{-- Fallback: show recent requests if no activity logs yet --}}
            @foreach($recentRequests as $req)
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-[#E8F5E3] flex items-center
                            justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[#2D5A27]" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1
                                 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-800 leading-snug">
                        {{ $req->documentType->name }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $req->resident->full_name }} ·
                        {{ $req->requested_at->diffForHumans() }}
                    </p>
                    @php
                        $pill = match($req->status) {
                            'pending'  => 'bg-yellow-100 text-yellow-700',
                            'approved' => 'bg-blue-100 text-blue-700',
                            'released' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            default    => 'bg-gray-100 text-gray-500',
                        };
                    @endphp
                    <span class="inline-block mt-1 text-[10px] font-semibold
                                 px-2 py-0.5 rounded-full {{ $pill }}">
                        {{ ucfirst($req->status) }}
                    </span>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        {{-- System notice --}}
        <div class="mt-5 pt-4 border-t border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                System Notice
            </p>
            <p class="text-xs text-gray-500">
                Core module sync completed at
                {{ now()->format('h:i A') }}.
            </p>
        </div>
    </div>

</div>

{{-- Quick actions --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <a href="{{ route('admin.residents.create') }}"
       class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center
              gap-4 hover:shadow-md hover:border-[#2D5A27]/20 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-[#E8F5E3] flex items-center
                    justify-center group-hover:bg-[#2D5A27] transition-colors">
            <svg class="w-5 h-5 text-[#2D5A27] group-hover:text-white transition-colors"
                 fill="none" stroke="currentColor" stroke-width="1.8"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0
                         018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-gray-800"
               style="font-family:'Manrope',sans-serif">
                Register Resident
            </p>
            <p class="text-xs text-gray-400 mt-0.5">Add new member data</p>
        </div>
    </a>
    <a href="{{ route('admin.document-requests.index') }}"
       class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center
              gap-4 hover:shadow-md hover:border-[#2D5A27]/20 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-[#E8F5E3] flex items-center
                    justify-center group-hover:bg-[#2D5A27] transition-colors">
            <svg class="w-5 h-5 text-[#2D5A27] group-hover:text-white transition-colors"
                 fill="none" stroke="currentColor" stroke-width="1.8"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2
                         2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2
                         0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-gray-800"
               style="font-family:'Manrope',sans-serif">
                Review Documents
            </p>
            <p class="text-xs text-gray-400 mt-0.5">Approve pending requests</p>
        </div>
    </a>
</div>

{{-- Live clock script --}}
<script>
function updateClock() {
    const now  = new Date()
    const time = now.toLocaleTimeString('en-PH', {
        hour:   '2-digit',
        minute: '2-digit',
        hour12: true,
    })
    const date = now.toLocaleDateString('en-PH', {
        month: 'short',
        day:   'numeric',
    })
    const timeEl = document.getElementById('live-time')
    const dateEl = document.getElementById('live-date')
    if (timeEl) timeEl.textContent = time
    if (dateEl) dateEl.textContent = date
}
updateClock()
setInterval(updateClock, 1000)
</script>

@endsection