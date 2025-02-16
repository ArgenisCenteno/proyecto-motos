<div class="table-responsive">
    <table class="table table-hover" id="viajes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehículo</th>
                <th>Usuario</th>
               
                <th>Distancia (km)</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Hora de salida</th>
                <th>Hora de llegada</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/sweetalert2.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#viajes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('viajes.index') }}', // Ruta para obtener los datos
            order: [[0, 'desc']], // Ordenar por la columna 'id' de forma descendente (mayor a menor)
            columns: [
                { data: 'id', name: 'id' },
                { data: 'vehiculo_id', name: 'vehiculo_id' },
                { data: 'usuario', name: 'usuario' },
                { data: 'distancia_km', name: 'distancia_km' },
                { data: 'precio', name: 'precio' },
                { data: 'estado', name: 'estado' },
                { data: 'hora_salida', name: 'hora_salida' },
                { data: 'hora_llegada', name: 'hora_llegada' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>

@endsection
