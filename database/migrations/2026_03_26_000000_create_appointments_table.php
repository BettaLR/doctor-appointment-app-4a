<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración para crear la tabla de citas médicas.
     * Relaciona pacientes y doctores (ambos son usuarios) con la cita.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Relación con el paciente (tabla patients -> users)
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // Relación con el doctor (tabla doctors -> users)
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');

            // Fecha y hora de la cita
            $table->dateTime('appointment_date');

            // Motivo de la consulta
            $table->text('reason');

            // Notas adicionales (opcional)
            $table->text('notes')->nullable();

            // Estado de la cita: pendiente, confirmada, cancelada
            $table->enum('status', ['pendiente', 'confirmada', 'cancelada'])->default('pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
