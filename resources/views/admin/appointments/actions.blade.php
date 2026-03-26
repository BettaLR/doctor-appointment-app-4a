{{-- Botón para eliminar la cita --}}
<div class="flex gap-1">
    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" 
          onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:text-red-700" title="Eliminar">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>
