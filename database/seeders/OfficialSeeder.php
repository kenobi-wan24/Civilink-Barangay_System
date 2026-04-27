<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Official;

class OfficialSeeder extends Seeder
{
    public function run(): void
    {
        $officials = [
            ['name' => 'Juan Dela Cruz',    'position' => 'Barangay Captain',   'sort_order' => 1],
            ['name' => 'Maria Santos',      'position' => 'Barangay Kagawad',   'sort_order' => 2],
            ['name' => 'Pedro Reyes',       'position' => 'Barangay Kagawad',   'sort_order' => 3],
            ['name' => 'Ana Gomez',         'position' => 'Barangay Kagawad',   'sort_order' => 4],
            ['name' => 'Jose Mendoza',      'position' => 'SK Chairperson',     'sort_order' => 5],
            ['name' => 'Lucia Fernandez',   'position' => 'Barangay Secretary', 'sort_order' => 6],
            ['name' => 'Ramon Torres',      'position' => 'Barangay Treasurer', 'sort_order' => 7],
        ];

        foreach ($officials as $official) {
            Official::create(array_merge($official, ['is_active' => 1]));
        }
    }
}