<x-admin-layout title="Usuarios | Simify" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard')
  ],
  [
    'name' => 'Usuarios'
  ],
]">
@section('action')
  <x-wire-button gray href="{{ route('admin.users.create') }}">
    <i class="fa-solid fa-plus"></i>
    Nuevo
  </x-wire-button>
@endsection

</x-admin-layout>
