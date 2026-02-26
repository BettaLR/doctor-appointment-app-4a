<x-admin-layout title="Pacientes | Simify" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Pacientes',
          'href' => route('admin.patients.index')
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
                    src="{{ $patient->user->profile_photo_url }}"
                    alt="{{ $patient->user->name }}"
                    class="h-16 w-16 rounded-full object-cover"
                />
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $patient->user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $patient->user->email }}</p>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-2">
                <x-wire-button href="{{ route('admin.patients.index') }}">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Volver
                </x-wire-button>

                <x-wire-button type="submit" form="patient-form">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar
                </x-wire-button>
            </div>
        </div>
    </x-wire-card>

    {{-- ========== PESTAÑAS (Componentes reutilizables + Alpine.js) ========== --}}
    <div class="mt-6">
        <x-tabs :active="$initialTab">
            {{-- Menú de pestañas --}}
            <x-slot name="header">
                <x-tab-link tab="personal">
                    <i class="fa-solid fa-user mr-1"></i> Datos Personales
                </x-tab-link>

                <x-tab-link tab="antecedentes" :error="$errors->hasAny(['allergies','chronic_conditions','surgical_history','family_history'])">
                    <i class="fa-solid fa-notes-medical mr-1"></i> Antecedentes
                </x-tab-link>

                <x-tab-link tab="general" :error="$errors->hasAny(['blood_type_id','observations'])">
                    <i class="fa-solid fa-circle-info mr-1"></i> Información General
                </x-tab-link>

                <x-tab-link tab="emergencia" :error="$errors->hasAny(['emergency_contact_name','emergency_contact_phone','emergency_contact_relationship'])">
                    <i class="fa-solid fa-phone mr-1"></i> Contacto de Emergencia
                </x-tab-link>
            </x-slot>

            {{-- Formulario PUT --}}
            <form id="patient-form" action="{{ route('admin.patients.update', $patient) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ===== TAB 1: Datos Personales ===== --}}
                <x-tab-content tab="personal">
                    <x-wire-card>
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Datos Personales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input
                                    label="Nombre"
                                    name="name"
                                    placeholder="Nombre del paciente"
                                    value="{{ old('name', $patient->user->name) }}"
                                />
                            </div>
                            <div>
                                <x-input
                                    label="Correo electrónico"
                                    name="email"
                                    type="email"
                                    placeholder="correo@ejemplo.com"
                                    value="{{ old('email', $patient->user->email) }}"
                                />
                            </div>
                            <div>
                                <x-input
                                    label="No. Identificación"
                                    name="id_number"
                                    placeholder="EJ. ABC123"
                                    value="{{ old('id_number', $patient->user->id_number) }}"
                                />
                            </div>
                            <div>
                                <x-input
                                    label="Teléfono"
                                    name="phone"
                                    type="tel"
                                    placeholder="EJ. 1234567890"
                                    value="{{ old('phone', $patient->user->phone) }}"
                                />
                            </div>
                            <div class="md:col-span-2">
                                <x-input
                                    label="Dirección"
                                    name="address"
                                    placeholder="Dirección del paciente"
                                    value="{{ old('address', $patient->user->address) }}"
                                />
                            </div>
                        </div>
                    </x-wire-card>
                </x-tab-content>

                {{-- ===== TAB 2: Antecedentes ===== --}}
                <x-tab-content tab="antecedentes">
                    <x-wire-card>
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Antecedentes Médicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="allergies" class="block text-sm font-medium text-gray-700">Alergias</label>
                                <textarea name="allergies" id="allergies" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Ej: Penicilina, Polen...">{{ old('allergies', $patient->allergies) }}</textarea>
                                @error('allergies')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="chronic_conditions" class="block text-sm font-medium text-gray-700">Condiciones Crónicas</label>
                                <textarea name="chronic_conditions" id="chronic_conditions" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Ej: Diabetes, Hipertensión...">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                                @error('chronic_conditions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="surgical_history" class="block text-sm font-medium text-gray-700">Historial Quirúrgico</label>
                                <textarea name="surgical_history" id="surgical_history" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Ej: Apendicectomía 2020...">{{ old('surgical_history', $patient->surgical_history) }}</textarea>
                                @error('surgical_history')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="family_history" class="block text-sm font-medium text-gray-700">Antecedentes Familiares</label>
                                <textarea name="family_history" id="family_history" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Ej: Cáncer, Cardiopatías...">{{ old('family_history', $patient->family_history) }}</textarea>
                                @error('family_history')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-wire-card>
                </x-tab-content>

                {{-- ===== TAB 3: Información General ===== --}}
                <x-tab-content tab="general">
                    <x-wire-card>
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Información General</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="blood_type_id" class="block text-sm font-medium text-gray-700">Tipo de Sangre</label>
                                <select name="blood_type_id" id="blood_type_id"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Seleccionar tipo de sangre</option>
                                    @foreach($blood_types as $bt)
                                        <option value="{{ $bt->id }}" {{ old('blood_type_id', $patient->blood_type_id) == $bt->id ? 'selected' : '' }}>
                                            {{ $bt->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blood_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4 md:col-span-2">
                                <label for="observations" class="block text-sm font-medium text-gray-700">Observaciones</label>
                                <textarea name="observations" id="observations" rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Observaciones generales del paciente...">{{ old('observations', $patient->observations) }}</textarea>
                                @error('observations')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-wire-card>
                </x-tab-content>

                {{-- ===== TAB 4: Contacto de Emergencia ===== --}}
                <x-tab-content tab="emergencia">
                    <x-wire-card>
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Contacto de Emergencia</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Nombre del Contacto</label>
                                <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Nombre completo" />
                                @error('emergency_contact_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-wire-inputs.phone
                                name="emergency_contact_phone"
                                label="Teléfono de Emergencia"
                                :value="$patient->emergency_contact_phone"
                            />

                            <div class="mb-4">
                                <label for="emergency_contact_relationship" class="block text-sm font-medium text-gray-700">Parentesco</label>
                                <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship"
                                    value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Ej: Madre, Esposo(a)..." />
                                @error('emergency_contact_relationship')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-wire-card>
                </x-tab-content>

            </form>
        </x-tabs>
    </div>

</x-admin-layout>
