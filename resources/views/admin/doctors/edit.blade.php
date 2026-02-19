<x-admin-layout title="Doctores | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Doctores',
          'href' => route('admin.doctors.index')
        ],
        [
          'name' => 'Editar'
        ],
    ]">

    {{-- ========== ENCABEZADO: foto + nombre + acciones ========== --}}
    <x-wire-card>
        <div class="flex items-center justify-between">
            {{-- Foto y nombre --}}
            <div class="flex items-center">
                <img
                    src="{{ $doctor->user->profile_photo_url }}"
                    alt="{{ $doctor->user->name }}"
                    class="h-16 w-16 rounded-full object-cover"
                />
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $doctor->user->name }}</h2>
                    <p class="text-sm text-gray-500">Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-2">
                <x-wire-button href="{{ route('admin.doctors.index') }}">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Volver
                </x-wire-button>

                <x-wire-button type="submit" form="doctor-form">
                    <i class="fa-solid fa-check mr-1"></i> Guardar cambios
                </x-wire-button>
            </div>
        </div>
    </x-wire-card>

    {{-- ========== FORMULARIO ========== --}}
    <div class="mt-6">
        <x-wire-card>
            <form id="doctor-form" action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    {{-- Especialidad --}}
                    <div>
                        <x-native-select
                            label="Especialidad"
                            name="speciality_id"
                            :options="$specialities->map(fn($s) => ['value' => $s->id, 'label' => $s->name])->toArray()"
                            option-label="label"
                            option-value="value"
                            placeholder="Seleccionar especialidad"
                            :value="old('speciality_id', $doctor->speciality_id)"
                        />
                        @error('speciality_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Número de licencia médica --}}
                    <div x-data="{ licenseLength: '{{ old('medical_license_number', $doctor->medical_license_number) }}'.length }">
                        <x-input
                            label="Número de licencia médica"
                            name="medical_license_number"
                            placeholder="Ingrese el número de licencia"
                            value="{{ old('medical_license_number', $doctor->medical_license_number) }}"
                            x-on:input="licenseLength = $event.target.value.length"
                            x-bind:class="licenseLength > 8 ? 'border-red-500 ring-red-500' : ''"
                        />
                        <p x-show="licenseLength > 8" class="mt-1 text-sm text-red-500">
                            La licencia no puede tener más de 8 caracteres
                        </p>
                    </div>

                    {{-- Biografía --}}
                    <div>
                        <x-textarea
                            label="Biografía"
                            name="biography"
                            placeholder="Escriba la biografía del doctor..."
                            rows="4"
                        >{{ old('biography', $doctor->biography) }}</x-textarea>
                        @error('biography')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </form>
        </x-wire-card>
    </div>

</x-admin-layout>
