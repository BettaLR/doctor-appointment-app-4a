<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Migración para rastrear las importaciones masivas de pacientes.
     * Guarda el estado, progreso y errores de cada importación.
     */
    public function up(): void
    {
        Schema::create('patient_imports', function (Blueprint $table) {
            $table->id();

            // Nombre del archivo subido
            $table->string('file_name');

            // Ruta del archivo en storage
            $table->string('file_path');

            // Contadores de progreso
            $table->integer('total_rows')->default(0);
            $table->integer('processed_rows')->default(0);
            $table->integer('failed_rows')->default(0);

            // Estado de la importación
            $table->enum('status', ['pendiente', 'procesando', 'completado', 'fallido'])
                ->default('pendiente');

            // Registro de errores (JSON con detalle por fila)
            $table->json('errors')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_imports');
    }
};
