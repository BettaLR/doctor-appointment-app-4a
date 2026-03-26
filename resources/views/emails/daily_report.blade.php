<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario de Citas</title>
    <style>
        /* Estilos del correo de reporte diario */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 650px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        }
        .header {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 8px 0 0;
            opacity: 0.85;
            font-size: 14px;
        }
        .body {
            padding: 30px;
        }
        .greeting {
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 15px;
        }
        table.appointments {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table.appointments th {
            background-color: #059669;
            color: white;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }
        table.appointments td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
            color: #374151;
        }
        table.appointments tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .no-appointments {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-size: 14px;
        }
        .summary {
            background-color: #ecfdf5;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            text-align: center;
            border: 1px solid #a7f3d0;
        }
        .summary p {
            margin: 0;
            color: #065f46;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f9fafb;
            color: #9ca3af;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Encabezado del reporte --}}
        <div class="header">
            <h1>📋 Reporte Diario de Citas</h1>
            <p>{{ $reportDate }} — {{ config('app.name') }}</p>
        </div>

        <div class="body">
            {{-- Saludo al destinatario --}}
            <p class="greeting">
                Hola {{ $recipientName }}, aquí tienes el listado de citas programadas para el día de hoy:
            </p>

            @if($appointments->count() > 0)
                {{-- Tabla con las citas del día --}}
                <table class="appointments">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Paciente</th>
                            <th>Doctor</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $index => $appt)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $appt->patient->user->name }}</td>
                                <td>Dr. {{ $appt->doctor->user->name }}</td>
                                <td>{{ $appt->appointment_date->format('H:i') }}</td>
                                <td>{{ Str::limit($appt->reason, 30) }}</td>
                                <td>{{ ucfirst($appt->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Resumen de citas --}}
                <div class="summary">
                    <p>Total de citas para hoy: {{ $appointments->count() }}</p>
                </div>
            @else
                {{-- Mensaje cuando no hay citas --}}
                <div class="no-appointments">
                    <p>📭 No hay citas programadas para el día de hoy.</p>
                </div>
            @endif
        </div>

        {{-- Pie del correo --}}
        <div class="footer">
            <p>Este reporte fue generado automáticamente por {{ config('app.name') }}.</p>
            <p>Enviado el {{ $reportDate }} a las 08:00 AM</p>
        </div>
    </div>
</body>
</html>
