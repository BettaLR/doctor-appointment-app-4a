<x-admin-layout title="Usuarios | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Usuarios',
          'href' => route('admin.users.index')
        ],
        [
          'name' => 'Nuevo'
        ],
    ]">

    <x-wire-card>
        <form action="{{ route('admin.users.store') }}" method="POST">

          @csrf

          <x-input

            label="Nombre" name="name" placeholder="Nombre del usuario" value="{{ old('name') }}">

          </x-input>

          <x-input

            label="Email" name="email" type="email" placeholder="usuario@ejemplo.com" value="{{ old('email') }}">

          </x-input>

          <x-input

            label="Contraseña" name="password" type="password" placeholder="Contraseña">

          </x-input>

          <x-input

            label="Confirmar Contraseña" name="password_confirmation" type="password" placeholder="Confirmar contraseña">

          </x-input>

          <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
            <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
              <option value="">Seleccionar rol</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
              @endforeach
            </select>
          </div>

            <div class="flex justify-end mt-4">

              <x-wire-button type='submit' black>Guardar</x-wire-button>

            </div>
        </form>

    </x-wire-card>

</x-admin-layout>
