<x-admin-layout title="Roles | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Roles',
          'href' => route('admin.roles.index')
        ],
        [
          'name' => 'Nuevo'
        ],
    ]">

    <x-wire-card>
        <form action="{{ route('admin.roles.store') }}" method="POST">
          
          @csrf

          <x-input 

            label="Nombre" name="name" placeholder="Nombre del rol" value="{{ old('name') }}">

          </x-input>

            <div class="flex justify-end mt-4"> 

              <x-wire-button type='submit' black>Guardar</x-wire-button>

            </div>
        </form>

    </x-wire-card>
    
</x-admin-layout>
