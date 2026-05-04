@extends('layouts.resident')
@section('title', 'Request Document')

@section('content')

{{-- Hero banner --}}
<div class="bg-[#2D5A27] mx-6 mt-6 rounded-2xl px-8 py-10 relative overflow-hidden
            max-w-5xl lg:mx-auto">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg viewBox="0 0 400 200" class="w-full h-full">
            <circle cx="350" cy="-20" r="120" fill="white"/>
            <circle cx="50"  cy="180" r="80"  fill="white"/>
        </svg>
    </div>
    <div class="relative">
        <h1 class="text-white text-2xl font-bold mb-2"
            style="font-family:'Manrope',sans-serif">
            Request Official Documents
        </h1>
        <p class="text-white/60 text-sm leading-relaxed max-w-lg">
            Apply for certificates and clearances from the comfort of your home.
            Standard processing time is 1–2 working days.
        </p>
    </div>
</div>

{{-- Main content --}}
<div class="max-w-5xl mx-auto px-6 py-8">
    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;
                align-items:start">

        {{-- Left: form --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-7 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6"
                style="font-family:'Manrope',sans-serif">
                Service Application
            </h2>

            <form method="POST" action="{{ route('resident.request.submit') }}">
                @csrf

                {{-- Document type --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Document Type
                    </label>
                    <div class="relative">
                        <select name="document_type_id"
                                class="w-full bg-gray-50 border rounded-xl px-4 py-3
                                       text-sm text-gray-700 appearance-none
                                       focus:outline-none focus:border-[#2D5A27]
                                       focus:bg-white transition-all
                                       {{ $errors->has('document_type_id')
                                           ? 'border-red-400' : 'border-gray-200' }}">
                            <option value="">Select a document...</option>
                            @foreach($documentTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('document_type_id') == $type->id
                                        ? 'selected' : '' }}>
                                    {{ $type->name }}
                                    @if(in_array($type->id, $pendingTypes))
                                        (pending request exists)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-4 flex items-center
                                     pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    @error('document_type_id')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    {{-- Soft warning for duplicate pending --}}
                    @if(count($pendingTypes) > 0)
                    <div class="mt-2 flex items-start gap-2 bg-yellow-50 border
                                border-yellow-200 rounded-xl px-3 py-2.5">
                        <svg class="w-4 h-4 text-yellow-500 flex-shrink-0 mt-0.5"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58
                                     9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53
                                     0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0
                                     11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0
                                     002 0V6a1 1 0 00-1-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs text-yellow-700">
                            You have a pending request for one or more document types.
                            You can still submit a new request if needed.
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Purpose --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Purpose of Request
                    </label>
                    <textarea name="purpose" rows="4"
                              placeholder="Explain why you are requesting this document
(e.g., Employment, School Requirement, Loan Application)"
                              class="w-full bg-gray-50 border rounded-xl px-4 py-3
                                     text-sm text-gray-700 placeholder-gray-400
                                     resize-none focus:outline-none
                                     focus:border-[#2D5A27] focus:bg-white
                                     transition-all
                                     {{ $errors->has('purpose')
                                         ? 'border-red-400' : 'border-gray-200' }}"
                    >{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-[#2D5A27] hover:bg-[#3d7a35] text-white
                               font-semibold text-sm py-3.5 rounded-xl transition-all
                               flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Submit Request
                </button>
            </form>
        </div>

        {{-- Right: sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1rem">

            {{-- Requirements --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-[#2D5A27]" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0
                                 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0
                                 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                              clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-sm font-bold text-gray-800"
                        style="font-family:'Manrope',sans-serif">
                        Requirements
                    </h3>
                </div>
                <ul class="space-y-2.5">
                    @foreach([
                        'Valid Government Issued ID',
                        'Proof of Residence (e.g. Utility Bill)',
                        'Cedula (Community Tax Certificate)',
                    ] as $req)
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[#2D5A27] flex-shrink-0 mt-0.5"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707
                                     -9.293a1 1 0 00-1.414-1.414L9 10.586
                                     7.707 9.293a1 1 0 00-1.414 1.414l2 2a1
                                     1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs text-gray-600">{{ $req }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Processing fee --}}
            <div class="bg-[#E8F5E3] border border-[#b8ddb4] rounded-2xl p-5">
                <h3 class="text-sm font-bold text-[#2D5A27] mb-2"
                    style="font-family:'Manrope',sans-serif">
                    Processing Fee
                </h3>
                <p class="text-xs text-[#2D5A27]/70 leading-relaxed mb-3">
                    Fees vary depending on the document type. Pay upon pickup
                    at the Barangay Hall.
                </p>
                <p class="text-xs text-[#2D5A27]/60 font-semibold uppercase
                           tracking-wider">
                    Starting at
                </p>
                <p class="text-2xl font-bold text-[#2D5A27]"
                   style="font-family:'Manrope',sans-serif">
                    ₱50.00
                </p>
            </div>

            {{-- Need help --}}
            <div class="bg-[#2D5A27] rounded-2xl p-5">
                <p class="text-white/60 text-xs mb-1">Need help?</p>
                <p class="text-white font-bold text-sm mb-3"
                   style="font-family:'Manrope',sans-serif">
                    Chat with our Staff
                </p>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold
                          text-white border border-white/30 px-4 py-2 rounded-full
                          hover:bg-white/10 transition-colors">
                    Contact Us
                </a>
            </div>

        </div>
    </div>
</div>

@endsection