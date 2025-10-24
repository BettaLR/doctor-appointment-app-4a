<x-admin-layout title="Roles | Forthealth"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles'
    ],
]">
    <livewire:admin.datatables.role-table />
</x-admin-layout>
