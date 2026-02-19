<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.doctors.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $doctor->load('user', 'speciality');
        $specialities = Speciality::all();

        return view('admin.doctors.edit', compact('doctor', 'specialities'));
    }

    /**
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'speciality_id' => 'nullable|exists:specialities,id',
            'medical_license_number' => 'nullable|string|max:8',
            'biography' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error de validación',
                'text' => 'La licencia médica no puede tener más de 8 caracteres.',
            ]);

            return redirect()->back()->withInput();
        }

        $doctor->update($validator->validated());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Doctor actualizado',
            'text' => 'Los datos del doctor se han actualizado correctamente.',
        ]);

        return redirect()->route('admin.doctors.edit', $doctor);
    }
}
