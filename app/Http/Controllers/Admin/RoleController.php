<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar que se cree bien
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        //Si pasa la validacion, crear el rol
        Role::create(['name' => $request->name]);

        //Variable de un solo uso para alerta
        session()->flash(
            'swal',
            [
                'icon' => 'success',
                'title' => 'Rol creado correctamente',
                'text' => 'El rol se ha creado exitosamente',
            ]
        );

        //Rediccenionara a la tabla principal
        return redirect()->route('admin.roles.index')
            ->with('Success', 'Role created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //Restringir la accion para los primeros 4 roles fijos
        if ($role->id <= 6) {
            //Variable de un solo uso
            session()->flash(
                'swal',
                [
                    'icon' => 'error',
                    'title' => 'Acción no permitida',
                    'text' => 'No se puede eliminar un rol fijo del sistema',
                ]
            );
            return redirect()->route('admin.roles.index');
        }
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        //Si el campo no cambia, no se actualiza
        if ($role->name === $request->name) {
            session()->flash(
                'swal',
                [
                    'icon' => 'info',
                    'title' => 'Sin cambios',
                    'text' => 'No se detectaron modificaciones',
                ]
            );
            return redirect()->route('admin.roles.index');
        }

        $role->update(['name' => $request->name]);

        //Variable de un solo uso para alerta
        session()->flash(
            'swal',
            [
                'icon' => 'success',
                'title' => 'Rol actualizado correctamente',
                'text' => 'El rol ha sido actualizado exitosamente',
            ]
        );

        //Rediccenionara a la tabla principal
        return redirect()->route('admin.roles.index', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //Restringir la accion para los primeros 4 roles fijos
        if ($role->id <= 6) {
            //Variable de un solo uso
            session()->flash(
                'swal',
                [
                    'icon' => 'error',
                    'title' => 'Acción no permitida',
                    'text' => 'No se puede eliminar un rol fijo del sistema',
                ]
            );
            return redirect()->route('admin.roles.index');
        }

        //Borrar el elemento
        $role->delete();

        //Alerta
        session()->flash(
            'swal',
            [
                'icon' => 'success',
                'title' => 'Rol eliminado correctamente',
                'text' => 'El rol ha sido eliminado exitosamente',
            ]
        );

        //Redireccionar a la tabla principal
        return redirect()->route('admin.roles.index');
    }
}