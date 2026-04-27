<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        $residents = [
            [
                'resident_code'     => 'BRY-2026-0001',
                'first_name'        => 'Kenneth',
                'middle_name'       => null,
                'last_name'         => 'Manos',
                'suffix'            => null,
                'birthdate'         => '2006-05-06',
                'gender'            => 'male',
                'civil_status'      => 'single',
                'purok_zone'        => 'Purok Villarosal, Eagle St.',
                'address'           => '#1348 Purok Villarosal, Eagle St. Magugpo South, Tagum City',
                'contact_number'    => '09126882130',
                'email'             => 'kenneth.manos1@gmail.com',
                'is_voter'          => 0,
                'is_senior_citizen' => 0,
                'is_pwd'            => 0,
                'is_solo_parent'    => 0,
                'is_active'         => 1,
            ],
            [
                'resident_code'     => 'BRY-2026-0002',
                'first_name'        => 'Bruce',
                'middle_name'       => 'Thomas',
                'last_name'         => 'Wayne',
                'suffix'            => null,
                'birthdate'         => '1984-02-19',
                'gender'            => 'male',
                'civil_status'      => 'married',
                'purok_zone'        => 'Purok 3 – Mabini',
                'address'           => 'Wayne Manor, Barangay San Isidro',
                'contact_number'    => '09170028364',
                'email'             => 'bruce.wayne@outlook.com',
                'is_voter'          => 1,
                'is_senior_citizen' => 0,
                'is_pwd'            => 0,
                'is_solo_parent'    => 0,
                'is_active'         => 1,
            ],
            [
                'resident_code'     => 'BRY-2026-0003',
                'first_name'        => 'Harry',
                'middle_name'       => 'James',
                'last_name'         => 'Potter',
                'suffix'            => null,
                'birthdate'         => '1985-07-07',
                'gender'            => 'male',
                'civil_status'      => 'single',
                'purok_zone'        => 'Purok 2 – Rizal',
                'address'           => 'Godric\'s Hollow, Barangay San Isidro',
                'contact_number'    => '09456987123',
                'email'             => 'harry.p@hogwarts.com',
                'is_voter'          => 1,
                'is_senior_citizen' => 0,
                'is_pwd'            => 0,
                'is_solo_parent'    => 1,
                'is_active'         => 1,
            ],
            [
                'resident_code'     => 'BRY-2026-0004',
                'first_name'        => 'Tony',
                'middle_name'       => null,
                'last_name'         => 'Stark',
                'suffix'            => 'Jr.',
                'birthdate'         => '1971-12-05',
                'gender'            => 'male',
                'civil_status'      => 'married',
                'purok_zone'        => 'Purok 1 – Mabini',
                'address'           => '108 Malibu Point, Barangay San Isidro',
                'contact_number'    => '09123456789',
                'email'             => 'tony.stark@gmail.com',
                'is_voter'          => 1,
                'is_senior_citizen' => 1,
                'is_pwd'            => 0,
                'is_solo_parent'    => 0,
                'is_active'         => 1,
            ],
            [
                'resident_code'     => 'BRY-2026-0005',
                'first_name'        => 'Grace',
                'middle_name'       => 'Herrera',
                'last_name'         => 'Santos',
                'suffix'            => null,
                'birthdate'         => '1968-07-09',
                'gender'            => 'female',
                'civil_status'      => 'widowed',
                'purok_zone'        => 'Purok 5 – Aguinaldo',
                'address'           => '90 Aguinaldo St., Barangay San Isidro',
                'contact_number'    => '09189990000',
                'email'             => 'grace.s@yahoo.com',
                'is_voter'          => 0,
                'is_senior_citizen' => 1,
                'is_pwd'            => 0,
                'is_solo_parent'    => 0,
                'is_active'         => 1,
            ],
        ];

        foreach ($residents as $data) {
            Resident::updateOrCreate(
                ['resident_code' => $data['resident_code']],
                $data
            );
        }
    }
}