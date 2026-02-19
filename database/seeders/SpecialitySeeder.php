<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Speciality;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialities = [
            'Cardiología',
            'Pediatría',
            'Dermatología',
            'Neurología',
            'Oftalmología',
            'Traumatología',
            'Ginecología',
            'Medicina General',
        ];

        foreach ($specialities as $speciality) {
            Speciality::firstOrCreate(['name' => $speciality]);
        }
    }
}
