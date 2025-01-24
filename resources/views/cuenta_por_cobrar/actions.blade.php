 
    <a href="{{ $editUrl }}" class="btn btn-info btn-sm">Detalles</a>
    
    @if ($status !== 'Pagada' && $status !== 'En proceso')
        <a href="{{ $pagarUrl }}" class="btn btn-success btn-sm">Pagar</a>
    @endif

    @if(Auth::user()->hasRole('superAdmin'))
        <form action="{{ $deleteUrl }}" method="POST" style="display:inline;" class="btn-delete" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cuenta por cobrar?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
        </form>
    @endcan
 
