@extends('layout.app')
@section('content')
    <main id="main" class="main">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="border-0 my-5">
                            <div class="px-2 row">
                                <div class="col-lg-12">
                                    @include('flash::message')
                                </div>
                                <div class="col-md-12">
                                    <h3 class="p-2 bold">Generación de Reportes</h3>
                                </div>
                            </div>

                            <!-- Reporte de Viajes -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-car-front"></i> Consultar Viajes
                                    </h5> <br>
                                    <p class="text-muted text-right">Exporta los viajes registrados entre las fechas seleccionadas.</p>
                                    <br>
                                    <form id="reportesForm" action="{{ route('reportes.exportarExcel') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="fecha_inicio">Fecha Inicio:</label>
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin:</label>
                                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                        </div>
                                        <div id="error_message" class="text-danger"></div>
                                        <button type="submit" class="btn btn-primary">Exportar Viajes</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Reporte de Cuentas Por Cobrar -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-wallet"></i> Consultar Cuentas
                                    </h5> <br>
                                    <p class="text-muted text-right">Exporta las cuentas por cobrar entre las fechas seleccionadas.</p>
                                    <br>
                                    <form action="{{ route('cuentasPorCobrar.exportarExcel') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="fecha_inicio">Fecha Inicio:</label>
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin:</label>
                                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Exportar Cuentas Por Cobrar</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Reporte de Pagos -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-credit-card"></i> Consultar Pagos
                                    </h5> <br>
                                    <p class="text-muted text-right">Exporta los pagos registrados entre las fechas seleccionadas.</p>
                                    <br>
                                    <form action="{{ route('pagos.exportarExcel') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="fecha_inicio">Fecha Inicio:</label>
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin:</label>
                                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Exportar Pagos</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Reporte de Trámites -->
                            <div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-file-earmark-check"></i> Consultar Trámites
        </h5> <br>
        <p class="text-muted text-right">Exporta los trámites registrados entre las fechas seleccionadas.</p>
        <br>
        <form action="{{ url('exportar-tramites') }}" method="GET" id="form-tramites">
            <div class="form-group">
                <label for="start_date">Fecha de inicio:</label>
                <input type="date" name="start_date" class="form-control" id="start_date_tramites" required>
            </div>
            <div class="form-group">
                <label for="end_date">Fecha de fin:</label>
                <input type="date" name="end_date" class="form-control" id="end_date_tramites" required>
            </div>
            <button type="submit" class="btn btn-primary">Exportar Trámites</button>
        </form>
    </div>
</div>

<!-- Reporte de Usuarios -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-person"></i> Consultar Usuarios
        </h5> <br>
        <p class="text-muted text-right">Exporta los usuarios registrados entre las fechas seleccionadas.</p>
        <br>
        <form action="{{ route('usuarios.export') }}" method="GET" id="form-usuarios">
            <div class="form-group">
                <label for="start_date">Fecha de inicio:</label>
                <input type="date" name="start_date" class="form-control" id="start_date_usuarios" required>
            </div>
            <div class="form-group">
                <label for="end_date">Fecha de fin:</label>
                <input type="date" name="end_date" class="form-control" id="end_date_usuarios" required>
            </div>
            <button type="submit" class="btn btn-primary">Exportar Usuarios</button>
        </form>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fechaInicio = document.getElementById("fecha_inicio");
        const fechaFin = document.getElementById("fecha_fin");
        const errorMessage = document.getElementById("error_message");

        // Establecer la fecha máxima de "fecha_fin" como la fecha de hoy
        const hoy = new Date();
        const fechaHoy = hoy.toISOString().split('T')[0];
        fechaFin.max = fechaHoy;

        // Función de validación para las fechas
        function validarFechas() {
            let mensajeError = "";

            // Comprobar si la fecha de inicio es mayor que la fecha de fin
            if (fechaInicio.value > fechaFin.value) {
                mensajeError = "La fecha de inicio no puede ser mayor que la fecha de fin.";
            }
            // Comprobar si la fecha de fin es mayor que hoy
            else if (fechaFin.value > fechaHoy) {
                mensajeError = "La fecha de fin no puede ser mayor a la fecha actual.";
            }

            if (mensajeError) {
                errorMessage.textContent = mensajeError;
                return false;
            } else {
                errorMessage.textContent = "";
                return true;
            }
        }

        // Validación al cambiar las fechas
        fechaInicio.addEventListener("change", function() {
            validarFechas();
        });

        fechaFin.addEventListener("change", function() {
            validarFechas();
        });

        // Enviar formulario por AJAX si las fechas son válidas
        const reportesForm = document.getElementById("reportesForm");
        reportesForm.addEventListener("submit", function(event) {
            event.preventDefault();

            if (validarFechas()) {
                const formData = new FormData(reportesForm);

                fetch(reportesForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Procesar los datos de respuesta (ej. mostrar mensaje de éxito)
                    console.log(data);
                    // Aquí puedes agregar código para mostrar un mensaje o redirigir a otra página
                })
                .catch(error => console.error('Error:', error));
            } else {
                alert("Las fechas no son válidas.");
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Función para validar las fechas
        function validateDates(startDate, endDate) {
            // Obtener fecha actual
            var currentDate = new Date();
            // Obtener los valores de las fechas de inicio y fin
            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);

            // Comprobar si la fecha de inicio es mayor que la fecha de fin
            if (startDateObj > endDateObj) {
                return { valid: false, message: 'La fecha de inicio no puede ser mayor a la fecha de fin.' };
            }

            // Comprobar si la fecha de fin es mayor a hoy
            if (endDateObj > currentDate) {
                return { valid: false, message: 'La fecha de fin no puede ser mayor a la fecha actual.' };
            }

            return { valid: true };
        }

        // Validación para el formulario de Trámites
        $('#form-tramites').on('submit', function(event) {
            var startDate = $('#start_date_tramites').val();
            var endDate = $('#end_date_tramites').val();

            var validation = validateDates(startDate, endDate);
            if (!validation.valid) {
                event.preventDefault();
                alert(validation.message);
            }
        });

        // Validación para el formulario de Usuarios
        $('#form-usuarios').on('submit', function(event) {
            var startDate = $('#start_date_usuarios').val();
            var endDate = $('#end_date_usuarios').val();

            var validation = validateDates(startDate, endDate);
            if (!validation.valid) {
                event.preventDefault();
                alert(validation.message);
            }
        });

        // Establecer la fecha máxima de "end_date" a hoy
        var today = new Date().toISOString().split('T')[0];
        $('#end_date_tramites').attr('max', today);
        $('#end_date_usuarios').attr('max', today);
    });
</script>

    @endsection
@endsection
