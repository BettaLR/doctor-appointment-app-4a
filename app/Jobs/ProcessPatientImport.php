<?php

namespace App\Jobs;

use App\Models\BloodType;
use App\Models\Patient;
use App\Models\PatientImport;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

/**
 * Job para procesar la importación masiva de pacientes desde un archivo CSV.
 * Se ejecuta en segundo plano (Background) para no bloquear la pantalla del usuario.
 *
 * Implementa ShouldQueue para que Laravel lo envíe a la cola de trabajos.
 *
 * Por cada fila del CSV:
 * 1. Crea un registro en la tabla users (con rol "Paciente")
 * 2. Crea un registro en la tabla patients (vinculado al usuario)
 * 3. Busca el tipo de sangre por nombre para vincular correctamente
 */
class ProcessPatientImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Número de intentos antes de marcar como fallido
    public int $tries = 1;

    // Timeout en segundos (10 minutos para archivos grandes)
    public int $timeout = 600;

    protected int $importId;

    /**
     * Crear una nueva instancia del job.
     *
     * @param int $importId ID del registro PatientImport a procesar
     */
    public function __construct(int $importId)
    {
        $this->importId = $importId;
    }

    /**
     * Ejecutar el job: leer el CSV y crear pacientes.
     */
    public function handle(): void
    {
        // Obtener el registro de importación
        $import = PatientImport::findOrFail($this->importId);

        // Marcar como "procesando"
        $import->update(['status' => 'procesando']);

        $errors = [];
        $processed = 0;
        $failed = 0;

        try {
            // Abrir el archivo CSV desde storage
            $filePath = Storage::disk('local')->path($import->file_path);
            $file = fopen($filePath, 'r');

            if (!$file) {
                $import->update([
                    'status' => 'fallido',
                    'errors' => [['fila' => 0, 'error' => 'No se pudo abrir el archivo']],
                ]);
                return;
            }

            // Leer la primera fila como encabezados
            $headers = fgetcsv($file);

            // Limpiar BOM (Byte Order Mark) del primer encabezado si existe
            if (!empty($headers[0])) {
                $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);
            }

            // Normalizar encabezados: minúsculas y sin espacios extra
            $headers = array_map(function ($h) {
                return strtolower(trim($h));
            }, $headers);

            // Contar total de filas
            $totalRows = 0;
            $startPosition = ftell($file);
            while (fgetcsv($file) !== false) {
                $totalRows++;
            }
            // Regresar al inicio de datos
            fseek($file, $startPosition);

            $import->update(['total_rows' => $totalRows]);

            // Obtener el rol "Paciente" una sola vez
            $rolePaciente = Role::where('name', 'Paciente')->first();

            // Cargar todos los tipos de sangre para búsqueda rápida
            $bloodTypes = BloodType::all()->keyBy(function ($item) {
                return strtolower(trim($item->name));
            });

            // Número de fila actual (para reportar errores)
            $rowNumber = 1;

            // ==========================================
            // Procesar cada fila del CSV
            // ==========================================
            while (($row = fgetcsv($file)) !== false) {
                $rowNumber++;

                try {
                    // Saltar filas vacías
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Mapear columnas usando los encabezados
                    $data = array_combine($headers, $row);

                    // Validar campos obligatorios
                    $nombre = trim($data['nombre'] ?? '');
                    $email = trim($data['email'] ?? '');

                    if (empty($nombre) || empty($email)) {
                        $failed++;
                        $errors[] = [
                            'fila' => $rowNumber,
                            'error' => 'Nombre y email son obligatorios',
                        ];
                        continue;
                    }

                    // Verificar que el email no exista ya
                    if (User::where('email', $email)->exists()) {
                        $failed++;
                        $errors[] = [
                            'fila' => $rowNumber,
                            'error' => "El email {$email} ya existe en el sistema",
                        ];
                        continue;
                    }

                    // ---- Crear el usuario ----
                    $user = User::create([
                        'name' => $nombre,
                        'email' => $email,
                        'password' => Hash::make('password123'), // Contraseña temporal
                        'phone' => trim($data['telefono'] ?? ''),
                        'address' => trim($data['direccion'] ?? ''),
                        'id_number' => trim($data['id_number'] ?? ''),
                    ]);

                    // Asignar rol de Paciente
                    if ($rolePaciente) {
                        $user->assignRole($rolePaciente);
                    }

                    // ---- Buscar tipo de sangre ----
                    $bloodTypeId = null;
                    $bloodTypeName = strtolower(trim($data['tipo_sangre'] ?? ''));
                    if (!empty($bloodTypeName) && $bloodTypes->has($bloodTypeName)) {
                        $bloodTypeId = $bloodTypes->get($bloodTypeName)->id;
                    }

                    // ---- Crear el paciente ----
                    Patient::create([
                        'user_id' => $user->id,
                        'blood_type_id' => $bloodTypeId,
                        'allergies' => trim($data['alergias'] ?? ''),
                        'chronic_conditions' => trim($data['condiciones_cronicas'] ?? ''),
                        'surgical_history' => trim($data['historial_quirurgico'] ?? ''),
                        'family_history' => trim($data['historial_familiar'] ?? ''),
                        'observations' => trim($data['observaciones'] ?? ''),
                        'emergency_contact_name' => trim($data['contacto_emergencia_nombre'] ?? ''),
                        'emergency_contact_phone' => trim($data['contacto_emergencia_telefono'] ?? ''),
                        'emergency_contact_relationship' => trim($data['contacto_emergencia_parentesco'] ?? ''),
                    ]);

                    $processed++;

                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = [
                        'fila' => $rowNumber,
                        'error' => $e->getMessage(),
                    ];
                    Log::error("Error importando fila {$rowNumber}: " . $e->getMessage());
                }

                // Actualizar progreso cada 50 filas
                if (($processed + $failed) % 50 === 0) {
                    $import->update([
                        'processed_rows' => $processed,
                        'failed_rows' => $failed,
                    ]);
                }
            }

            fclose($file);

            // ==========================================
            // Actualizar resultado final
            // ==========================================
            $import->update([
                'processed_rows' => $processed,
                'failed_rows' => $failed,
                'status' => 'completado',
                'errors' => !empty($errors) ? $errors : null,
            ]);

            Log::info("Importación #{$this->importId} completada: {$processed} procesados, {$failed} fallidos");

        } catch (\Exception $e) {
            // Si ocurre un error general, marcar toda la importación como fallida
            $import->update([
                'status' => 'fallido',
                'processed_rows' => $processed,
                'failed_rows' => $failed,
                'errors' => array_merge($errors, [
                    ['fila' => 0, 'error' => 'Error general: ' . $e->getMessage()]
                ]),
            ]);

            Log::error("Importación #{$this->importId} fallida: " . $e->getMessage());
        }
    }
}
