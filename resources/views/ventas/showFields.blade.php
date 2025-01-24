<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Venta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-section {
            margin-bottom: 30px;
            border: 1px solid #ccc; /* Add a border to separate sections */
            padding: 15px; /* Add padding around the section */
            border-radius: 8px; /* Rounded corners */
        }

        .form-group {
            margin-bottom: 15px; /* Space between form groups */
        }

        .table-section {
            border: 1px solid #ccc; /* Border around the table */
            border-radius: 8px; /* Rounded corners */
            padding: 15px; /* Padding inside the table section */
            margin-top: 20px; /* Space above the table */
        }

        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Remove double borders */
        }

        th, td {
            border: 1px solid #333; /* Border for table cells */
            padding: 10px; /* Padding inside table cells */
            text-align: center; /* Center text in table cells */
        }

        th {
            background-color: #f2f2f2; /* Light grey background for headers */
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Detalles de la Venta</h2>

        <!-- Información de la Venta -->
        <div class="form-section">
            <form>
                <div class="row">
                    <!-- Cliente -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="cliente">Cliente</label>
                            <input type="text" class="form-control" id="cliente" value="{{ $venta->user->name }}" readonly>
                        </div>
                    </div>

                    <!-- Monto Total -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="monto_total">Monto Total</label>
                            <input type="text" class="form-control" id="monto_total" 
                                   value="{{ number_format($venta->pago->monto_total, 2) }}" readonly>
                        </div>
                    </div>

                    <!-- Monto Neto -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="monto_neto">Monto Neto</label>
                            <input type="text" class="form-control" id="monto_neto" 
                                   value="{{ number_format($venta->pago->monto_neto, 2) }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Estado del Pago -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="status_pago">Estado del Pago</label>
                            <input value="{{ $venta->pago->status }}" readonly class="form-control" />
                        </div>
                    </div>

                    <!-- Fecha de Venta -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="fecha_venta">Fecha de Venta</label>
                            <input type="text" class="form-control" id="fecha_venta" 
                                   value="{{ $venta->created_at->format('Y-m-d') }}" readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Detalles de Venta -->
        <div class="table-section">
            <h4>Lista de Productos</h4>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalleVentas as $detalle)
                        <tr>
                            <td>{{ $detalle->id }}</td>
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

</body>

</html>
