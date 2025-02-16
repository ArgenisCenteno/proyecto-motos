<!-- resources/views/actions.blade.php -->
 @if(Auth::user()->hasRole('superAdmin'))
 <a href="{{ route('tramites.edit', $id) }}" class="btn btn-success btn-sm">Editar</a>

<form action="{{ route('tramites.destroy', $id) }}" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este trámite?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>

 @else
 <a href="{{ route('tramites.edit', $id) }}" class="btn btn-info btn-sm">Detalles</a>

 @endif   
