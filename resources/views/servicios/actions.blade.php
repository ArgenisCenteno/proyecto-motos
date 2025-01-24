<!-- resources/views/actions.blade.php -->
<a href="{{ route('servicios.edit', $id) }}" class="btn btn-success btn-sm">Editar</a>

<form action="{{ route('servicios.destroy', $id) }}" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este servicio?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>
