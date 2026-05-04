<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Portal') — CiviLink</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>

<body class="bg-[#F5F5F0] antialiased min-h-screen flex flex-col">

    {{-- Slim top navbar --}}
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between gap-4">

            {{-- Logo --}}
            <a href="{{ route('resident.request.form') }}"
               class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 bg-[#2D5A27] rounded-xl flex items-center
                            justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0
                                 01-1-1V9.5z"/>
                        <path d="M9 21V13h6v8" fill="white" opacity=".4"/>
                    </svg>
                </div>
                <span class="font-bold text-[#1A1A1A] text-sm"
                      style="font-family:'Manrope',sans-serif">
                    CiviLink
                </span>
            </a>

            {{-- Nav tabs --}}
            <nav class="flex items-center gap-1">
                <a href="{{ route('resident.request.form') }}"
                   class="text-sm font-semibold px-4 py-2 rounded-full transition-all
                          {{ request()->routeIs('resident.request*')
                              ? 'bg-[#E8F5E3] text-[#2D5A27]'
                              : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    Request Document
                </a>
                <a href="{{ route('resident.my-requests') }}"
                   class="text-sm font-semibold px-4 py-2 rounded-full transition-all
                          {{ request()->routeIs('resident.my-requests')
                              ? 'bg-[#E8F5E3] text-[#2D5A27]'
                              : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    My Requests
                    @php
                        $pendingCount = auth()->user()->resident_id
                            ? \App\Models\DocumentRequest
                                ::where('resident_id', auth()->user()->resident_id)
                                ->where('status', 'pending')->count()
                            : 0;
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-1 text-xs bg-yellow-400 text-white
                                     font-bold w-5 h-5 rounded-full inline-flex
                                     items-center justify-center">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </nav>

            {{-- Right: user + logout --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-gray-800 leading-none">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-400 leading-none mt-0.5">
                        Resident
                    </p>
                </div>
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] flex items-center
                            justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-8 h-8 rounded-full bg-gray-100 flex items-center
                                   justify-center text-gray-400 hover:bg-red-50
                                   hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                             stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3
                                     3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0
                                     013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </header>

    {{-- Flash --}}
    @if(session('success'))
    <div class="max-w-5xl mx-auto px-6 pt-5 w-full">
        <div class="flex items-center gap-3 bg-[#E8F5E3] border border-[#b8ddb4]
                    text-[#2D5A27] text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                         00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414
                         1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 py-5 mt-10">
        <div class="max-w-5xl mx-auto px-6 flex items-center justify-between
                    flex-wrap gap-3">
            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Barangay Sanctuary Digital Commons.
            </p>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}"
                   class="text-xs text-gray-400 hover:text-gray-600">
                    Public Site
                </a>
                <a href="{{ route('contact') }}"
                   class="text-xs text-gray-400 hover:text-gray-600">
                    Contact Support
                </a>
            </div>
        </div>
    </footer>

</body>
</html>