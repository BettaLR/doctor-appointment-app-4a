<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para rastrear las importaciones masivas de pacientes.
 * Cada registro representa una importación (un archivo CSV subido).
 */
class PatientImport extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'total_rows',
        'processed_rows',
        'failed_rows',
        'status',
        'errors',
    ];

    // Casteo de campos
    protected $casts = [
        'errors' => 'array',
    ];
}
