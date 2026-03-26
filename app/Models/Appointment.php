<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // Campos asignables en masa
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'reason',
        'notes',
        'status',
    ];

    // Casteo de campos para manejar fechas correctamente
    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    /**
     * Relación: la cita pertenece a un paciente.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relación: la cita pertenece a un doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
