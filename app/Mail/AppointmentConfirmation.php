<?php

namespace App\Mail;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable para enviar el comprobante de cita médica.
 * Genera un PDF con los datos de la cita y lo adjunta al correo.
 * Se envía tanto al paciente como al doctor.
 */
class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    /**
     * Crear una nueva instancia del mailable.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Sobre del correo (asunto).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Comprobante de Cita Médica - ' . config('app.name'),
        );
    }

    /**
     * Contenido del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_confirmation',
        );
    }

    /**
     * Adjuntar el PDF del comprobante de cita.
     */
    public function attachments(): array
    {
        // Generar el PDF usando la vista appointment_pdf
        $pdf = Pdf::loadView('emails.appointment_pdf', [
            'appointment' => $this->appointment,
        ]);

        return [
            // Adjuntar el PDF generado en memoria
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn() => $pdf->output(),
                'comprobante_cita_' . $this->appointment->id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
