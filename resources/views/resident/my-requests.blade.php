@extends('layouts.resident')
@section('title', 'My Requests')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900"
                style="font-family:'Manrope',sans-serif">
                My Requests
            </h1>
            <p class="text-sm text-gray-400 mt-0.5">
                Track the status of your document requests.
            </p>
        </div>
        <a href="{{ route('resident.request.form') }}"
           class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
                  text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                  transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>
            </svg>
            New Request
        </a>
    </div>

    @if($requests->isEmpty())

    {{-- Empty state --}}
    <div class="bg-white rounded-2xl border border-gray-100 py-20 text-center">
        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center
                    justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1
                         1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0
                         01-2 2z"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-gray-700 mb-2"
            style="font-family:'Manrope',sans-serif">
            No requests yet
        </h3>
        <p class="text-sm text-gray-400 mb-6">
            You haven't requested any documents yet.
        </p>
        <a href="{{ route('resident.request.form') }}"
           class="inline-flex items-center gap-2 bg-[#2D5A27] hover:bg-[#3d7a35]
                  text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                  transition-colors">
            Request your first document
        </a>
    </div>

    @else

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-4">
                        Request Code
                    </th>
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-4">
                        Document
                    </th>
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-4">
                        Purpose
                    </th>
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-4">
                        Date
                    </th>
                    <th class="text-left text-xs font-semibold text-gray-400
                               uppercase tracking-wider px-6 py-4">
                        Status
                    </th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                @php
                    $statusConfig = match($req->status) {
                        'pending'  => ['bg-yellow-100 text-yellow-700', 'Pending'],
                        'approved' => ['bg-blue-100 text-blue-700',    'Approved'],
                        'released' => ['bg-green-100 text-green-700',  'Released'],
                        'rejected' => ['bg-red-100 text-red-500',      'Rejected'],
                        default    => ['bg-gray-100 text-gray-500',    ucfirst($req->status)],
                    };
                @endphp
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">

                    {{-- Code --}}
                    <td class="px-6 py-4 font-mono text-xs text-gray-500">
                        {{ $req->request_code }}
                    </td>

                    {{-- Document --}}
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                        {{ $req->documentType->name }}
                    </td>

                    {{-- Purpose --}}
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-[180px]">
                        <span class="line-clamp-1">{{ $req->purpose }}</span>
                    </td>

                    {{-- Date --}}
                    <td class="px-6 py-4 text-xs text-gray-400">
                        {{ $req->requested_at->format('M d, Y') }}
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full
                                     {{ $statusConfig[0] }}">
                            {{ $statusConfig[1] }}
                        </span>
                    </td>

                    {{-- Action --}}
                    <td class="px-6 py-4">
                        @if($req->status === 'released')
                            <a href="{{ route('resident.request.download', $req) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs
                                      font-semibold text-[#2D5A27] border
                                      border-[#2D5A27] px-3 py-1.5 rounded-lg
                                      hover:bg-[#E8F5E3] transition-colors
                                      whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2
                                             2 0 01-2-2V5a2 2 0 012-2h5.586a1
                                             1 0 01.707.293l5.414 5.414a1 1 0
                                             01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                View Document
                            </a>
                        @elseif($req->status === 'rejected')
                            <div class="text-xs text-red-400 max-w-[160px]">
                                <p class="font-semibold mb-0.5">Rejected</p>
                                @if($req->admin_notes)
                                    <p class="text-red-400/70 leading-snug">
                                        {{ Str::limit($req->admin_notes, 50) }}
                                    </p>
                                @endif
                            </div>
                        @elseif($req->status === 'approved')
                            <span class="text-xs text-blue-500 font-medium">
                                Ready for pickup
                            </span>
                        @else
                            <span class="text-xs text-gray-400">
                                Under review
                            </span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</div>

@endsection