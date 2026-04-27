<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin') — CiviLink</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1,h2,h3,h4,h5,h6,.font-heading { font-family: 'Manrope', sans-serif; }
    </style>
</head>

<body class="bg-[#F5F5F0] antialiased">
<div style="display:flex;min-height:100vh">

    {{-- ─────────────────────────────────────────
         SIDEBAR
    ───────────────────────────────────────── --}}
    <aside style="width:240px;min-height:150vh;display:flex;flex-direction:column;flex-shrink:0"
           class="bg-white border-r border-gray-100">

        {{-- Logo --}}
        <div class="px-5 pt-5 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-[#2D5A27] rounded-xl flex items-center
                            justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0
                                 01-1-1V9.5z"/>
                        <path d="M9 21V13h6v8" fill="white" opacity=".4"/>
                    </svg>
                </div>
                <div>
                    </p>
                    <p class="text-xs font-bold text-[#2D5A27] leading-none mt-0.5"
                       style="font-family:'Manrope',sans-serif">
                        CiviLink
                    </p>
                    <p class="text-[9px] text-gray-400 leading-none mt-0.5 uppercase
                              tracking-widest">
                        Community Portal
                    </p>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            @php
                $navItems = [
                    [
                        'label'  => 'Dashboard',
                        'route'  => 'admin.dashboard',
                        'match'  => 'admin.dashboard',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2
                                     2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012
                                     2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0
                                     012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2
                                     -2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0
                                     01-2 2h-2a2 2 0 01-2-2v-2z"/>',
                    ],
                    [
                        'label'  => 'Residents',
                        'route'  => 'admin.residents.index',
                        'match'  => 'admin.residents*',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10
                                     0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0
                                     015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0
                                     0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0
                                     016 0z"/>',
                    ],
                    [
                        'label'  => 'Documents',
                        'route'  => 'admin.document-requests.index',
                        'match'  => 'admin.document-requests*',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                     012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0
                                     01.293.707V19a2 2 0 01-2 2z"/>',
                    ],
                    [
                        'label'  => 'Officials',
                        'route'  => 'admin.officials.index',
                        'match'  => 'admin.officials*',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14
                                     0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1
                                     4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                    ],
                    [
                        'label'  => 'Announcements',
                        'route'  => 'admin.announcements.index',
                        'match'  => 'admin.announcements*',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147
                                     -6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001
                                     0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543
                                     -1.766-5.067-3-9.168-3H7a3.988 3.988 0
                                     01-1.564-.317z"/>',
                    ],
                    [
                        'label'  => 'Inquiries',
                        'route'  => 'admin.inquiries.index',
                        'match'  => 'admin.inquiries*',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2
                                     2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2
                                     0 002 2z"/>',
                    ],
                    [
                        'label'  => 'Settings',
                        'route'  => 'admin.users.index',
                        'match'  => 'admin.users*',
                        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724
                                     1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37
                                     2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756
                                     2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94
                                     1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572
                                     1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724
                                     0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724
                                     1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924
                                     0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826
                                     -3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                     d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    ],
                ];
            @endphp

            @foreach($navItems as $item)
                @php $isActive = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                          font-medium transition-all
                          {{ $isActive
                              ? 'bg-[#E8F5E3] text-[#2D5A27]'
                              : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                    <svg class="w-4 h-4 flex-shrink-0
                                {{ $isActive ? 'text-[#2D5A27]' : 'text-gray-400' }}"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         viewBox="0 0 24 24">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['label'] }}

                    {{-- Unread badge for inquiries --}}
                    @if($item['label'] === 'Inquiries')
                        @php $unread = \App\Models\Inquiry::where('is_read', 0)->count(); @endphp
                        @if($unread > 0)
                            <span class="ml-auto text-xs font-bold bg-red-500 text-white
                                         w-5 h-5 rounded-full flex items-center
                                         justify-center leading-none">
                                {{ $unread > 9 ? '9+' : $unread }}
                            </span>
                        @endif
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- New Request CTA --}}
        <div class="px-3 pb-5">
            <a href="{{ route('admin.document-requests.index') }}"
               class="flex items-center justify-center gap-2 w-full bg-[#2D5A27]
                      hover:bg-[#3d7a35] text-white text-sm font-semibold py-3
                      rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>
                New Request
            </a>
        </div>

    </aside>

    {{-- ─────────────────────────────────────────
         MAIN AREA
    ───────────────────────────────────────── --}}
    <div style="flex:1;display:flex;flex-direction:column;min-width:0">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-100 px-6 h-16 flex items-center
                       justify-between gap-4 sticky top-0 z-40">

            {{-- Search --}}
            <div class="relative flex-1 max-w-sm">
                <span class="absolute inset-y-0 left-3.5 flex items-center
                             pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none"
                         stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M17 11A6 6 0 111 11a6 6 0 0116 0z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    placeholder="Search residents, records, or files..."
                    class="w-full bg-gray-50 border border-gray-200 rounded-full
                           pl-9 pr-4 py-2 text-sm text-gray-700 placeholder-gray-400
                           focus:outline-none focus:border-[#2D5A27] focus:bg-white
                           transition-all"
                />
            </div>

            {{-- Right: bell + settings + user --}}
            <div class="flex items-center gap-3">

                {{-- Bell --}}
                <button class="relative w-9 h-9 rounded-full bg-gray-50
                               border border-gray-200 flex items-center justify-center
                               hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none"
                         stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                                 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6
                                 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6
                                 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php $pendingCount = \App\Models\DocumentRequest::where('status','pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500
                                     text-white text-[9px] font-bold rounded-full flex
                                     items-center justify-center">
                            {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                        </span>
                    @endif
                </button>

                {{-- Settings --}}
                <a href="{{ route('admin.users.index') }}"
                   class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200
                          flex items-center justify-center hover:bg-gray-100
                          transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none"
                         stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724
                                 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37
                                 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756
                                 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94
                                 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572
                                 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724
                                 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724
                                 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924
                                 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826
                                 -3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>

                {{-- User avatar + info --}}
                <div class="flex items-center gap-2.5 pl-3 border-l border-gray-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-semibold text-gray-800 leading-none">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-400 capitalize leading-none mt-0.5">
                            {{ ucfirst(auth()->user()->role) }}
                        </p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-[#2D5A27] flex items-center
                                justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200
                                   flex items-center justify-center hover:bg-red-50
                                   hover:border-red-200 group transition-colors">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-red-500
                                    transition-colors"
                             fill="none" stroke="currentColor" stroke-width="1.8"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3
                                     3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0
                                     013 3v1"/>
                        </svg>
                    </button>
                </form>

            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success') || session('error'))
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-[#E8F5E3] border
                            border-[#b8ddb4] text-[#2D5A27] text-sm px-4 py-3
                            rounded-xl">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1
                                 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0
                                 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200
                            text-red-700 text-sm px-4 py-3 rounded-xl">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707
                                 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293
                                 1.293a1 1 0 101.414 1.414L10 11.414l1.293
                                 1.293a1 1 0 001.414-1.414L11.414 10l1.293
                                 -1.293a1 1 0 00-1.414-1.414L10 8.586
                                 8.707 7.293z"
                              clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="px-6 py-4 border-t border-gray-100 bg-white">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest"
                   style="font-family:'Manrope',sans-serif">
                    CIVILINK Digital Commons
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-xs text-gray-400 hover:text-gray-600">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-xs text-gray-400 hover:text-gray-600">
                        Terms of Service
                    </a>
                    <a href="{{ route('contact') }}"
                       class="text-xs text-gray-400 hover:text-gray-600">
                        Contact Us
                    </a>
                </div>
            </div>
        </footer>

    </div>
</div>
</body>
</html>