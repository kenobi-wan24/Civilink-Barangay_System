<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sign In — CiviLink</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>

<body class="min-h-screen flex flex-col"
      style="background: linear-gradient(135deg, #f0f7ee 0%, #f5faf3 50%, #e8f5e3 100%)">

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-12">

        {{-- Logo + brand --}}
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 bg-[#2D5A27] rounded-2xl flex items-center
                        justify-center shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                    <path d="M9 21V13h6v8" fill="white" opacity=".4"/>
                </svg>
            </div>
            <h1 class="text-2xl text-[#2D5A27]"
                style="font-family:'Manrope',sans-serif;font-weight:700">
                CiviLink
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Digital Commons Portal</p>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm
                    border border-gray-100 px-8 py-8">

            {{-- Laravel validation errors --}}
            @if($errors->any())
                <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200
                            rounded-xl text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="mb-6">
                <h2 class="text-xl text-gray-900"
                    style="font-family:'Manrope',sans-serif;font-weight:700">
                    Welcome Resident
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Please enter your credentials to access document services.
                </p>
            </div>

            {{-- Vue LoginForm mounted here --}}
            <div
                id="login-app"
                data-login-action="{{ route('login') }}"
                data-register-action="{{ route('register.resident') }}"
                data-csrf="{{ csrf_token() }}"
                data-server-errors="{{ json_encode($errors->login->toArray() ?? []) }}"
                data-reg-errors="{{ json_encode($errors->register->toArray() ?? []) }}"
                data-default-tab="{{ session('tab', 'login') }}"
                data-old="{{ json_encode([
                    'email'     => old('email'),
                    'name'      => old('name'),
                    'reg_email' => old('reg_email'),
                ]) }}"
            ></div>
        </div>

        {{-- Verified badge --}}
        <p class="mt-8 text-xs font-semibold tracking-[.2em] text-gray-400 uppercase">
            Verified Access Only
        </p>

    </main>

    {{-- Footer --}}
    <footer class="py-5 px-6 border-t border-gray-100 bg-white/60">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center
                    justify-between gap-3">
            <p class="text-xs text-gray-400">
                © 2024 CiviLink Digital Commons
            </p>
            <nav class="flex items-center gap-5">
                <a href="#"
                   class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Community Guidelines
                </a>
                <a href="#"
                   class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Privacy Policy
                </a>
                <a href="#"
                   class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Contact Support
                </a>
            </nav>
        </div>
    </footer>

</body>
</html>