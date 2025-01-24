<a href="{{ route('viajes.edit', $row->id) }}" class="btn btn-success btn-sm">Detalles</a>

<form action="{{ route('viajes.cancelar', $row->id) }}" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm('¿Estás seguro de que deseas cancelar este viaje?');">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-warning btn-sm">Cancelar</button>
</form>

@if(auth()->user()->hasRole('superAdmin'))
    <form action="{{ route('viajes.destroy', $row->id) }}" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este viaje?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    </form>
@endif
