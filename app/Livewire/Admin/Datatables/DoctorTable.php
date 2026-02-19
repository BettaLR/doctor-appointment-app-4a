<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;

class DoctorTable extends DataTableComponent
{
    //Este metodo define el modelo
    public function builder(): Builder
    {
        //Devuelve la relacion con user y speciality
        return Doctor::query()
            ->with('user', 'speciality');
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
            Column::make("Nombre", "user.name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "user.email")
                ->sortable()
                ->searchable(),
            Column::make("Especialidad", "speciality.name")
                ->sortable()
                ->format(fn($value) => $value ?? 'N/A'),
            Column::make("Licencia", "medical_license_number")
                ->sortable()
                ->searchable()
                //maximo de caracteres en la licencia medica: 8
                ->format(function ($value) {
                    if (empty($value)) {
                        return 'N/A';
                    }
                    // Si la licencia tiene más de 8 caracteres, se muestra en rojo
                    if (strlen($value) > 8) {
                        return '<span style="color: red; font-weight: bold;" title="La licencia excede 8 caracteres">' . e($value) . '</span>';
                    }
                    return e($value);
                })
                ->html(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view(
                        'admin.doctors.actions',
                        ['doctor' => $row]
                    );
                })
        ];
    }
}
