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

          <div class="space-y-4">
              <div class="grid lg:grid-cols-2 gap-4">
            
                <!-- Nombre -->
                <div>
                  <x-label for="name" value="Nombre" />
                  <x-input id="name" name="name" type="text" class="mt-1 block w-full" 
                    value="{{ old('name') }}" placeholder="Nombre" required />
                  <x-input-error for="name" class="mt-2" />
                </div>
              
                <!-- Email -->
                <div>
                  <x-label for="email" value="Email" />
                  <x-input id="email" name="email" type="email" class="mt-1 block w-full" 
                    value="{{ old('email') }}" placeholder="usuario@email.com" required />
                  <x-input-error for="email" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div>
                  <x-label for="password" value="Contraseña" />
                  <x-input id="password" name="password" type="password" class="mt-1 block w-full" 
                    placeholder="Mínimo 8 caracteres" required />
                  <x-input-error for="password" class="mt-2" />
                </div>
              
                <!-- Confirmar Contraseña -->
                <div>
                  <x-label for="password_confirmation" value="Confirmar Contraseña" />
                  <x-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" 
                    placeholder="Repita la contraseña" required />
                  <x-input-error for="password_confirmation" class="mt-2" />
                </div>

                <!-- Número de ID -->
                <div>
                  <x-label for="id_number" value="Número de ID" />
                  <x-input id="id_number" name="id_number" type="text" class="mt-1 block w-full" 
                    value="{{ old('id_number') }}" placeholder="EJ. ABC123" required />
                  <x-input-error for="id_number" class="mt-2" />
                </div>
              
                <!-- Teléfono -->
                <div>
                  <x-label for="phone" value="Teléfono (opcional)" />
                  <x-input id="phone" name="phone" type="tel" class="mt-1 block w-full" 
                    value="{{ old('phone') }}" placeholder="EJ. 1234567890" />
                  <x-input-error for="phone" class="mt-2" />
                </div>
              
              </div>

              <!-- Dirección (ancho completo) -->
              <div>
                <x-label for="address" value="Dirección (opcional)" />
                <x-input id="address" name="address" type="text" class="mt-1 block w-full" 
                  value="{{ old('address') }}" placeholder="EJ. Calle 123" />
                <x-input-error for="address" class="mt-2" />
              </div>
              
              <!-- Rol -->
              <div>
                <x-label for="role" value="Rol" />
                <select name="role" id="role" required
                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                  <option value="">Seleccionar rol</option>
                  @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                      {{ $role->name }}
                    </option>
                  @endforeach
                </select>
                <x-input-error for="role" class="mt-2" />
                <p class="text-sm text-gray-500 mt-1">
                  Define los permisos y accesos del usuario
                </p>
              </div>

              <div class="flex justify-end pt-4">
                <x-wire-button type="submit">
                  Guardar
                </x-wire-button>
              </div>
              
          </div>

        </form>

    </x-wire-card>

</x-admin-layout>
