<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredResidentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'email.unique'    => 'This email is already registered.',
            'password.min'    => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'resident',
            'resident_id' => null,
            'is_active'   => 1,
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('resident.dashboard');
    }
}