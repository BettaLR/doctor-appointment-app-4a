<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;

class PatientTable extends DataTableComponent
{
    //protected $model = Patient::class;

    //Este metodo define el modelo
    public function builder(): Builder
    {
        //Devuelve la relacion con roles
        return Patient::query()
            ->with('user');
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
                ->sortable(),
            Column::make("Email", "user.email")
                ->sortable(),
            Column::make("Numero de id", "user.id_number")
                ->sortable(),
            Column::make("Telefono", "user.phone")
                ->sortable(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view(
                        'admin.patients.actions',
                        ['patient' => $row]
                    );
                })
        ];
    }
}
