@extends('layouts.public')
@section('title', 'Contact')

@section('content')

<main class="bg-[#F9FAF8] min-h-screen pb-20">
  <div class="max-w-7xl mx-auto px-6 pt-14">

    {{-- Page header --}}
    <header class="mb-10">
      <h1 class="text-5xl text-gray-900 mb-4"
          style="font-family:'Manrope',sans-serif;font-weight:800">
        Get in Touch
      </h1>
      <p class="text-gray-500 text-sm max-w-md leading-relaxed">
        Our community thrives on open communication. Whether you have an inquiry,
        feedback, or need assistance, the Barangay CiviLink team is here to help.
      </p>
    </header>

    {{-- Success flash --}}
    @if(session('success'))
      <div class="mb-8 flex items-start gap-4 bg-[#E8F5E3] border border-[#b8ddb4]
                  rounded-2xl px-5 py-4">
        <svg class="w-5 h-5 text-[#2D5A27] flex-shrink-0 mt-0.5"
             fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                   00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414
                   1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd"/>
        </svg>
        <p class="text-sm text-[#2D5A27] font-medium">{{ session('success') }}</p>
      </div>
    @endif

    {{-- Main two-column grid --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;align-items:start">

      {{-- ── Left: form card ── --}}
      <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-xl font-bold text-gray-900 mb-6"
            style="font-family:'Manrope',sans-serif">
          Send us a Message
        </h2>

        <form method="POST" action="{{ route('contact.store') }}" id="contact-form-el">
          @csrf

          {{-- Name + Email --}}
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
            <div>
              <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                Full Name
              </label>
              <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Juan Dela Cruz"
                class="w-full bg-gray-100 border rounded-xl px-4 py-3 text-sm
                       text-gray-700 placeholder-gray-400 focus:outline-none
                       focus:border-[#2D5A27] focus:bg-white transition-all
                       {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-transparent' }}"
              />
              @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                Email Address
              </label>
              <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="juan@example.com"
                class="w-full bg-gray-100 border rounded-xl px-4 py-3 text-sm
                       text-gray-700 placeholder-gray-400 focus:outline-none
                       focus:border-[#2D5A27] focus:bg-white transition-all
                       {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-transparent' }}"
              />
              @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- Purpose --}}
          <div class="mb-4">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
              Purpose of Inquiry
            </label>
            <div class="relative">
              <select
                name="purpose"
                class="w-full bg-gray-100 border border-transparent rounded-xl
                       px-4 py-3 text-sm text-gray-700 appearance-none
                       focus:outline-none focus:border-[#2D5A27] focus:bg-white
                       transition-all"
              >
                <option value="">General Inquiry</option>
                <option value="Document Request"
                  {{ old('purpose') === 'Document Request' ? 'selected' : '' }}>
                  Document Request
                </option>
                <option value="Complaint"
                  {{ old('purpose') === 'Complaint' ? 'selected' : '' }}>
                  Complaint or Concern
                </option>
                <option value="Suggestion"
                  {{ old('purpose') === 'Suggestion' ? 'selected' : '' }}>
                  Suggestion
                </option>
                <option value="Emergency"
                  {{ old('purpose') === 'Emergency' ? 'selected' : '' }}>
                  Emergency Report
                </option>
                <option value="Other"
                  {{ old('purpose') === 'Other' ? 'selected' : '' }}>
                  Other
                </option>
              </select>
              <span class="absolute inset-y-0 right-4 flex items-center
                           pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none"
                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 9l-7 7-7-7"/>
                </svg>
              </span>
            </div>
          </div>

          {{-- Message --}}
          <div class="mb-6">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
              Message
            </label>
            <textarea
              name="message"
              rows="6"
              placeholder="How can we assist you today?"
              class="w-full bg-gray-100 border rounded-xl px-4 py-3 text-sm
                     text-gray-700 placeholder-gray-400 focus:outline-none
                     focus:border-[#2D5A27] focus:bg-white transition-all resize-none
                     {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-transparent' }}"
            >{{ old('message') }}</textarea>
            @error('message')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Submit --}}
          <button
            type="submit"
            class="bg-[#2D5A27] hover:bg-[#3d7a35] text-white font-semibold
                   text-sm px-8 py-3.5 rounded-xl transition-all">
            Send Message
          </button>

        </form>
      </div>

      {{-- ── Right: sidebar cards ── --}}
      <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- Office Hours --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <div class="flex items-center gap-2 mb-5">
            <svg class="w-5 h-5 text-[#2D5A27]" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
            </svg>
            <h3 class="font-bold text-gray-900 text-sm"
                style="font-family:'Manrope',sans-serif">
              Office Hours
            </h3>
          </div>
          <div class="space-y-5 text-sm">
            <div class="flex items-center justify-between">
              <span class="text-gray-500">Monday – Friday</span>
              <span class="font-semibold text-gray-800">8:00 AM – 5:00 PM</span>
            </div>
            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
              <span class="text-gray-500">Saturday</span>
              <span class="font-semibold text-gray-800">9:00 AM – 12:00 PM</span>
            </div>
            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
              <span class="text-gray-500">Sunday</span>
              <span class="font-semibold text-red-500">Closed</span>
            </div>
          </div>
        </div>

        {{-- Contact Details --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <div class="flex items-center gap-2 mb-5">
            <svg class="w-5 h-5 text-[#2D5A27]" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                       0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <circle cx="12" cy="11" r="3"/>
            </svg>
            <h3 class="font-bold text-gray-900 text-sm"
                style="font-family:'Manrope',sans-serif">
              Contact Details
            </h3>
          </div>
          <div class="space-y-5">

            {{-- Phone --}}
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-[#E8F5E3] flex items-center
                          justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-[#2D5A27]" fill="none"
                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1
                           1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516
                           5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0
                           01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3
                           6V5z"/>
                </svg>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                  Phone
                </p>
                <p class="text-sm font-semibold text-gray-800">+63 (02) 8123 4567</p>
              </div>
            </div>

            {{-- Email --}}
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-[#E8F5E3] flex items-center
                          justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-[#2D5A27]" fill="none"
                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0
                           002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                  Email
                </p>
                <p class="text-sm font-semibold text-gray-800">
                  hello@civilink.gov.ph
                </p>
              </div>
            </div>

            {{-- Social Media --}}
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-[#E8F5E3] flex items-center
                          justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-[#2D5A27]" fill="none"
                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114
                           -.938-.316-1.342m0 2.684a3 3 0 110-2.684m0
                           2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0
                           105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0
                           105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
              </div>
              <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                  Social Media
                </p>
                <div class="flex items-center gap-2 mt-0.5">
                  <a href="#"
                     class="text-sm font-semibold text-[#2D5A27] hover:underline">
                    Facebook
                  </a>
                  <span class="text-gray-300 text-xs">·</span>
                  <a href="#"
                     class="text-sm font-semibold text-[#2D5A27] hover:underline">
                    Twitter
                  </a>
                  <span class="text-gray-300 text-xs">·</span>
                  <a href="#"
                     class="text-sm font-semibold text-[#2D5A27] hover:underline">
                    Instagram
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- Visit the Hall --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <h3 class="font-bold text-gray-900 text-sm mb-1"
              style="font-family:'Manrope',sans-serif">
            Visit the Hall
          </h3>
          <p class="text-xs text-gray-400 flex items-center gap-1 mb-4">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none"
                 stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                       0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <circle cx="12" cy="11" r="3"/>
            </svg>
            123 CiviLink Drive, Barangay CiviLink, Philippines
          </p>
          {{-- Map image / embed --}}
          <div class="w-full h-48 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
            {{-- Replace src with a real Google Maps embed or screenshot --}}
            <img
              src="{{ asset('images/map-placeholder.jpg') }}"
              alt="Barangay Hall location"
              class="w-full h-full object-cover"
              
              onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg class=\'w-10 h-10 text-gray-300\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7\'/></svg></div>'"
            />
          </div>
        </div>

      </div>
    </div>

    {{-- ── Emergency CTA ── --}}
    <section class="bg-[#2D5A27] rounded-3xl relative overflow-hidden" style="padding: 4rem 3.5rem; margin-top: 4rem;">
      {{-- Decorative background shape --}}
      <div class="absolute right-10 top-1/2 -translate-y-1/2 w-40 h-40
                  rounded-full border-[20px] border-white/5 pointer-events-none">
      </div>

      <div class="relative flex flex-col md:flex-row items-start
                  md:items-center justify-between gap-6">
        <div>
          <h2 class="text-white text-2xl font-bold mb-2"
              style="font-family:'Manrope',sans-serif">
            Need Urgent Assistance?
          </h2>
          <p class="text-white/60 text-sm max-w-sm leading-relaxed">
            For emergencies including medical, fire, or safety concerns, please
            contact our 24/7 Hotline directly for immediate response.
          </p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
          <a href="tel:911"
             class="inline-flex items-center gap-2 border border-white/30
                    text-white text-sm font-semibold px-6 py-3 rounded-full
                    hover:bg-white/10 transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1
                       1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976
                       2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755
                       1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176
                       0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518
                       -4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38
                       -1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            Call 911
          </a>
          <a href="tel:+6328123456"
             class="inline-flex items-center gap-2 bg-white/10 border
                    border-white/20 text-white text-sm font-semibold px-6 py-3
                    rounded-full hover:bg-white/20 transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2
                       0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Barangay Hotline
          </a>
        </div>
      </div>
    </section>

  </div>

  {{-- Emergency section sits outside the inner padding div --}}
  <div class="max-w-7xl mx-auto px-6 mt-10">
    {{-- move the <section> block here --}}
  </div>

</main>

@endsection