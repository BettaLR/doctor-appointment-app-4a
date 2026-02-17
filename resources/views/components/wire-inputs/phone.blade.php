{{-- resources/views/components/wire-inputs/phone.blade.php --}}
@props(['name', 'label' => 'Teléfono', 'value' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input
        type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="(###) ###-####"
        maxlength="14"
        {{ $attributes->merge(['class' => 'mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}
        oninput="
            let v = this.value.replace(/\D/g, '').substring(0, 10);
            if (v.length >= 7) {
                this.value = '(' + v.substring(0,3) + ') ' + v.substring(3,6) + '-' + v.substring(6);
            } else if (v.length >= 4) {
                this.value = '(' + v.substring(0,3) + ') ' + v.substring(3);
            } else if (v.length > 0) {
                this.value = '(' + v;
            }
        "
    />
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
