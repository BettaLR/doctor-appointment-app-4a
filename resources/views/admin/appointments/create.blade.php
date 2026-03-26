<x-admin-layout title="Nueva Cita | {{ config('app.name') }}" :breadcrumbs="[
        [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard')
        ],
        [
          'name' => 'Citas Médicas',
          'href' => route('admin.appointments.index')
        ],
        [
          'name' => 'Nueva Cita'
        ],
    ]">

    <x-wire-card>
        <form action="{{ route('admin.appointments.store') }}" method="POST">

          @csrf

          <div class="space-y-4">
              <div class="grid lg:grid-cols-2 gap-4">

                {{-- Seleccionar Paciente --}}
                <div>
                  <x-native-select
                    label="Paciente"
                    name="patient_id"
                    :options="$patients->map(fn($p) => ['value' => $p->id, 'label' => $p->user->name . ' (' . $p->user->email . ')'])->toArray()"
                    option-label="label"
                    option-value="value"
                    placeholder="Seleccionar paciente"
                    :value="old('patient_id')"
                  />
                </div>

                {{-- Seleccionar Doctor --}}
                <div>
                  <x-native-select
                    label="Doctor"
                    name="doctor_id"
                    :options="$doctors->map(fn($d) => ['value' => $d->id, 'label' => 'Dr. ' . $d->user->name . ' - ' . ($d->speciality->name ?? 'General')])->toArray()"
                    option-label="label"
                    option-value="value"
                    placeholder="Seleccionar doctor"
                    :value="old('doctor_id')"
                  />
                </div>

                {{-- Fecha y hora de la cita --}}
                <div>
                  <x-input
                    label="Fecha y Hora"
                    name="appointment_date"
                    type="datetime-local"
                    value="{{ old('appointment_date') }}"
                  />
                </div>

              </div>

              {{-- Motivo de consulta --}}
              <div>
                <x-textarea
                  label="Motivo de la consulta"
                  name="reason"
                  placeholder="Describa el motivo de la consulta..."
                  rows="3"
                >{{ old('reason') }}</x-textarea>
              </div>

              {{-- Notas adicionales --}}
              <div>
                <x-textarea
                  label="Notas adicionales (opcional)"
                  name="notes"
                  placeholder="Notas adicionales..."
                  rows="2"
                >{{ old('notes') }}</x-textarea>
              </div>

              {{-- Botones --}}
              <div class="flex justify-end pt-4 gap-2">
                <a href="{{ route('admin.appointments.index') }}">
                    <x-wire-button type="button" flat>
                        Cancelar
                    </x-wire-button>
                </a>
                <x-wire-button type="submit">
                  <i class="fa-solid fa-save mr-1"></i> Guardar Cita
                </x-wire-button>
              </div>

          </div>

        </form>

    </x-wire-card>

</x-admin-layout>
