<!-- resources/views/actions.blade.php -->
<a href="{{ route('usuarios.edit', $id) }}" class="btn btn-success btn-sm">Editar</a>

<form action="{{ route('usuarios.destroy', $id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>
