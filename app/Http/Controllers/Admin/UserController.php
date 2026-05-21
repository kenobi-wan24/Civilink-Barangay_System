<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Pending registrations + staff list ────────────────────
    public function index()
    {
        $pending = User::where('role', 'resident')
                       ->where('account_status', 'pending')
                       ->latest()
                       ->get();

        return view('admin.users.index', compact('pending'));
    }

    // ── Show full review page for a pending registration ──────
    public function review(User $user)
    {
        abort_if($user->role !== 'resident', 404);

        return view('admin.users.review', compact('user'));
    }

    // Approve: create resident profile + activate account ───
    public function approveRegistration(Request $request, User $user)
    {
        abort_if($user->account_status !== 'pending', 422);

        // Admin may have corrected typos in the review form
        $request->validate([
            'first_name'       => ['required', 'string', 'max:100'],
            'middle_name'      => ['nullable', 'string', 'max:100'],
            'last_name'        => ['required', 'string', 'max:100'],
            'suffix'           => ['nullable', 'string', 'max:20'],
            'birthdate'        => ['required', 'date'],
            'reg_gender'       => ['required', 'in:Male,Female'],
            'reg_civil_status' => ['required', 'string'],
            'reg_contact'      => ['nullable', 'string', 'max:20'],
            'reg_purok_zone'   => ['required', 'string', 'max:100'],
            'reg_address'      => ['required', 'string'],
        ]);

        // Sync any edits the admin made back to the users table first
        $user->update([
            'first_name'       => $request->first_name,
            'middle_name'      => $request->middle_name,
            'last_name'        => $request->last_name,
            'suffix'           => $request->suffix,
            'birthdate'        => $request->birthdate,
            'reg_gender'       => $request->reg_gender,
            'reg_civil_status' => $request->reg_civil_status,
            'reg_contact'      => $request->reg_contact,
            'reg_purok_zone'   => $request->reg_purok_zone,
            'reg_address'      => $request->reg_address,
        ]);

        // Generate next resident_code in BRY-YYYY-XXXX format
        $year = now()->year;
        $lastResident = Resident::whereYear('created_at', $year)
                                 ->orderBy('id', 'desc')
                                 ->first();
        $nextNumber = $lastResident
            ? (int) substr($lastResident->resident_code, -4) + 1
            : 1;
        $residentCode = 'BRY-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $resident = Resident::create([
            'resident_code'  => $residentCode,
            'first_name'     => $user->first_name,
            'middle_name'    => $user->middle_name,
            'last_name'      => $user->last_name,
            'suffix'         => $user->suffix,
            'birthdate'      => $user->birthdate,
            'gender'         => $user->reg_gender,
            'civil_status'   => $user->reg_civil_status,
            'contact_number' => $user->reg_contact,
            'purok_zone'     => $user->reg_purok_zone,
            'address'        => $user->reg_address,
            'email'          => $user->email,
            'is_active'      => 1,
        ]);

        // Activate the user account and link to the new resident profile
        $user->update([
            'resident_id'    => $resident->id,
            'account_status' => 'active',
            'is_active'      => 1,
            'name'           => trim(
                $user->first_name . ' ' .
                ($user->middle_name ? $user->middle_name . ' ' : '') .
                $user->last_name .
                ($user->suffix ? ', ' . $user->suffix : '')
            ),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "{$user->name} has been approved and their resident profile has been created.");
    }

    // ── Reject: store reason + block account ──────────────────
    public function rejectRegistration(Request $request, User $user)
    {
        abort_if($user->account_status !== 'pending', 422);

        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ], [
            'rejection_reason.required' => 'Please provide a reason for rejection.',
        ]);

        $user->update([
            'account_status'   => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'is_active'        => 0,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "{$user->name}'s registration has been rejected.");
    }

    // - Link a portal account to an existing resident profile ─
    // Kept for backward compatibility. New registrations link
    // automatically via approveRegistration() above.
    public function linkAccount(Request $request, User $user)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
        ]);

        $alreadyLinked = User::where('resident_id', $request->resident_id)
                              ->where('id', '!=', $user->id)
                              ->exists();

        if ($alreadyLinked) {
            return back()->withErrors([
                'resident_id' => 'This resident profile is already linked to another account.'
            ]);
        }

        $user->update([
            'resident_id'    => $request->resident_id,
            'account_status' => 'active',
            'is_active'      => 1,
        ]);

        return back()->with('success', "Account linked to resident profile successfully.");
    }

    // ── Create staff / captain accounts 
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
            'name'           => $request->name,
            'email'          => $request->email,
            'role'           => $request->role,
            'password'       => Hash::make($request->password),
            'is_active'      => 1,
            'account_status' => 'active',
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