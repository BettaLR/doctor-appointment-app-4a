<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.insurances.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.insurances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'policy_number' => 'nullable|string|max:255',
            'coverage_type' => 'nullable|string|max:255',
            'coverage_percentage' => 'nullable|numeric|min:0|max:100',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Insurance::create($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Convenio creado',
            'text' => 'El convenio de seguro se ha creado correctamente.',
        ]);

        return redirect()->route('admin.insurances.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        return view('admin.insurances.edit', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insurance $insurance)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'policy_number' => 'nullable|string|max:255',
            'coverage_type' => 'nullable|string|max:255',
            'coverage_percentage' => 'nullable|numeric|min:0|max:100',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $insurance->update($validated);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Convenio actualizado',
            'text' => 'El convenio de seguro se ha actualizado correctamente.',
        ]);

        return redirect()->route('admin.insurances.edit', $insurance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        $insurance->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Convenio eliminado',
            'text' => 'El convenio de seguro se ha eliminado correctamente.',
        ]);

        return redirect()->route('admin.insurances.index');
    }
}
