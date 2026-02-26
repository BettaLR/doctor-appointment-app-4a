<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\BloodType;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $patient->load('user', 'bloodType');
        $blood_types = BloodType::all();

        // Calcular la pestaña inicial según errores de validación
        $initialTab = 'personal';

        $errors = session('errors');
        if ($errors) {
            $tabMap = [
                'allergies' => 'antecedentes',
                'chronic_conditions' => 'antecedentes',
                'surgical_history' => 'antecedentes',
                'family_history' => 'antecedentes',
                'blood_type_id' => 'general',
                'observations' => 'general',
                'emergency_contact_name' => 'emergencia',
                'emergency_contact_phone' => 'emergencia',
                'emergency_contact_relationship' => 'emergencia',
            ];

            foreach ($errors->keys() as $field) {
                if (isset($tabMap[$field])) {
                    $initialTab = $tabMap[$field];
                    break;
                }
            }
        }

        return view('admin.patients.edit', compact('patient', 'blood_types', 'initialTab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        // Sanitizar teléfono: eliminar paréntesis, guiones y espacios
        if ($request->emergency_contact_phone) {
            $request->merge([
                'emergency_contact_phone' => preg_replace('/[\(\)\-\s]/', '', $request->emergency_contact_phone),
            ]);
        }

        $validated = $request->validate([
            // Datos personales (usuario)
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $patient->user->id,
            'id_number' => 'nullable|string|max:255|unique:users,id_number,' . $patient->user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            // Datos del paciente
            'blood_type_id' => 'nullable|exists:blood_types,id',
            'allergies' => 'nullable|string|max:255',
            'chronic_conditions' => 'nullable|string|max:255',
            'surgical_history' => 'nullable|string|max:255',
            'family_history' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|digits:10',
            'emergency_contact_relationship' => 'nullable|string|max:255',
        ]);

        // Actualizar datos del usuario
        $userFields = ['name', 'email', 'id_number', 'phone', 'address'];
        $patient->user->update(collect($validated)->only($userFields)->toArray());

        // Actualizar datos del paciente
        $patient->update(collect($validated)->except($userFields)->toArray());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Paciente actualizado',
            'text' => 'Los datos del paciente se han actualizado correctamente.',
        ]);

        return redirect()->route('admin.patients.edit', $patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
