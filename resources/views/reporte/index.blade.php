@extends('layout.app')
@section('content')
<main id="main" class="main">
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class=" border-0 my-5">
                        <div class="px-2 row">
                            <div class="col-lg-12">
                                @include('flash::message')
                            </div>
                            <div class="col-md-6 col-6">
                                <h3 class="p-2 bold">Consultar Viajes</h3>
                            </div>
                        </div>
                        <div class="">
                            <form action="{{ route('reportes.exportarExcel') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha Fin:</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Exportar Viajes</button>
                            </form>
                        </div>
                        <div class="col-md-6 col-6">
                            <h3 class="p-2 bold">Consultar Cuentas</h3>
                        </div>
                        <div>
                            <form action="{{ route('cuentasPorCobrar.exportarExcel') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha Fin:</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Exportar Cuentas Por Cobrar</button>
                            </form>

                        </div>

                        <div>
                            <div class="col-md-6 col-6">
                                <h3 class="p-2 bold">Consultar Pagos</h3>
                            </div>
                            <form action="{{ route('pagos.exportarExcel') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha Fin:</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Exportar Pagos</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection