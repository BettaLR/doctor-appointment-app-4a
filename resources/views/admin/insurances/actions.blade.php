<div class="flex items-center space-x-2">
    <x-wire-button href="{{ route('admin.insurances.edit', $insurance) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    <form action="{{ route('admin.insurances.destroy', $insurance) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este convenio?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800 px-2 py-1">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>
