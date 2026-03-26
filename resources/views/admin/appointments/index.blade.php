<x-admin-layout title="Citas Médicas | {{ config('app.name') }}" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Citas Médicas',
        ],
    ]">

    {{-- Botón para crear nueva cita --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.appointments.create') }}">
            <x-wire-button>
                <i class="fa-solid fa-plus mr-1"></i> Nueva Cita
            </x-wire-button>
        </a>
    </div>

    {{-- Tabla de citas médicas --}}
    @livewire('admin.datatables.appointment-table')

</x-admin-layout>
