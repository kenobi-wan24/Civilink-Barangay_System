@extends('layouts.resident')
@section('title', 'Pending Verification')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-20 text-center">
    <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center
                justify-center mx-auto mb-5">
        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor"
             stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-gray-900 mb-3"
        style="font-family:'Manrope',sans-serif">
        Account Pending Verification
    </h1>
    <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed mb-6">
        Your account has been registered successfully. Barangay staff are currently
        verifying your identity and linking your account to your resident profile.
        This usually takes 1 working day.
    </p>
    <p class="text-gray-400 text-xs mb-8">
        Once verified, you can start requesting official documents through this portal.
    </p>
    <a href="{{ route('contact') }}"
       class="inline-flex items-center gap-2 border border-gray-200 text-gray-600
              text-sm font-semibold px-5 py-2.5 rounded-xl hover:border-[#2D5A27]
              hover:text-[#2D5A27] transition-colors">
        Contact the barangay office
    </a>
</div>
@endsection