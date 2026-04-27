<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Unlinked portal accounts ──────────────────────────────
    public function index()
    {
        $unlinked = User::where('role', 'resident')
                        ->whereNull('resident_id')
                        ->latest()
                        ->get();

        // Only show residents that are NOT already linked to any account
        $alreadyLinkedIds = User::whereNotNull('resident_id')->pluck('resident_id');

        $residents = Resident::where('is_active', 1)
                              ->whereNotIn('id', $alreadyLinkedIds)
                              ->orderBy('last_name')
                              ->get();

        return view('admin.users.index', compact('unlinked', 'residents'));
    }

    // ── Link a portal account to an existing resident profile ─
    public function linkAccount(Request $request, User $user)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
        ]);

        // Make sure the resident isn't already linked to another account
        $alreadyLinked = User::where('resident_id', $request->resident_id)
                              ->where('id', '!=', $user->id)
                              ->exists();

        if ($alreadyLinked) {
            return back()->withErrors([
                'resident_id' => 'This resident profile is already linked to another account.'
            ]);
        }

        $user->update(['resident_id' => $request->resident_id]);

        return back()->with('success', "Account linked to resident profile successfully.");
    }

    // ── Create staff / captain accounts ───────────────────────
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,staff,captain',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => 1,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Staff account created successfully.');
    }

    // ── Deactivate any user account ───────────────────────────
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => "You can't deactivate your own account."]);
        }

        $user->update(['is_active' => 0]);

        return back()->with('success', 'Account deactivated.');
    }
}