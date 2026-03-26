<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPatientImport;
use App\Models\PatientImport;
use Illuminate\Http\Request;

/**
 * Controlador para la importación masiva de pacientes.
 * Permite subir un archivo CSV, despachar un Job en segundo plano,
 * y consultar el progreso de la importación.
 */
class PatientImportController extends Controller
{
    /**
     * Mostrar la vista de importación con historial.
     */
    public function index()
    {
        // Obtener todas las importaciones ordenadas por fecha, más recientes primero
        $imports = PatientImport::orderBy('created_at', 'desc')->get();

        return view('admin.patient-imports.index', compact('imports'));
    }

    /**
     * Recibir el archivo CSV, guardarlo y despachar el Job.
     */
    public function store(Request $request)
    {
        // Validar que se suba un archivo CSV válido
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240', // Máximo 10 MB
        ]);

        // Guardar el archivo en storage/app/imports/
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('imports', 'local');

        // Crear el registro de importación en estado "pendiente"
        $import = PatientImport::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
            'status' => 'pendiente',
        ]);

        // Despachar el Job a la cola para procesamiento en segundo plano
        ProcessPatientImport::dispatch($import->id);

        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'info',
            'title' => 'Importación iniciada',
            'text' => 'El archivo se está procesando en segundo plano. Puedes ver el progreso en esta página.',
        ]);

        return redirect()->route('admin.patient-imports.index');
    }

    /**
     * Endpoint JSON para consultar el estado de una importación (polling).
     */
    public function status(PatientImport $patientImport)
    {
        return response()->json([
            'id' => $patientImport->id,
            'status' => $patientImport->status,
            'total_rows' => $patientImport->total_rows,
            'processed_rows' => $patientImport->processed_rows,
            'failed_rows' => $patientImport->failed_rows,
            'errors' => $patientImport->errors,
        ]);
    }

    /**
     * Descargar el archivo CSV de ejemplo.
     */
    public function downloadExample()
    {
        $path = storage_path('app/examples/pacientes_ejemplo.csv');

        if (!file_exists($path)) {
            abort(404, 'Archivo de ejemplo no encontrado');
        }

        return response()->download($path, 'pacientes_ejemplo.csv');
    }
}
