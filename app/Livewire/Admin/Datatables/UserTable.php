<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

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
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("No. Identificación", "id_number")
                ->sortable()
                ->searchable(),
            Column::make("Teléfono", "phone")
                ->sortable()
                ->searchable(),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view(
                        'admin.users.actions',
                        ['user' => $row]
                    );
                })
        ];
    }
}
