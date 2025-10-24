<x-admin-layout title="Roles | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard', 
          'route' => route('admin.dashboard')
        ],
        [
          'name' => 'Roles'
        ],
    ]">

        @livewire('admin.datatables.role-table')

</x-admin-layout>