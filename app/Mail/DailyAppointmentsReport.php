<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Mailable para el reporte diario de citas médicas.
 * Se envía al administrador con todas las citas del día,
 * y a cada doctor con sus citas programadas.
 */
class DailyAppointmentsReport extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $appointments;
    public string $recipientName;
    public string $reportDate;

    /**
     * Crear una nueva instancia del mailable.
     *
     * @param Collection $appointments  Colección de citas del día
     * @param string     $recipientName Nombre del destinatario (admin o doctor)
     */
    public function __construct(Collection $appointments, string $recipientName)
    {
        $this->appointments = $appointments;
        $this->recipientName = $recipientName;
        $this->reportDate = now()->format('d/m/Y');
    }

    /**
     * Sobre del correo (asunto).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte Diario de Citas - ' . $this->reportDate . ' - ' . config('app.name'),
        );
    }

    /**
     * Contenido del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.daily_report',
        );
    }
}
