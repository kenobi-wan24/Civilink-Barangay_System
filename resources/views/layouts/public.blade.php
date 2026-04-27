<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'CiviLink') - Official Community Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1,h2,h3,h4,h5,h6,.font-heading { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">

{{-- ───── Navbar ───── --}}
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#2D5A27] rounded-md flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                    <path d="M9 21V12h6v9" fill="white" opacity=".4"/>
                </svg>
            </div>
            <span class="font-heading font-700 text-[#1A1A1A] text-lg tracking-tight" style="font-family:'Manrope',sans-serif;font-weight:700">CIVILINK</span>
        </a>

        {{-- Nav links --}}
        <div class="hidden md:flex items-center gap-8">
            @php
                $navLinks = [
                    ['label' => 'Home',          'route' => 'home'],
                    ['label' => 'Officials',      'route' => 'officials'],
                    ['label' => 'Announcements',  'route' => 'announcements'],
                    ['label' => 'Contact',        'route' => 'contact'],
                ];
            @endphp
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="text-sm font-medium transition-colors
                          {{ request()->routeIs($link['route'])
                              ? 'text-[#2D5A27] border-b-2 border-[#2D5A27] pb-0.5'
                              : 'text-gray-600 hover:text-[#2D5A27]' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        {{-- CTA --}}
        <a href="{{ route('login') }}"
           class="bg-[#2D5A27] text-white text-sm font-medium px-5 py-2 rounded-full hover:bg-[#3d7a35] transition-colors">
            Resident Portal
        </a>
    </div>
</nav>

{{-- ───── Page content ───── --}}
@yield('content')

{{-- ───── Footer ───── --}}
<footer class="bg-white border-t border-gray-100 pt-14 pb-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            {{-- Brand --}}
            <div class="md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 bg-[#2D5A27] rounded-md flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                        </svg>
                    </div>
                    <span style="font-family:'Manrope',sans-serif;font-weight:700" class="text-[#1A1A1A] text-sm">CIVILINK</span>
                </a>
                <p class="text-xs text-gray-500 leading-relaxed mb-4">
                    The official digital commons of CiviLink. Bridging the gap between the local government and its citizens through digital innovation.
                </p>
                <div class="flex items-center gap-3">
                    <a href="#" class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center hover:bg-[#E8F5E3] transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center hover:bg-[#E8F5E3] transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/></svg>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center hover:bg-[#E8F5E3] transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Explore --}}
            <div>
                <h4 style="font-family:'Manrope',sans-serif;font-weight:600" class="text-sm text-[#1A1A1A] mb-4">Explore</h4>
                <ul class="space-y-2.5">
                    @foreach([['Home','home'],['Officials','officials'],['Announcements','announcements'],['Contact','contact']] as [$label,$route])
                    <li><a href="{{ route($route) }}" class="text-xs text-gray-500 hover:text-[#2D5A27] transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Office Hours --}}
            <div>
                <h4 style="font-family:'Manrope',sans-serif;font-weight:600" class="text-sm text-[#1A1A1A] mb-4">Office Hours</h4>
                <ul class="space-y-2.5 text-xs">
                    <li class="flex justify-between gap-4">
                        <span class="text-gray-500">Monday – Friday</span>
                        <span class="text-gray-700 font-medium">8:00 AM – 5:00 PM</span>
                    </li>
                    <li class="flex justify-between gap-4">
                        <span class="text-gray-500">Saturday</span>
                        <span class="text-gray-700 font-medium">9:00 AM – 12:00 PM</span>
                    </li>
                    <li class="flex justify-between gap-4">
                        <span class="text-gray-500">Sunday & Holidays</span>
                        <span class="text-red-500 font-medium">Closed</span>
                    </li>
                </ul>
            </div>

            {{-- Emergency --}}
            <div>
                <h4 style="font-family:'Manrope',sans-serif;font-weight:600" class="text-sm text-[#1A1A1A] mb-4">Emergency</h4>
                <div class="flex items-center gap-2 text-xs text-gray-600">
                    <svg class="w-4 h-4 text-[#2D5A27]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="font-medium text-[#2D5A27]">(02) 888-SAFE</span>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-100 pt-6 flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-400">© 2026 CiviLink Digital Commons. All Rights Reserved.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="text-xs text-gray-400 hover:text-gray-600">Privacy Policy</a>
                <a href="#" class="text-xs text-gray-400 hover:text-gray-600">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>