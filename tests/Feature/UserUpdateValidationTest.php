<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_actualizacion_falla_con_email_duplicado(): void
    {
        // 1) Crear un rol
        $role = Role::create(['name' => 'client', 'guard_name' => 'web']);

        // 2) Crear un usuario admin
        $admin = User::factory()->create();

        // 3) Crear un usuario existente con un email
        $existingUser = User::factory()->create([
            'email' => 'existente@example.com',
            'id_number' => 'EXIST123',
        ]);

        // 4) Crear el usuario que intentará actualizarse con email duplicado
        $userToUpdate = User::factory()->create([
            'email' => 'original@example.com',
            'id_number' => 'ORIG456',
        ]);
        $userToUpdate->assignRole($role);

        // 5) Simular que el admin inició sesión
        $this->actingAs($admin, 'web');

        // 6) Intentar actualizar con el email que ya existe
        $response = $this->put(route('admin.users.update', $userToUpdate), [
            'name' => 'Usuario Test',
            'email' => 'existente@example.com', // Email duplicado
            'id_number' => 'NEW789',
            'role' => $role->id,
        ]);

        // 7) Verificar que hay error de validación en el campo email
        $response->assertSessionHasErrors('email');

        // 8) Verificar que el email original NO fue cambiado en la BD
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'email' => 'original@example.com',
        ]);
    }
}
