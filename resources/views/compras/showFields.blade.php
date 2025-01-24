<div class="container">
    <form>
        <div class="row mb-4">
            <!-- Proveedor -->
            <div class="col-md-4 mb-3">
                <label for="cliente" class="form-label">Proveedor</label>
                <input type="text" class="form-control" id="cliente" value="{{ $compra->proveedor->razon_social }}" readonly>
            </div>

            <!-- Monto Total -->
            <div class="col-md-4 mb-3">
                <label for="monto_total" class="form-label">Monto Total</label>
                <input type="text" class="form-control" id="monto_total" value="{{ number_format($compra->pago->monto_total, 2) }}" readonly>
            </div>

            <!-- Monto Neto -->
            <div class="col-md-4 mb-3">
                <label for="monto_neto" class="form-label">Monto Neto</label>
                <input type="text" class="form-control" id="monto_neto" value="{{ number_format($compra->pago->monto_neto, 2) }}" readonly>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Usuario -->
            <div class="col-md-4 mb-3">
                <label for="vendedor" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="vendedor" value="{{ $compra->user->name }}" readonly>
            </div>

            <!-- Estado del Pago -->
            <div class="col-md-4 mb-3">
                <label for="status_pago" class="form-label">Estado del Pago</label>
                <input type="text" class="form-control" id="status_pago" value="{{ $compra->pago->status }}" readonly>
            </div>

            <!-- Fecha de compra -->
            <div class="col-md-4 mb-3">
                <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                <input type="text" class="form-control" id="fecha_compra" value="{{ $compra->created_at->format('Y-m-d') }}" readonly>
            </div>
        </div>
    </form>

    <!-- Detalles de la compra -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Detalles de la Compra</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagen</th> <!-- Added column for product images -->
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detallecompras as $detalle)
                    <tr>
                        <td>{{ $detalle->id }}</td>
                        <td>
                            @if($detalle->producto->imagenes->isNotEmpty())
                                <img src="{{ asset($detalle->producto->imagenes->first()->url) }}" alt="{{ $detalle->producto->nombre }}" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ number_format($detalle->neto, 2) }}</td>
                        <td>{{ number_format($detalle->impuesto, 2) }}</td>
                        <td>{{ number_format($detalle->impuesto + $detalle->neto, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
