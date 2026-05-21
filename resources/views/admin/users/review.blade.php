@extends('layouts.admin')
@section('title', 'Review Registration — ' . ($user->first_name . ' ' . $user->last_name))

@section('content')

{{-- Header --}}
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.users.index') }}"
       class="w-8 h-8 rounded-xl border border-gray-200 flex items-center justify-center
              text-gray-400 hover:text-gray-600 hover:border-gray-300 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-900" style="font-family:'Manrope',sans-serif">
            Review Registration
        </h1>
        <p class="text-sm text-gray-500 mt-0.5">
            Submitted {{ $user->created_at->format('F j, Y \a\t g:i A') }}
            &middot; {{ $user->created_at->diffForHumans() }}
        </p>
    </div>
</div>

{{-- Validation errors --}}
@if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-6">
        <p class="text-xs font-semibold text-red-600 mb-1">Please fix the following:</p>
        <ul class="text-xs text-red-500 list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-3 gap-6">

    {{-- ── Left col: editable form (2/3 width) ───────────────────────────── --}}
    <div class="col-span-2 space-y-5">

        {{-- Approve form wraps the editable fields + approve button --}}
        <form method="POST" action="{{ route('admin.users.approve', $user) }}" id="approve-form">
        @csrf

        {{-- Personal Information --}}
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-[#2D5A27]"></div>
                <h2 class="text-sm font-bold text-gray-700" style="font-family:'Manrope',sans-serif">
                    Personal Information
                </h2>
                <span class="text-xs text-gray-400 ml-1">— edit to correct typos before approving</span>
            </div>
            <div class="px-6 py-5 space-y-4">

                {{-- First / Middle / Last / Suffix --}}
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            First Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="first_name"
                               value="{{ old('first_name', $user->first_name) }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                      text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                      focus:bg-white transition-all @error('first_name') border-red-400 bg-red-50 @enderror"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Middle Name
                        </label>
                        <input type="text" name="middle_name"
                               value="{{ old('middle_name', $user->middle_name) }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                      text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                      focus:bg-white transition-all"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Last Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="last_name"
                               value="{{ old('last_name', $user->last_name) }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                      text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                      focus:bg-white transition-all @error('last_name') border-red-400 bg-red-50 @enderror"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Suffix
                        </label>
                        <select name="suffix"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                       text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                       focus:bg-white transition-all appearance-none">
                            <option value="">None</option>
                            @foreach(['Jr.', 'Sr.', 'II', 'III', 'IV'] as $s)
                                <option value="{{ $s }}" @selected(old('suffix', $user->suffix) === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Birthdate / Gender / Civil Status / Contact --}}
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Date of Birth <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="birthdate"
                               value="{{ old('birthdate', $user->birthdate?->format('Y-m-d')) }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                      text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                      focus:bg-white transition-all @error('birthdate') border-red-400 bg-red-50 @enderror"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Gender <span class="text-red-400">*</span>
                        </label>
                        <select name="reg_gender"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                       text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                       focus:bg-white transition-all appearance-none
                                       @error('reg_gender') border-red-400 bg-red-50 @enderror">
                            <option value="" disabled>Select</option>
                            @foreach(['Male', 'Female'] as $g)
                                <option value="{{ $g }}" @selected(old('reg_gender', $user->reg_gender) === $g)>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Civil Status <span class="text-red-400">*</span>
                        </label>
                        <select name="reg_civil_status"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                       text-sm text-gray-800 focus:outline-none focus:border-[#2D5A27]
                                       focus:bg-white transition-all appearance-none
                                       @error('reg_civil_status') border-red-400 bg-red-50 @enderror">
                            <option value="" disabled>Select</option>
                            @foreach(['Single', 'Married', 'Widowed', 'Separated', 'Annulled'] as $cs)
                                <option value="{{ $cs }}" @selected(old('reg_civil_status', $user->reg_civil_status) === $cs)>{{ $cs }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Contact Number
                        </label>
                        <input type="text" name="reg_contact"
                               value="{{ old('reg_contact', $user->reg_contact) }}"
                               placeholder="+63 9XX XXX XXXX"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                      text-sm text-gray-800 placeholder-gray-400 focus:outline-none
                                      focus:border-[#2D5A27] focus:bg-white transition-all"/>
                    </div>
                </div>

            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-[#2D5A27]"></div>
                <h2 class="text-sm font-bold text-gray-700" style="font-family:'Manrope',sans-serif">
                    Address
                </h2>
            </div>
            <div class="px-6 py-5 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Purok / Zone <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="reg_purok_zone"
                           value="{{ old('reg_purok_zone', $user->reg_purok_zone) }}"
                           placeholder="e.g. Purok 3 – Mabini"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                  text-sm text-gray-800 placeholder-gray-400 focus:outline-none
                                  focus:border-[#2D5A27] focus:bg-white transition-all
                                  @error('reg_purok_zone') border-red-400 bg-red-50 @enderror"/>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Full Address <span class="text-red-400">*</span>
                    </label>
                    <textarea name="reg_address" rows="2"
                              placeholder="House No., Street, Barangay"
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5
                                     text-sm text-gray-800 placeholder-gray-400 focus:outline-none
                                     focus:border-[#2D5A27] focus:bg-white transition-all resize-none
                                     @error('reg_address') border-red-400 bg-red-50 @enderror">{{ old('reg_address', $user->reg_address) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Account info (read-only) --}}
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                <h2 class="text-sm font-bold text-gray-700" style="font-family:'Manrope',sans-serif">
                    Account
                </h2>
                <span class="text-xs text-gray-400 ml-1">— read only</span>
            </div>
            <div class="px-6 py-5 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Email Address</p>
                    <p class="font-medium text-gray-800">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Registered</p>
                    <p class="font-medium text-gray-800">{{ $user->created_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>

        </form>{{-- end approve form --}}

    </div>

    {{-- ── Right col: ID preview + actions (1/3 width) ────────────────────── --}}
    <div class="space-y-5">

        {{-- Valid ID preview --}}
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                <h2 class="text-sm font-bold text-gray-700" style="font-family:'Manrope',sans-serif">
                    Valid ID
                </h2>
            </div>
            <div class="px-5 py-4">
                @if($user->valid_id_path)
                    @php
                        $ext = strtolower(pathinfo($user->valid_id_path, PATHINFO_EXTENSION));
                        $url = Storage::url($user->valid_id_path);
                    @endphp

                    @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                        <a href="{{ $url }}" target="_blank" class="block group">
                            <img src="{{ $url }}" alt="Valid ID"
                                 class="w-full rounded-xl border border-gray-100 object-cover
                                        group-hover:opacity-90 transition-opacity"/>
                            <p class="text-xs text-center text-gray-400 mt-2">
                                Click to open full size
                            </p>
                        </a>
                    @elseif($ext === 'pdf')
                        <div class="flex flex-col items-center gap-3 py-4">
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor"
                                     stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-500 text-center">PDF document uploaded</p>
                            <a href="{{ $url }}" target="_blank"
                               class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200
                                      text-gray-700 text-xs font-semibold px-4 py-2 rounded-xl
                                      transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                                Open PDF
                            </a>
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center gap-2 py-6 text-center">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor"
                                 stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 19.5h18"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-400">No ID uploaded</p>
                        <p class="text-xs text-gray-300">Ask resident to bring ID in person</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Decision card --}}
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                <h2 class="text-sm font-bold text-gray-700" style="font-family:'Manrope',sans-serif">
                    Decision
                </h2>
            </div>
            <div class="px-5 py-4 space-y-3">

                {{-- Approve --}}
                <button type="submit" form="approve-form"
                        onclick="return confirm('Approve this registration and create their resident profile?')"
                        class="w-full flex items-center justify-center gap-2 bg-[#2D5A27]
                               hover:bg-[#3d7a35] text-white text-sm font-semibold
                               py-3 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Approve Registration
                </button>

                {{-- Reject — opens inline form --}}
                <button type="button" id="reject-toggle"
                        class="w-full flex items-center justify-center gap-2 bg-red-50
                               hover:bg-red-100 text-red-600 text-sm font-semibold
                               py-3 rounded-xl transition-colors border border-red-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reject Registration
                </button>

                {{-- Reject reason form (hidden until button clicked) --}}
                <div id="reject-form-wrapper" class="hidden">
                    <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-gray-500
                                         uppercase tracking-wider mb-1.5">
                                Reason for rejection <span class="text-red-400">*</span>
                            </label>
                            <textarea name="rejection_reason" rows="3"
                                      placeholder="e.g. Submitted ID does not match the provided name. Please visit the barangay hall."
                                      class="w-full bg-gray-50 border border-gray-200 rounded-xl
                                             px-3 py-2.5 text-sm text-gray-800 placeholder-gray-400
                                             focus:outline-none focus:border-red-400 focus:bg-white
                                             transition-all resize-none
                                             @error('rejection_reason') border-red-400 bg-red-50 @enderror">{{ old('rejection_reason') }}</textarea>
                            @error('rejection_reason')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                onclick="return confirm('Reject this registration? The resident will see your reason on their next login.')"
                                class="w-full bg-red-500 hover:bg-red-600 text-white
                                       text-sm font-semibold py-2.5 rounded-xl transition-colors">
                            Confirm Rejection
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Quick note for admin --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl px-5 py-4">
            <p class="text-xs font-semibold text-yellow-800 mb-1.5">Before approving:</p>
            <ul class="text-xs text-yellow-700 space-y-1">
                <li>✓ Confirm resident is known to the barangay</li>
                <li>✓ Cross-check ID with submitted name</li>
                <li>✓ Fix any obvious typos in the form before clicking approve</li>
            </ul>
        </div>

    </div>

</div>

@push('scripts')
<script>
    document.getElementById('reject-toggle').addEventListener('click', function () {
        const wrapper = document.getElementById('reject-form-wrapper');
        const isHidden = wrapper.classList.contains('hidden');
        wrapper.classList.toggle('hidden', !isHidden);
        this.textContent = isHidden ? '✕ Cancel' : 'Reject Registration';
    });
</script>
@endpush

@php use Illuminate\Support\Facades\Storage; @endphp

@endsection