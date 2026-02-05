<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Role;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

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
            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d/m/Y');
                }),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view(
                        'admin.roles.actions',
                        ['role' => $row]
                    );
                })
        ];
    }
}