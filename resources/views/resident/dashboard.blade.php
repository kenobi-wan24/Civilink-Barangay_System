<!DOCTYPE html>
<html>
<head>
    <title>Resident Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
</head>
<body style="font-family:'Inter',sans-serif; display:flex; align-items:center; justify-content:center; min-height:100vh; background:#f5faf3; margin:0;">
    <div style="text-align:center;">
        <div style="width:56px; height:56px; background:#2D5A27; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
            <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
            </svg>
        </div>
        <h2 style="font-size:1.25rem; font-weight:600; color:#1a1a1a; margin:0 0 0.5rem;">
            Welcome, {{ auth()->user()->name }}
        </h2>
        <p style="color:#6B7280; font-size:0.875rem; margin:0 0 1.5rem;">
            Resident portal coming soon.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button style="background:#2D5A27; color:white; border:none; padding:0.6rem 1.5rem; border-radius:8px; font-size:0.875rem; cursor:pointer;">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
