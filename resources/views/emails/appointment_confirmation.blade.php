<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Cita Médica</title>
    <style>
        /* Estilos del correo de confirmación */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
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
        .info-card {
            background-color: #eff6ff;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #2563eb;
        }
        .info-card h3 {
            color: #1e40af;
            margin: 0 0 10px;
            font-size: 14px;
        }
        .info-card p {
            margin: 4px 0;
            color: #374151;
            font-size: 13px;
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
        {{-- Encabezado del correo --}}
        <div class="header">
            <h1>✅ Cita Médica Confirmada</h1>
            <p>{{ config('app.name') }}</p>
        </div>

        <div class="body">
            {{-- Saludo personalizado --}}
            <p class="greeting">
                Estimado/a, le informamos que se ha registrado una cita médica en nuestro sistema.
            </p>

            {{-- Tarjeta con datos de la cita --}}
            <div class="info-card">
                <h3>📅 Detalles de la Cita</h3>
                <p><strong>Paciente:</strong> {{ $appointment->patient->user->name }}</p>
                <p><strong>Doctor:</strong> Dr. {{ $appointment->doctor->user->name }}</p>
                <p><strong>Especialidad:</strong> {{ $appointment->doctor->speciality->name ?? 'General' }}</p>
                <p><strong>Fecha:</strong> {{ $appointment->appointment_date->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ $appointment->appointment_date->format('H:i') }} hrs</p>
                <p><strong>Motivo:</strong> {{ $appointment->reason }}</p>
            </div>

            <p style="color: #6b7280; font-size: 13px;">
                Adjunto a este correo encontrará el comprobante de la cita en formato PDF.
            </p>
        </div>

        {{-- Pie del correo --}}
        <div class="footer">
            <p>Este correo fue enviado automáticamente por {{ config('app.name') }}.</p>
            <p>Por favor, no responda a este mensaje.</p>
        </div>
    </div>
</body>
</html>
