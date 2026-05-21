<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class RegisteredResidentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            // Step 1 — Account credentials
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],

            // Step 2 — Personal info
            'first_name'      => ['required', 'string', 'max:100'],
            'middle_name'     => ['nullable', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'suffix'          => ['nullable', 'string', 'max:20'],
            'birthdate'       => ['required', 'date', 'before:today'],
            'reg_gender'      => ['required', 'in:Male,Female'],
            'reg_civil_status'=> ['required', 'in:Single,Married,Widowed,Separated,Annulled'],
            'reg_contact'     => ['nullable', 'string', 'max:20'],

            // Step 3 — Address + optional ID upload
            'reg_purok_zone'  => ['required', 'string', 'max:100'],
            'reg_address'     => ['required', 'string', 'max:500'],
            'valid_id'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB
        ], [
            'email.unique'            => 'This email is already registered.',
            'password.min'            => 'Password must be at least 8 characters.',
            'password.confirmed'      => 'Passwords do not match.',
            'birthdate.before'        => 'Date of birth must be in the past.',
            'valid_id.mimes'          => 'Valid ID must be a PDF, JPG, or PNG file.',
            'valid_id.max'            => 'Valid ID file must not exceed 5MB.',
        ]);

        // Handle optional valid ID file upload
        $validIdPath = null;
        if ($request->hasFile('valid_id')) {
            $validIdPath = $request->file('valid_id')->store('valid-ids', 'public');
        }

        // Derive the `name` column from the name parts (used by Laravel auth internals)
        $fullName = trim(
            $request->first_name . ' ' .
            ($request->middle_name ? $request->middle_name . ' ' : '') .
            $request->last_name .
            ($request->suffix ? ', ' . $request->suffix : '')
        );

        $user = User::create([
            'name'             => $fullName,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'role'             => 'resident',
            'resident_id'      => null,

            // Pending until admin approves
            'account_status'   => 'pending',
            'is_active'        => 0,

            // Personal info
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
            'valid_id_path'    => $validIdPath,
        ]);

        event(new Registered($user));

        // Log them in — AuthenticatedSessionController will gate them
        // to the pending screen based on account_status.
        auth()->login($user);

        return redirect()->route('resident.pending');
    }
}