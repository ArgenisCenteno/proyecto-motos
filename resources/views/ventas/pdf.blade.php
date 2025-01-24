<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Venta - Suptrima</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%; /* Adjust the width as needed */
            margin: 20px auto; /* Center the container and add vertical margin */
            text-align: center; /* Center the text */
        }

        header {
            margin-bottom: 20px; /* Space below the header */
        }

        h2, h4, p {
            margin: 10px 0; /* Space around headings and paragraphs */
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Three equal columns */
            gap: 15px; /* Space between grid items */
            margin-bottom: 20px; /* Space below the grid */
            text-align: left; /* Align text to the left within grid items */
        }

        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Remove double borders */
            margin: 20px 0; /* Space above and below the table */
        }

        th, td {
            border: 1px solid #000; /* Border for table cells */
            padding: 8px; /* Padding inside table cells */
            text-align: center; /* Center text in table cells */
        }

        footer {
            margin-top: 20px; /* Space above the footer */
        }
    </style>
</head>

<body>

    <div class="container">

        <header>
            <h2>Delivery</h2>
            <p>REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
            <p>MUNICIPIO EZEQUIEL ZAMORA, ESTADO MONAGAS</p>
            <p>PUNTA DE MATA</p>
          
        </header>

        <h4>Comprobante de Venta</h4>
        
        <div class="grid">
            <div>
                <p><strong>Venta N°:</strong> {{ str_pad($venta->id, 6, "0", STR_PAD_LEFT) }}</p>
            </div>
            <div>
                <p><strong>Tipo:</strong> {{$venta->pago->tipo}}</p>
            </div>
            <div>
                <p><strong>Fecha:</strong> {{$fechaVenta}}</p>
            </div>
            <div>
                <p><strong>C.I / R.I.F:</strong> {{$userArray['dni']}}</p>
            </div>
            <div>
                <p><strong>NOMBRE/RAZÓN SOCIAL:</strong> {{$userArray['name']}}</p>
            </div>
            <div>
                <p><strong>DIRECCIÓN:</strong> 
                    {{ $userArray['sector'] ?? 'Sector no disponible' }},
                    {{ $userArray['calle'] ?? 'Calle no disponible' }},
                    {{ $userArray['casa'] ?? 'Casa no disponible' }}
                </p>
            </div>
            <div>
                <p><strong>CORREO ELECTRÓNICO:</strong> {{ $userArray['email'] ?? 'Correo no disponible' }}</p>
            </div>
            <div>
                <p><strong>N° de Pago:</strong> {{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                <p><strong>Tipo:</strong> {{ $pago->tipo }}</p>
            </div>
            <div>
                <p><strong>Fecha:</strong> {{ $fechapago }}</p>
            </div>
        </div>

        <h4>Productos Adquiridos</h4>
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Neto</th>
                <th>Impuesto</th>
                <th>Subtotal</th>
            </tr>

            @foreach ($venta->detalleVentas as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Producto no disponible' }}</td>
                    <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                    <td>{{ number_format($detalle->cantidad, 2) }}</td>
                    <td>{{ number_format($detalle->neto, 2) }}</td>
                    <td>{{ number_format($detalle->impuesto, 2) }}</td>
                    <td>{{ number_format($detalle->neto + $detalle->impuesto, 2) }}</td>
                </tr>
            @endforeach
        </table>

        <footer>
            <p>Gracias por su compra</p>
            <p>Este comprobante es válido como recibo de venta</p>
        </footer>

    </div>

</body>

</html>
