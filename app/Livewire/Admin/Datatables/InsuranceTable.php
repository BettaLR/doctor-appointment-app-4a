<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Insurance;
use Illuminate\Database\Eloquent\Builder;

class InsuranceTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Insurance::query();
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
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("No. Póliza", "policy_number")
                ->sortable()
                ->searchable()
                ->format(fn($value) => $value ?? 'N/A'),
            Column::make("Cobertura", "coverage_type")
                ->sortable()
                ->format(fn($value) => $value ?? 'N/A'),
            Column::make("Porcentaje", "coverage_percentage")
                ->sortable()
                ->format(fn($value) => $value !== null ? $value . '%' : 'N/A'),
            Column::make("Estado", "is_active")
                ->sortable()
                ->format(function ($value) {
                    if ($value) {
                        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>';
                    }
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>';
                })
                ->html(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view(
                        'admin.insurances.actions',
                        ['insurance' => $row]
                    );
                }),
        ];
    }
}
