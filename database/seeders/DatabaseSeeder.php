<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(
            RoleSeeder::class
        );

//crea un usuario de prueba cada que ejcuto migrations
        User::factory()->create([
            'name' => 'Luis Berdugo',
            'email' => 'luism.berdugo@outlook.com',
            'password'=> bcrypt('12345678'),
        ]);
    }
}