@extends('layout.app')

@section('content')


<main id="main" class="main"> 
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 my-5">
                        <div class="px-2 row">
                            <div class="col-lg-12">
                                @include('flash::message')
                            </div>
                            <div class="col-md-6 col-6">
                                <h3 class="p-2 bold">Notificaciones</h3>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                            </div>
                        </div>
                        <div class="card-body">

                        <table class="table mt-3">
    <thead>
        <tr>
            <th>Notificación</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($notificaciones as $notificacion)
            <tr class="{{ $notificacion->read_at ? '' : 'table-light' }}">
                <td>
                    <a href="{{ $notificacion->data['url'] }}">
                        {{ $notificacion->data['message'] ?? 'Notificación' }}
                    </a>
                </td>
                <td>
                    @if(isset($notificacion->data['type']))
                        <span class="badge bg-secondary">{{ $notificacion->data['type'] }}</span>
                    @endif
                </td>
                <td>
                    <span class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</span>
                </td>
                <td>
                    <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay notificaciones.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection