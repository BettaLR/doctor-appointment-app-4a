<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Manuel Cano',
            'email' => 'alexcanolara818@gmail.com',
            'email_verified_at' => now(), // Verificar el email para permitir login
            'password' => Hash::make('14112003'),
            'id_number' => '123456789',
            'phone' => '123456789',
            'address' => 'calle 123, colonia 456 ',

        ])->assignRole('Super Admin');

    }
}