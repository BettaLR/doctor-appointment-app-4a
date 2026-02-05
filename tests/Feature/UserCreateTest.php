<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_autenticado_puede_crear_un_nuevo_usuario(): void
    {
        // 1) Crear un rol para asignar al nuevo usuario
        $role = Role::create(['name' => 'client', 'guard_name' => 'web']);

        // 2) Crear un usuario admin que hará la creación
        $admin = User::factory()->create();

        // 3) Simular que el admin inició sesión
        $this->actingAs($admin, 'web');

        // 4) Datos del nuevo usuario a crear
        $userData = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'id_number' => 'ABC123456',
            'phone' => '1234567890',
            'address' => 'Calle Falsa 123',
            'role' => $role->id,
        ];

        // 5) Enviar petición POST para crear usuario
        $response = $this->post(route('admin.users.store'), $userData);

        // 6) Verificar redirección exitosa
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('swal');

        // 7) Verificar que el usuario existe en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => 'juan@example.com',
            'name' => 'Juan Pérez',
            'id_number' => 'ABC123456',
        ]);
    }
}
