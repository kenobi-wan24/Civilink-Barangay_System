@extends('layouts.admin')
@section('title', $resident->full_name)

@section('content')

<nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
    <a href="{{ route('admin.residents.index') }}" class="hover:text-gray-600">
        Residents
    </a>
    <span>›</span>
    <span class="text-gray-600 font-medium">{{ $resident->full_name }}</span>
</nav>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">

    {{-- Left column --}}
    <div class="space-y-5">

        {{-- Profile header card --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-start gap-5">

                {{-- Avatar --}}
                <div class="w-20 h-20 rounded-full overflow-hidden bg-[#E8F5E3]
                            flex items-center justify-center flex-shrink-0">
                    @if($resident->profile_picture)
                        <img src="{{ asset('storage/'.$resident->profile_picture) }}"
                             alt="{{ $resident->full_name }}"
                             class="w-full h-full object-cover"/>
                    @else
                        <span class="text-2xl font-bold text-[#2D5A27]">
                            {{ strtoupper(substr($resident->first_name,0,1).substr($resident->last_name,0,1)) }}
                        </span>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900"
                                style="font-family:'Manrope',sans-serif">
                                {{ $resident->full_name }}
                            </h1>
                            <p class="text-xs font-mono text-gray-400 mt-0.5">
                                {{ $resident->resident_code }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.residents.edit', $resident) }}"
                               class="text-sm font-semibold text-gray-600 border
                                      border-gray-200 px-4 py-2 rounded-xl
                                      hover:border-[#2D5A27] hover:text-[#2D5A27]
                                      transition-colors">
                                Edit
                            </a>
                        </div>
                    </div>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @if($resident->is_voter)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-[#E8F5E3] text-[#2D5A27]">Voter</span>
                        @endif
                        @if($resident->is_senior_citizen)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-purple-100 text-purple-700">Senior Citizen</span>
                        @endif
                        @if($resident->is_pwd)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-orange-100 text-orange-700">PWD</span>
                        @endif
                        @if($resident->is_solo_parent)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                         bg-pink-100 text-pink-700">Solo Parent</span>
                        @endif
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                                     {{ $resident->is_active
                                         ? 'bg-green-100 text-green-700'
                                         : 'bg-gray-100 text-gray-500' }}">
                            {{ $resident->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Personal info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-700 mb-5"
                style="font-family:'Manrope',sans-serif">
                Personal Information
            </h2>
            <dl style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
                <div>
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">
                        Date of Birth
                    </dt>
                    <dd class="text-sm font-semibold text-gray-800">
                        {{ $resident->birthdate->format('F d, Y') }}
                        <span class="text-gray-400 font-normal">
                            ({{ $resident->age }} yrs)
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">Gender</dt>
                    <dd class="text-sm font-semibold text-gray-800 capitalize">
                        {{ $resident->gender }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">Civil Status</dt>
                    <dd class="text-sm font-semibold text-gray-800 capitalize">
                        {{ $resident->civil_status }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">Purok / Zone</dt>
                    <dd class="text-sm font-semibold text-gray-800">
                        {{ $resident->purok_zone }}
                    </dd>
                </div>
                <div class="col-span-2">
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">Address</dt>
                    <dd class="text-sm font-semibold text-gray-800">
                        {{ $resident->address }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">Contact</dt>
                    <dd class="text-sm font-semibold text-gray-800">
                        {{ $resident->contact_number ?? '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 font-semibold uppercase
                               tracking-wider mb-1">Email</dt>
                    <dd class="text-sm font-semibold text-gray-800">
                        {{ $resident->email ?? '—' }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Document history --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center
                        justify-between">
                <h2 class="text-sm font-bold text-gray-700"
                    style="font-family:'Manrope',sans-serif">
                    Document Request History
                </h2>
                <span class="text-xs text-gray-400">
                    {{ $resident->documentRequests->count() }} total
                </span>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-gray-400
                                   uppercase tracking-wider px-6 py-3">Code</th>
                        <th class="text-left text-xs font-semibold text-gray-400
                                   uppercase tracking-wider px-6 py-3">Document</th>
                        <th class="text-left text-xs font-semibold text-gray-400
                                   uppercase tracking-wider px-6 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-400
                                   uppercase tracking-wider px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resident->documentRequests as $req)
                    @php
                        $pill = match($req->status) {
                            'pending'  => 'bg-yellow-100 text-yellow-700',
                            'approved' => 'bg-blue-100 text-blue-700',
                            'released' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            default    => 'bg-gray-100 text-gray-500',
                        };
                    @endphp
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 font-mono text-xs text-gray-400">
                            {{ $req->request_code }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $req->documentType->name }}
                        </td>
                        <td class="px-6 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1
                                         rounded-full {{ $pill }}">
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-xs text-gray-400">
                            {{ $req->requested_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm
                                               text-gray-400">
                            No document requests yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Right sidebar --}}
    <div class="space-y-5">

        {{-- Quick stats --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                Quick Stats
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Total requests</span>
                    <span class="text-sm font-bold text-gray-800">
                        {{ $resident->documentRequests->count() }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Released</span>
                    <span class="text-sm font-bold text-green-600">
                        {{ $resident->documentRequests->where('status','released')->count() }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Pending</span>
                    <span class="text-sm font-bold text-yellow-600">
                        {{ $resident->documentRequests->where('status','pending')->count() }}
                    </span>
                </div>
                <div class="border-t border-gray-100 pt-3 flex items-center
                            justify-between">
                    <span class="text-sm text-gray-500">Member since</span>
                    <span class="text-sm font-bold text-gray-800">
                        {{ $resident->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>

            {{-- Danger zone / Reactivate --}}
        <div class="bg-white rounded-2xl border {{ $resident->is_active ? 'border-red-100' : 'border-green-100' }} p-5">
            @if($resident->is_active)
                <h3 class="text-xs font-bold text-red-400 uppercase tracking-wider mb-3">
                    Danger Zone
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-4">
                    Deactivating this resident will hide them from all public
                    records and disable their portal access.
                </p>
                <form method="POST" action="{{ route('admin.residents.destroy', $resident) }}">
                    @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Deactivate {{ $resident->full_name }}? This can be reversed later.'))"
                                class="w-full text-sm font-semibold text-red-500 border
                                    border-red-200 py-2.5 rounded-xl hover:bg-red-50
                                    transition-colors">
                            Deactivate Resident
                        </button>
                </form>
            @else
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                    Reactivate Resident
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-4">
                    This resident is currently inactive. Reactivating will restore
                    their record and portal access.
                </p>
                <form method="POST" action="{{ route('admin.residents.reactivate', $resident) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            onclick="return confirm('Reactivate {{ $resident->full_name }}?')"
                            class="w-full text-sm font-semibold text-[#2D5A27] border
                                border-[#2D5A27] py-2.5 rounded-xl hover:bg-[#E8F5E3]
                                transition-colors">
                        Reactivate Resident
                    </button>
                </form>
        </div>
        @endif

    </div>
</div>

@endsection