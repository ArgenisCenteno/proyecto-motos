<!-- resources/views/actions.blade.php -->
@if(Auth::user()->hasRole('superAdmin'))
<a href="{{ route('vehiculos.edit', $id) }}" class="btn btn-warning btn-sm">Editar</a>

<form action="{{ route('vehiculos.destroy', $id) }}" method="POST" style="display:inline;" class="btn-delete"  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este vehículo?')";>
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>
@else
<a href="{{ route('vehiculos.edit', $id) }}" class="btn btn-warning btn-sm">Editar</a>

@endif

