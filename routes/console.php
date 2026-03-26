<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ==========================================
// Tarea programada: Reporte diario de citas
// Se ejecuta todos los días a las 8:00 AM
// Envía la lista de pacientes del día al administrador y a cada doctor
// ==========================================
Schedule::command('appointments:send-daily-report')->dailyAt('08:00');

