<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_autenticado_puede_actualizar_un_usuario(): void
    {
        // 1) Crear un rol
        $role = Role::create(['name' => 'client', 'guard_name' => 'web']);

        // 2) Crear un usuario admin que hará la actualización
        $admin = User::factory()->create();

        // 3) Crear el usuario que será actualizado
        $userToUpdate = User::factory()->create([
            'name' => 'Usuario Original',
            'email' => 'original@example.com',
            'id_number' => 'ORIG123',
        ]);
        $userToUpdate->assignRole($role);

        // 4) Simular que el admin inició sesión
        $this->actingAs($admin, 'web');

        // 5) Datos actualizados
        $updatedData = [
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@example.com',
            'id_number' => 'UPD456',
            'phone' => '9876543210',
            'address' => 'Nueva Dirección 456',
            'role' => $role->id,
        ];

        // 6) Enviar petición PUT para actualizar
        $response = $this->put(route('admin.users.update', $userToUpdate), $updatedData);

        // 7) Verificar redirección exitosa
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('swal');

        // 8) Verificar que los datos fueron actualizados en la BD
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Usuario Actualizado',
            'email' => 'actualizado@example.com',
            'id_number' => 'UPD456',
        ]);

        // 9) Verificar que los datos originales ya no existen
        $this->assertDatabaseMissing('users', [
            'email' => 'original@example.com',
        ]);
    }
}
