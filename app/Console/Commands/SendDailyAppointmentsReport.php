<?php

namespace App\Console\Commands;

use App\Mail\DailyAppointmentsReport;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Comando artisan para enviar el reporte diario de citas.
 * Se ejecuta automáticamente a las 8:00 AM mediante Task Scheduling.
 *
 * Envía:
 * - Al administrador: lista de TODAS las citas del día
 * - A cada doctor: lista de SUS citas programadas para el día
 */
class SendDailyAppointmentsReport extends Command
{
    // Firma del comando para ejecutarlo manualmente
    protected $signature = 'appointments:send-daily-report';

    // Descripción del comando
    protected $description = 'Envía el reporte diario de citas al administrador y a cada doctor';

    /**
     * Ejecutar el comando.
     */
    public function handle()
    {
        $this->info('Enviando reporte diario de citas...');

        // Obtener las citas de hoy con sus relaciones
        $todayAppointments = Appointment::with(['patient.user', 'doctor.user', 'doctor.speciality'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_date')
            ->get();

        // ==========================================
        // 1. Enviar reporte al administrador
        // ==========================================
        $admins = User::role('Administrador')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)
                ->send(new DailyAppointmentsReport($todayAppointments, $admin->name));

            $this->info("✅ Reporte enviado al administrador: {$admin->email}");
        }

        // ==========================================
        // 2. Enviar reporte a cada doctor con SUS citas
        // ==========================================
        // Agrupar citas por doctor_id
        $appointmentsByDoctor = $todayAppointments->groupBy('doctor_id');

        foreach ($appointmentsByDoctor as $doctorId => $doctorAppointments) {
            $doctor = $doctorAppointments->first()->doctor;

            Mail::to($doctor->user->email)
                ->send(new DailyAppointmentsReport($doctorAppointments, 'Dr. ' . $doctor->user->name));

            $this->info("✅ Reporte enviado al doctor: {$doctor->user->email}");
        }

        $this->info("✅ Reporte diario completado. Total citas hoy: {$todayAppointments->count()}");

        return Command::SUCCESS;
    }
}
