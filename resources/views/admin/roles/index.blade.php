<x-admin-layout title="Roles | Simify" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard')
  ],
  [
    'name' => 'Roles'
  ],
]">
@section('action')
  <x-wire-button gray href="{{ route('admin.roles.create') }}">
    <i class="fa-solid fa-plus"></i>
    Nuevo
  </x-wire-button>
@endsection

 @livewire('admin.datatables.role-table')

</x-admin-layout>
