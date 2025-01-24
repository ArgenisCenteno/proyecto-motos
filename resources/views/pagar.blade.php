@extends('layout.app')

@section('content')

<div id="main" class="main">
    <section class="h-100 py-5">
        <div class="container">
            <div class="px-2 row">
                <div class="col-lg-12">
                    @include('flash::message')
                </div>
                <div class="col-md-6 col-6">
                    <h3 class="p-2 bold">Pagar cuenta</h3>
                </div>

            </div>
            <div class="row justify-content-center">

                <div class="col-lg-12 mb-4">
                    <div>

                        <div>
                            <form action="{{route('pagarCuenta')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="metodo" class="form-label"><strong>Método de Pago</strong></label>
                                        <select class="form-select" id="metodo" name="metodo" required>
                                            <option value="" disabled selected>Seleccione un método de pago</option>
                                            <option value="Pago movil">Pago móvil</option>
                                            <option value="Transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="banco_origen" class="form-label"><strong>Banco de Origen</strong></label>
                                        <select class="form-select" id="banco_origen" name="banco_origen" required>
                                            <option value="" disabled selected>Selecciona tu banco de origen</option>
                                            <option value="Banesco">Banesco</option>
                                            <option value="Banco de Venezuela">Banco de Venezuela</option>
                                            <option value="Mercantil">Mercantil</option>
                                            <option value="BBVA Provincial">BBVA Provincial</option>
                                            <option value="Bicentenario">Bicentenario</option>
                                            <option value="Banco Exterior">Banco Exterior</option>
                                            <option value="Banco del Tesoro">Banco del Tesoro</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="banco_destino" class="form-label"><strong>Banco de Destino</strong></label>
                                        <select class="form-select" id="banco_destino" name="banco_destino" required>
                                            <option value="" disabled selected>Selecciona tu banco de destino</option>
                                            <option value="Banesco">Banesco</option>
                                            <option value="Banco de Venezuela">Banco de Venezuela</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="numero_referencia" class="form-label"><strong>Número de Referencia</strong></label>
                                        <input type="text" class="form-control" id="numero_referencia"
                                            name="numero_referencia" maxlength="8" placeholder="55555555"
                                            pattern="\d{8}" title="Debe tener 8 dígitos" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comprobante" class="form-label"> <strong>Recibo de Transferencia / Pago móvil</strong> </label>
                                    <input type="file" class="form-control" id="comprobante" name="comprobante"
                                        required>
                                </div>

                                <div class="table-responsive mb-4">
                                    <table class="table table-striped ">
                                        <thead style="background-color: black !important; color: white; ">
                                            <tr>
                                                <th>Imagen</th>
                                                <th>Nombre del Producto</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carrito as $item)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}"
                                                            style="height: 50px; width: auto;">
                                                    </td>
                                                    <td>{{ $item['nombre'] }}</td>
                                                    <td>{{ number_format($item['precio'], 2) }} Bs</td>
                                                    <td>{{ $item['cantidad'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="fw-bold mb-0">Total:</p>
                                    <p class="text-muted mb-0">{{$total}}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="fw-bold mb-0">Impuesto:</p>
                                    <p class="text-muted mb-0">{{$impuesto}}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="fw-bold mb-0">Monto a Pagar:</p>
                                    <p class="text-muted mb-0">{{$montoTotal}}</p>
                                    <input type="hidden" name="montoTotal" value="{{$montoTotal}}">
                                </div>

                                <button type="submit" class="btn btn-dark w-100 mt-4">Realizar Pago</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@include('layout.script')
<script src="{{asset('js/sweetalert2.js')}}"></script>