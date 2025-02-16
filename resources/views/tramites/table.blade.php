<div class="table-responsive">
<table class="table table-hover" id="tramites-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Usuario</th>
            <th>Estado</th>
          
            <th>Creado En</th>
       
            <th>Acciones</th>
        </tr>
    </thead>
</table>
</div>
@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#tramites-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('tramites.index') }}', // Route to fetch data
            columns: [
                { data: 'id', name: 'id' },
                { data: 'tipo', name: 'tipo' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'user.name', name: 'user.name' }, // Assuming user has a name field
                { data: 'estado', name: 'estado' },
               
                { data: 'fecha', name: 'fecha' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ],
            order: [[0, 'DESC']],
        });
    });

</script>