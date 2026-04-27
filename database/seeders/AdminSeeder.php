<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'System Admin',
            'email'    => 'admin@barangay.gov',
            'password' => Hash::make('admin1234'),
            'role'     => 'admin',
            'is_active'=> 1,
        ]);

        User::create([
            'name'     => 'Barangay Captain',
            'email'    => 'captain@barangay.gov',
            'password' => Hash::make('captain1234'),
            'role'     => 'captain',
            'is_active'=> 1,
        ]);

        User::create([
            'name'     => 'Barangay Staff',
            'email'    => 'staff@barangay.gov',
            'password' => Hash::make('staff1234'),
            'role'     => 'staff',
            'is_active'=> 1,
        ]);
    }
}