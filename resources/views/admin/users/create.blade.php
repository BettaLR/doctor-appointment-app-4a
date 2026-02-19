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
                  <x-input
                    label="Nombre"
                    name="name"
                    placeholder="Nombre del usuario"
                    value="{{ old('name') }}"
                  />
                </div>
              
                <!-- Email -->
                <div>
                  <x-input
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="usuario@email.com"
                    value="{{ old('email') }}"
                  />
                </div>

                <!-- Contraseña -->
                <div>
                  <x-input
                    label="Contraseña"
                    name="password"
                    type="password"
                    placeholder="Mínimo 8 caracteres"
                  />
                </div>
              
                <!-- Confirmar Contraseña -->
                <div>
                  <x-input
                    label="Confirmar Contraseña"
                    name="password_confirmation"
                    type="password"
                    placeholder="Repita la contraseña"
                  />
                </div>

                <!-- Número de ID -->
                <div>
                  <x-input
                    label="Número de ID"
                    name="id_number"
                    placeholder="EJ. ABC123"
                    value="{{ old('id_number') }}"
                  />
                </div>
              
                <!-- Teléfono -->
                <div>
                  <x-input
                    label="Teléfono (opcional)"
                    name="phone"
                    type="tel"
                    placeholder="EJ. 1234567890"
                    value="{{ old('phone') }}"
                  />
                </div>
              
              </div>

              <!-- Dirección (ancho completo) -->
              <div>
                <x-input
                  label="Dirección (opcional)"
                  name="address"
                  placeholder="EJ. Calle 123"
                  value="{{ old('address') }}"
                />
              </div>
              
              <!-- Rol -->
              <div>
                <x-native-select
                  label="Rol"
                  name="role"
                  :options="$roles->map(fn($r) => ['value' => $r->id, 'label' => $r->name])->toArray()"
                  option-label="label"
                  option-value="value"
                  placeholder="Seleccionar rol"
                  :value="old('role')"
                />
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
