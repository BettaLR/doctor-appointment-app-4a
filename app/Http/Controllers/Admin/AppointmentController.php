<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Controlador para gestionar las citas médicas.
 * Al guardar una cita, genera un PDF y lo envía por correo
 * tanto al paciente como al doctor.
 */
class AppointmentController extends Controller
{
    /**
     * Mostrar listado de citas médicas.
     */
    public function index()
    {
        return view('admin.appointments.index');
    }

    /**
     * Mostrar formulario para crear una nueva cita.
     */
    public function create()
    {
        // Obtener todos los pacientes y doctores para los selectores
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user', 'speciality')->get();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Guardar la cita y enviar correo con PDF al paciente y al doctor.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Crear la cita en la base de datos
        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => 'confirmada',
        ]);

        // Cargar las relaciones necesarias para el correo
        $appointment->load(['patient.user', 'doctor.user', 'doctor.speciality']);

        // Enviar correo con PDF al paciente
        Mail::to($appointment->patient->user->email)
            ->send(new AppointmentConfirmation($appointment));

        // Enviar correo con PDF al doctor
        Mail::to($appointment->doctor->user->email)
            ->send(new AppointmentConfirmation($appointment));

        // Mostrar mensaje de éxito con SweetAlert
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita registrada exitosamente',
            'text' => 'Se ha enviado el comprobante por correo al paciente y al doctor.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Mostrar los detalles de una cita.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user', 'doctor.speciality']);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Eliminar una cita.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita eliminada',
            'text' => 'La cita ha sido eliminada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }
}
