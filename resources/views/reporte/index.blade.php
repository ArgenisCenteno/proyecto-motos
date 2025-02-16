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
                                    <form action="{{ route('reportes.exportarExcel') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="fecha_inicio">Fecha Inicio:</label>
                                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin:</label>
                                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                        </div>
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
                                    <form action="{{ url('exportar-tramites') }}" method="GET">
                                        <div class="form-group">
                                            <label for="start_date">Fecha de inicio:</label>
                                            <input type="date" name="start_date" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">Fecha de fin:</label>
                                            <input type="date" name="end_date" class="form-control" required>
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
                                    <form action="{{ route('usuarios.export') }}" method="GET">
                                        <div class="form-group">
                                            <label for="start_date">Fecha de inicio:</label>
                                            <input type="date" name="start_date" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">Fecha de fin:</label>
                                            <input type="date" name="end_date" class="form-control" required>
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
@endsection
