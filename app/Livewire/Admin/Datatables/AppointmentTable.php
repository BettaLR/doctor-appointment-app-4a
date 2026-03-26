<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

/**
 * Tabla Livewire para mostrar las citas médicas.
 * Usa rappasoft/laravel-livewire-tables para el datatable.
 */
class AppointmentTable extends DataTableComponent
{
    // Construcción de la consulta con relaciones cargadas
    public function builder(): Builder
    {
        return Appointment::query()
            ->with(['patient.user', 'doctor.user']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Paciente", "patient.user.name")
                ->sortable()
                ->searchable(),
            Column::make("Doctor", "doctor.user.name")
                ->sortable()
                ->searchable(),
            Column::make("Fecha", "appointment_date")
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d/m/Y H:i');
                }),
            Column::make("Motivo", "reason")
                ->sortable()
                ->format(function ($value) {
                    return \Illuminate\Support\Str::limit($value, 30);
                }),
            Column::make("Estado", "status")
                ->sortable()
                ->format(function ($value) {
                    return ucfirst($value);
                }),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view(
                        'admin.appointments.actions',
                        ['appointment' => $row]
                    );
                })
        ];
    }
}
