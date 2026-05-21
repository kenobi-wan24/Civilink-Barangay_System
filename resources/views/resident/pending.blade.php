@extends('layouts.resident')
@section('title', 'Account Pending Verification')

@section('content')
@php $user = auth()->user(); @endphp

<div class="max-w-2xl mx-auto px-6 py-12">

    {{-- Status badge --}}
    @if ($user->account_status === 'rejected')
        <div class="flex items-start gap-4 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-8">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-red-700 mb-1">Registration Not Approved</p>
                <p class="text-sm text-red-600 leading-relaxed">
                    {{ $user->rejection_reason ?? 'No reason was provided.' }}
                </p>
                <p class="text-xs text-red-400 mt-2">
                    Please visit the barangay hall in person to appeal or re-register.
                </p>
            </div>
        </div>
    @else
        <div class="flex items-start gap-4 bg-yellow-50 border border-yellow-200 rounded-2xl px-5 py-4 mb-8">
            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-yellow-800 mb-1">Pending Verification</p>
                <p class="text-sm text-yellow-700 leading-relaxed">
                    Your registration is under review. Barangay staff will verify your
                    details — this usually takes <strong>1 working day</strong>.
                </p>
                <p class="text-xs text-yellow-600 mt-2">
                    Please bring your valid ID and supporting documents to the barangay hall.
                </p>
            </div>
        </div>
    @endif

    {{-- Submitted info card --}}
    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm mb-6">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-800" style="font-family:'Manrope',sans-serif">
                Your Submitted Information
            </h2>
            <span class="text-xs text-gray-400">Review only — contact the barangay to correct errors</span>
        </div>

        <div class="px-6 py-5 space-y-5">

            {{-- Personal info --}}
            <div>
                <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-3">Personal Information</p>
                <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Full Name</p>
                        <p class="font-medium text-gray-800">
                            {{ trim(($user->first_name ?? '') . ' ' . ($user->middle_name ? $user->middle_name . ' ' : '') . ($user->last_name ?? '') . ($user->suffix ? ', ' . $user->suffix : '')) ?: '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Email Address</p>
                        <p class="font-medium text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Date of Birth</p>
                        <p class="font-medium text-gray-800">
                            {{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('F j, Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Gender</p>
                        <p class="font-medium text-gray-800">{{ $user->reg_gender ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Civil Status</p>
                        <p class="font-medium text-gray-800">{{ $user->reg_civil_status ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Contact Number</p>
                        <p class="font-medium text-gray-800">{{ $user->reg_contact ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Address --}}
            <div>
                <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-3">Address</p>
                <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Purok / Zone</p>
                        <p class="font-medium text-gray-800">{{ $user->reg_purok_zone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Full Address</p>
                        <p class="font-medium text-gray-800">{{ $user->reg_address ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Valid ID status --}}
            <div>
                <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-3">Supporting Document</p>
                @if ($user->valid_id_path)
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-6 h-6 rounded-full bg-[#E8F5E3] flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-[#2D5A27]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Valid ID uploaded</span>
                    </div>
                @else
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                            </svg>
                        </div>
                        <span class="text-gray-400">No ID uploaded — bring it to the barangay hall</span>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 border border-gray-200 text-gray-600
                  text-sm font-semibold px-5 py-2.5 rounded-xl hover:border-[#2D5A27]
                  hover:text-[#2D5A27] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
            </svg>
            Contact the barangay office
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-xs text-gray-400 hover:text-gray-600 transition-colors underline underline-offset-2">
                Sign out
            </button>
        </form>
    </div>

</div>
@endsection