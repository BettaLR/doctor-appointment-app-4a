<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSelfDeleteTest extends TestCase
{
    // Usar la funcion para refrescar BD
    use RefreshDatabase;

    /** @test */
    public function un_usuario_no_puede_eliminarse_a_si_mismo(): void
    {
        // 1) Crear un usuario de prueba
        $user = User::factory()->create();

        // 2) Simular que ese usuario ya inicio sesion
        $this->actingAs($user, 'web');

        // 3) Simular una peticion HTTP DELETE (borrar un usuario)
        $response = $this->delete(route('admin.users.destroy', $user));

        // 4) Esperar que el servidor bloquee el borrado y redirija con SweetAlert
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('swal');

        // 5) Verificar en la BD que sigue existiendo el usuario
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
}