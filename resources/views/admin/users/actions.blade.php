<div class="flex items-center space-x-2">
    <x-wire-button href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800">
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    @if($user->id === auth()->id())
        {{-- Si es el usuario actual, mostrar SweetAlert de error --}}
        <x-wire-button type="button" red xs onclick="Swal.fire({
            icon: 'error',
            title: 'Acción no permitida',
            text: 'No puedes eliminar tu propio usuario'
        })">
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    @else
        {{-- Si es otro usuario, permitir eliminar --}}
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <x-wire-button type="submit" red xs>
                <i class="fa-solid fa-trash"></i>
            </x-wire-button>
        </form>
    @endif

</div>
