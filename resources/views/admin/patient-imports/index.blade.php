<x-admin-layout title="Importar Pacientes | {{ config('app.name') }}" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Importar Pacientes',
        ],
    ]">

    <div class="space-y-6">

        {{-- ================================== --}}
        {{-- Tarjeta de carga de archivo --}}
        {{-- ================================== --}}
        <x-wire-card>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    <i class="fa-solid fa-file-import mr-2"></i> Importación Masiva de Pacientes
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Sube un archivo CSV con los datos de los pacientes. El procesamiento se realizará en segundo plano.
                </p>
            </div>

            <form action="{{ route('admin.patient-imports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    {{-- Input de archivo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Archivo CSV
                        </label>
                        <input
                            type="file"
                            name="file"
                            accept=".csv,.txt"
                            required
                            class="block w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-blue-50 file:text-blue-700
                                   hover:file:bg-blue-100
                                   dark:file:bg-gray-700 dark:file:text-gray-200
                                   dark:text-gray-400
                                   cursor-pointer"
                        />
                        @error('file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">Formatos aceptados: .csv — Máximo 10 MB</p>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center gap-3">
                        <x-wire-button type="submit">
                            <i class="fa-solid fa-upload mr-1"></i> Subir e Importar
                        </x-wire-button>

                        <a href="{{ route('admin.patient-imports.download-example') }}"
                           class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 underline">
                            <i class="fa-solid fa-download mr-1"></i> Descargar CSV de ejemplo
                        </a>
                    </div>
                </div>
            </form>

            {{-- Formato esperado --}}
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    📋 Columnas esperadas en el CSV:
                </h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono break-all">
                    nombre, email, telefono, direccion, id_number, tipo_sangre, alergias,
                    condiciones_cronicas, historial_quirurgico, historial_familiar, observaciones,
                    contacto_emergencia_nombre, contacto_emergencia_telefono, contacto_emergencia_parentesco
                </p>
            </div>
        </x-wire-card>

        {{-- ================================== --}}
        {{-- Historial de importaciones --}}
        {{-- ================================== --}}
        <x-wire-card>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> Historial de Importaciones
                </h3>
            </div>

            @if($imports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Archivo</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Progreso</th>
                                <th class="px-4 py-3">Exitosos</th>
                                <th class="px-4 py-3">Fallidos</th>
                                <th class="px-4 py-3">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($imports as $import)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" id="import-row-{{ $import->id }}">
                                    <td class="px-4 py-3">{{ $import->id }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                        <i class="fa-solid fa-file-csv text-green-500 mr-1"></i>
                                        {{ $import->file_name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'procesando' => 'bg-blue-100 text-blue-800',
                                                'completado' => 'bg-green-100 text-green-800',
                                                'fallido' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusIcons = [
                                                'pendiente' => 'fa-clock',
                                                'procesando' => 'fa-spinner fa-spin',
                                                'completado' => 'fa-check-circle',
                                                'fallido' => 'fa-times-circle',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$import->status] ?? '' }}"
                                              id="status-badge-{{ $import->id }}">
                                            <i class="fa-solid {{ $statusIcons[$import->status] ?? '' }}"></i>
                                            <span id="status-text-{{ $import->id }}">{{ ucfirst($import->status) }}</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($import->total_rows > 0)
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                                @php
                                                    $progress = round((($import->processed_rows + $import->failed_rows) / $import->total_rows) * 100);
                                                @endphp
                                                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                                                     style="width: {{ $progress }}%"
                                                     id="progress-bar-{{ $import->id }}">
                                                </div>
                                            </div>
                                            <span class="text-xs" id="progress-text-{{ $import->id }}">
                                                {{ $import->processed_rows + $import->failed_rows }} / {{ $import->total_rows }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400" id="progress-text-{{ $import->id }}">
                                                Esperando...
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-green-600 font-semibold" id="processed-{{ $import->id }}">
                                        {{ $import->processed_rows }}
                                    </td>
                                    <td class="px-4 py-3 text-red-600 font-semibold" id="failed-{{ $import->id }}">
                                        {{ $import->failed_rows }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        {{ $import->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>

                                {{-- Mostrar errores si existen --}}
                                @if($import->errors && count($import->errors) > 0)
                                    <tr class="bg-red-50 dark:bg-red-900/20">
                                        <td colspan="7" class="px-4 py-2">
                                            <details class="text-xs">
                                                <summary class="text-red-600 cursor-pointer font-medium">
                                                    Ver {{ count($import->errors) }} error(es)
                                                </summary>
                                                <ul class="mt-1 space-y-1 text-red-500">
                                                    @foreach($import->errors as $error)
                                                        <li>
                                                            <strong>Fila {{ $error['fila'] }}:</strong>
                                                            {{ $error['error'] }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </details>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fa-solid fa-inbox text-4xl mb-2"></i>
                    <p>No hay importaciones registradas</p>
                </div>
            @endif
        </x-wire-card>
    </div>

    {{-- ================================== --}}
    {{-- JavaScript: Polling para progreso --}}
    {{-- ================================== --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Buscar importaciones activas (pendiente o procesando)
            const activeImports = @json($imports->whereIn('status', ['pendiente', 'procesando'])->pluck('id'));

            activeImports.forEach(function (importId) {
                pollImportStatus(importId);
            });

            // Función para consultar el estado de una importación cada 2 segundos
            function pollImportStatus(importId) {
                const interval = setInterval(function () {
                    fetch(`/admin/patient-imports/${importId}/status`)
                        .then(r => r.json())
                        .then(data => {
                            // Actualizar el texto de estado
                            const statusText = document.getElementById(`status-text-${importId}`);
                            if (statusText) {
                                statusText.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                            }

                            // Actualizar contadores
                            const processed = document.getElementById(`processed-${importId}`);
                            if (processed) processed.textContent = data.processed_rows;

                            const failed = document.getElementById(`failed-${importId}`);
                            if (failed) failed.textContent = data.failed_rows;

                            // Actualizar barra de progreso
                            if (data.total_rows > 0) {
                                const progress = Math.round(((data.processed_rows + data.failed_rows) / data.total_rows) * 100);
                                const progressBar = document.getElementById(`progress-bar-${importId}`);
                                if (progressBar) progressBar.style.width = progress + '%';

                                const progressText = document.getElementById(`progress-text-${importId}`);
                                if (progressText) {
                                    progressText.textContent = (data.processed_rows + data.failed_rows) + ' / ' + data.total_rows;
                                }
                            }

                            // Detener polling cuando termine
                            if (data.status === 'completado' || data.status === 'fallido') {
                                clearInterval(interval);
                                // Recargar la página para mostrar errores si hubo
                                setTimeout(() => location.reload(), 1000);
                            }
                        })
                        .catch(() => clearInterval(interval));
                }, 2000);
            }
        });
    </script>
    @endpush

</x-admin-layout>
