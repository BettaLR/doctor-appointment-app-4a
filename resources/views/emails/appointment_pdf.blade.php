<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Cita Médica</title>
    <style>
        /* Estilos para el PDF del comprobante */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 26px;
        }
        .header p {
            color: #6b7280;
            margin: 5px 0 0;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            margin-top: 8px;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #2563eb;
        }
        .section h3 {
            color: #1e40af;
            margin: 0 0 10px;
            font-size: 15px;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
        }
        .info-label {
            font-weight: bold;
            color: #4b5563;
            width: 160px;
            font-size: 13px;
        }
        .info-value {
            color: #1f2937;
            font-size: 13px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 11px;
        }
        table.info-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.info-table td {
            padding: 4px 0;
            font-size: 13px;
            vertical-align: top;
        }
        table.info-table td.label {
            font-weight: bold;
            color: #4b5563;
            width: 160px;
        }
        table.info-table td.value {
            color: #1f2937;
        }
    </style>
</head>
<body>

    {{-- Encabezado del comprobante --}}
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>Sistema de Gestión de Citas Médicas</p>
        <span class="badge">COMPROBANTE DE CITA #{{ $appointment->id }}</span>
    </div>

    {{-- Datos del Paciente --}}
    <div class="section">
        <h3>🧑 Datos del Paciente</h3>
        <table class="info-table">
            <tr>
                <td class="label">Nombre:</td>
                <td class="value">{{ $appointment->patient->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Correo electrónico:</td>
                <td class="value">{{ $appointment->patient->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Teléfono:</td>
                <td class="value">{{ $appointment->patient->user->phone ?? 'No registrado' }}</td>
            </tr>
        </table>
    </div>

    {{-- Datos del Doctor --}}
    <div class="section">
        <h3>👨‍⚕️ Datos del Doctor</h3>
        <table class="info-table">
            <tr>
                <td class="label">Doctor:</td>
                <td class="value">Dr. {{ $appointment->doctor->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Especialidad:</td>
                <td class="value">{{ $appointment->doctor->speciality->name ?? 'General' }}</td>
            </tr>
            <tr>
                <td class="label">Cédula profesional:</td>
                <td class="value">{{ $appointment->doctor->medical_license_number ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    {{-- Detalles de la Cita --}}
    <div class="section">
        <h3>📅 Detalles de la Cita</h3>
        <table class="info-table">
            <tr>
                <td class="label">Fecha y hora:</td>
                <td class="value">{{ $appointment->appointment_date->format('d/m/Y \a \l\a\s H:i') }} hrs</td>
            </tr>
            <tr>
                <td class="label">Motivo de consulta:</td>
                <td class="value">{{ $appointment->reason }}</td>
            </tr>
            <tr>
                <td class="label">Estado:</td>
                <td class="value">{{ ucfirst($appointment->status) }}</td>
            </tr>
            @if($appointment->notes)
            <tr>
                <td class="label">Notas:</td>
                <td class="value">{{ $appointment->notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- Pie del comprobante --}}
    <div class="footer">
        <p>Este comprobante fue generado automáticamente por {{ config('app.name') }}.</p>
        <p>Fecha de emisión: {{ now()->format('d/m/Y H:i') }} hrs</p>
    </div>

</body>
</html>
