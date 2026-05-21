<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // ── Resident-specific status gate ─────────────────────────────────────
        // Residents go through admin approval before getting full portal access.
        if ($user->role === 'resident') {

            if ($user->account_status === 'rejected') {
                // Block login entirely — show rejection reason.
                auth()->logout();
                $reason = $user->rejection_reason
                    ? 'Reason: ' . $user->rejection_reason . ' '
                    : '';
                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Your registration was not approved. ' . $reason .
                                   'Please visit the barangay hall to appeal.'
                    ]);
            }

            if ($user->account_status === 'pending') {
                // Allow login but land on the pending screen — no portal access.
                return redirect()->route('resident.pending');
            }
        }

        // ── Non-resident deactivation check ───────────────────────────────────
        // (is_active is still used for manually deactivating staff/admin accounts)
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been deactivated.']);
        }

        // ── Normal role-based redirect ─────────────────────────────────────────
        return match($user->role) {
            'admin', 'staff', 'captain' => redirect()->route('admin.dashboard'),
            'resident'                  => redirect()->route('resident.dashboard'),
            default                     => redirect('/'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}