<x-admin-layout title="Crear Convenio | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Convenios de Seguro',
          'href' => route('admin.insurances.index')
        ],
        [
          'name' => 'Crear'
        ],
    ]">

    <x-wire-card>
        <form id="insurance-form" action="{{ route('admin.insurances.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre de la aseguradora --}}
                <div>
                    <x-input
                        label="Nombre de la Aseguradora"
                        name="name"
                        placeholder="Ingrese el nombre"
                        value="{{ old('name') }}"
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Número de póliza --}}
                <div>
                    <x-input
                        label="Número de Póliza"
                        name="policy_number"
                        placeholder="Ej. GNP-2024-100"
                        value="{{ old('policy_number') }}"
                    />
                    @error('policy_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo de cobertura --}}
                <div>
                    <x-native-select
                        label="Tipo de Cobertura"
                        name="coverage_type"
                        :options="[
                            ['value' => 'Basic', 'label' => 'Básica'],
                            ['value' => 'Full', 'label' => 'Completa'],
                            ['value' => 'Premium', 'label' => 'Premium'],
                        ]"
                        option-label="label"
                        option-value="value"
                        placeholder="Seleccionar tipo"
                        :value="old('coverage_type')"
                    />
                    @error('coverage_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Porcentaje de cobertura --}}
                <div>
                    <x-input
                        label="Porcentaje de Cobertura (%)"
                        name="coverage_percentage"
                        type="number"
                        step="0.01"
                        min="0"
                        max="100"
                        placeholder="Ej. 90.00"
                        value="{{ old('coverage_percentage') }}"
                    />
                    @error('coverage_percentage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono de contacto --}}
                <div>
                    <x-input
                        label="Teléfono de Contacto"
                        name="contact_phone"
                        placeholder="Ej. 55-5227-3999"
                        value="{{ old('contact_phone') }}"
                    />
                    @error('contact_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email de contacto --}}
                <div>
                    <x-input
                        label="Email de Contacto"
                        name="contact_email"
                        type="email"
                        placeholder="Ej. contacto@seguro.com"
                        value="{{ old('contact_email') }}"
                    />
                    @error('contact_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado activo --}}
                <div class="flex items-center mt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700">Convenio Activo</span>
                    </label>
                </div>
            </div>

            {{-- Notas --}}
            <div class="mt-6">
                <x-textarea
                    label="Notas"
                    name="notes"
                    placeholder="Observaciones adicionales..."
                    rows="3"
                >{{ old('notes') }}</x-textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="mt-6 flex justify-end gap-2">
                <x-wire-button href="{{ route('admin.insurances.index') }}">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Cancelar
                </x-wire-button>

                <x-wire-button type="submit">
                    <i class="fa-solid fa-check mr-1"></i> Crear Convenio
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
