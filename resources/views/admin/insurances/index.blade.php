<x-admin-layout title="Convenios de Seguro | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Convenios de Seguro',
        ],
    ]">

    <div class="mb-4 flex justify-end">
        <x-wire-button href="{{ route('admin.insurances.create') }}">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo Convenio
        </x-wire-button>
    </div>

    @livewire('admin.datatables.insurance-table')
</x-admin-layout>
