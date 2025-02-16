¿
    <table id="vehiculosTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Placa</th>
                <th>Año</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTable will populate this area via AJAX -->
        </tbody>
    </table>
</div>
@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#vehiculosTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('vehiculos.index') }}', // AJAX URL
            order: [[0, 'DESC']], // Ordenar por la primera columna (id) de menor a mayor
            columns: [
                { data: 'id', name: 'id' },
                { data: 'tipo', name: 'tipo' },
                { data: 'marca', name: 'marca' },
                { data: 'modelo', name: 'modelo' },
                { data: 'color', name: 'color' },
                { data: 'placa', name: 'placa' },
                { data: 'anio', name: 'anio' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>

