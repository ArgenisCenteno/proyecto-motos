<div class="table-responsive">
    <table id="sectors-table" class="table table-hover">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Parroquia</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
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
$(document).ready(function() {
    $('#sectors-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('sectores.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nombre', name: 'nombre' },
            { data: 'parroquia', name: 'parroquia' },
            { data: 'estado', name: 'estado' },
            { data: 'fecha', name: 'fecha' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>

<script>
    function confirmarEliminacion(form) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Enviar el formulario si se confirma la acción
            }
        })
    }
</script>
