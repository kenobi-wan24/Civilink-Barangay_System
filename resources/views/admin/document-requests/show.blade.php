@extends('layouts.admin')
@section('title', 'Document Review')

@section('content')

@php
    $req = $documentRequest;
    $statusConfig = match($req->status) {
        'pending'  => ['bg-yellow-100 text-yellow-700 border-yellow-200', 'Pending Approval'],
        'approved' => ['bg-blue-100 text-blue-700 border-blue-200',       'Approved'],
        'released' => ['bg-green-100 text-green-700 border-green-200',    'Released'],
        'rejected' => ['bg-red-100 text-red-500 border-red-200',          'Rejected'],
        default    => ['bg-gray-100 text-gray-500 border-gray-200',       ucfirst($req->status)],
    };
@endphp

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-5">
    <a href="{{ route('admin.document-requests.index') }}" class="hover:text-gray-600">
        Document Requests
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">{{ $req->request_code }}</span>
</nav>

{{-- Outer wrapper — fixes grid collapsing --}}
<div style="display:grid;grid-template-columns:minmax(0,1fr) 300px;gap:1.5rem;align-items:start;width:100%">

    {{-- ── Left: iframe preview ── --}}
    <div style="min-width:0;overflow:hidden">

        {{-- Green top accent --}}
        <div style="height:8px;background:#2D5A27;border-radius:12px 12px 0 0"></div>

        {{-- iframe container --}}
        <div style="background:white;border:1px solid #f3f4f6;border-top:none;
                    border-radius:0 0 12px 12px;overflow:hidden">
            <iframe
                src="{{ route('admin.document-requests.inline', $documentRequest) }}"
                style="width:100%;height:950px;border:none;display:block"
                title="Document Preview"
                scrolling="yes">
            </iframe>
        </div>

        {{-- Download PDF --}}
        @if(in_array($req->status, ['approved', 'released']))
        <div style="display:flex;justify-content:flex-end;margin-top:1rem">
            <a href="{{ route('admin.document-requests.preview', $req) }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
                      text-white text-sm font-semibold px-6 py-3 rounded-xl
                      transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2
                             0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0
                             01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
        </div>
        @endif
    </div>

    {{-- ── Right: sidebar — stays fixed to the right ── --}}
    <div style="display:flex;flex-direction:column;gap:1rem;min-width:0">

        {{-- Current status --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                Current Status
            </p>
            <div class="border rounded-xl px-4 py-3 text-sm font-bold text-center
                        {{ $statusConfig[0] }}">
                {{ $statusConfig[1] }}
            </div>
            <p class="text-xs text-gray-400 mt-3 leading-relaxed">
                Submitted {{ $req->requested_at->diffForHumans() }}.
            </p>
        </div>

        {{-- Admin actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                Administrator Actions
            </p>
            <div style="display:flex;flex-direction:column;gap:10px">

                {{-- APPROVE --}}
                @if($req->status === 'pending')
                <form method="POST"
                      action="{{ route('admin.document-requests.approve', $req) }}">
                    @csrf @method('PATCH')
                    <textarea name="admin_notes"
                              placeholder="Optional notes..."
                              rows="2"
                              class="w-full bg-gray-50 border border-gray-200
                                     rounded-xl px-3 py-2 text-xs text-gray-600
                                     placeholder-gray-400 focus:outline-none
                                     focus:border-[#2D5A27] resize-none mb-2
                                     transition-all"></textarea>
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2
                                   bg-[#2D5A27] hover:bg-[#3d7a35] text-white
                                   text-sm font-semibold py-3 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Approve
                    </button>
                </form>
                @endif

                {{-- RELEASE --}}
                @if($req->status === 'approved')
                <form method="POST"
                      action="{{ route('admin.document-requests.release', $req) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            onclick="return confirm('Mark as released?')"
                            class="w-full flex items-center justify-center gap-2
                                   bg-[#2D5A27] hover:bg-[#3d7a35] text-white
                                   text-sm font-semibold py-3 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        Mark as Released
                    </button>
                </form>
                @endif

                {{-- REJECT --}}
                @if(in_array($req->status, ['pending', 'approved']))
                <form method="POST"
                      action="{{ route('admin.document-requests.reject', $req) }}"
                      id="reject-form">
                    @csrf @method('PATCH')

                    <textarea name="admin_notes"
                              id="reject-reason"
                              placeholder="Reason for rejection (required)..."
                              rows="3"
                              class="w-full bg-gray-50 border border-gray-200
                                     rounded-xl px-3 py-2 text-xs text-gray-600
                                     placeholder-gray-400 focus:outline-none
                                     focus:border-red-400 resize-none mb-2
                                     transition-all"
                              style="display:none"></textarea>

                    @error('admin_notes')
                        <p class="text-xs text-red-500 mb-2">{{ $message }}</p>
                    @enderror

                    <button type="button"
                            id="reject-toggle"
                            onclick="toggleReject()"
                            class="w-full flex items-center justify-center gap-2
                                   border border-red-200 text-red-500 hover:bg-red-50
                                   text-sm font-semibold py-3 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9
                                     9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Reject Request
                    </button>

                    <button type="submit"
                            id="reject-submit"
                            style="display:none"
                            class="w-full bg-red-500 hover:bg-red-600 text-white
                                   text-sm font-semibold py-3 rounded-xl
                                   transition-colors mt-2">
                        Confirm Rejection
                    </button>
                </form>
                @endif

                {{-- Released — no more actions --}}
                @if($req->status === 'released')
                <div class="text-center py-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center
                                justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-green-600" fill="none"
                             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400">
                        Released on {{ $req->released_at?->format('M d, Y') }}
                    </p>
                </div>
                @endif

                {{-- Rejected --}}
                @if($req->status === 'rejected')
                <div class="bg-red-50 border border-red-100 rounded-xl p-3">
                    <p class="text-xs font-semibold text-red-600 mb-1">
                        Rejection Reason
                    </p>
                    <p class="text-xs text-red-500">
                        {{ $req->admin_notes ?? 'No reason provided.' }}
                    </p>
                </div>
                @endif

            </div>
        </div>

        {{-- Request history --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                Request History
            </p>
            <div style="display:flex;flex-direction:column;gap:12px">

                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:8px;height:8px;border-radius:50%;background:#2D5A27;
                                margin-top:4px;flex-shrink:0"></div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Request Created</p>
                        <p class="text-xs text-gray-400">
                            {{ $req->requested_at->format('M d, Y · h:i A') }}
                        </p>
                    </div>
                </div>

                @if($req->approved_at)
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:8px;height:8px;border-radius:50%;background:#3b82f6;
                                margin-top:4px;flex-shrink:0"></div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">
                            Approved by {{ $req->approvedBy?->name ?? 'Admin' }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $req->approved_at->format('M d, Y · h:i A') }}
                        </p>
                    </div>
                </div>
                @endif

                @if($req->released_at)
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:8px;height:8px;border-radius:50%;background:#22c55e;
                                margin-top:4px;flex-shrink:0"></div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">
                            Released by {{ $req->releasedBy?->name ?? 'Admin' }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $req->released_at->format('M d, Y · h:i A') }}
                        </p>
                    </div>
                </div>
                @endif

                @if($req->status === 'rejected')
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:8px;height:8px;border-radius:50%;background:#ef4444;
                                margin-top:4px;flex-shrink:0"></div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Rejected</p>
                        <p class="text-xs text-gray-400">{{ $req->admin_notes }}</p>
                    </div>
                </div>
                @endif

                @if($req->status === 'pending')
                <div style="display:flex;align-items:flex-start;gap:10px;opacity:0.4">
                    <div style="width:8px;height:8px;border-radius:50%;border:2px solid #9ca3af;
                                margin-top:4px;flex-shrink:0"></div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Awaiting Review</p>
                        <p class="text-xs text-gray-400">Current step</p>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Resident quick info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                Resident
            </p>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                <div class="w-10 h-10 rounded-full bg-[#E8F5E3] flex items-center
                            justify-center text-[#2D5A27] text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($req->resident->first_name,0,1).substr($req->resident->last_name,0,1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $req->resident->full_name }}
                    </p>
                    <p class="text-xs text-gray-400 font-mono">
                        {{ $req->resident->resident_code }}
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.residents.show', $req->resident) }}"
               class="text-xs font-semibold text-[#2D5A27] hover:underline">
                View full profile →
            </a>
        </div>

    </div>
</div>

<script>
function toggleReject() {
    const reason = document.getElementById('reject-reason')
    const submit = document.getElementById('reject-submit')
    const showing = reason.style.display !== 'none'

    reason.style.display = showing ? 'none' : 'block'
    submit.style.display = showing ? 'none' : 'block'

    if (!showing) reason.focus()
}

@if($errors->has('admin_notes'))
    toggleReject()
@endif
</script>

@endsection