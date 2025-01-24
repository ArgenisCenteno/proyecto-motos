<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            text-align: center;
            padding: 10px 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="container">
        <header class="header">
            <h2>Delivery</h2>
            <p>REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
            <p>MUNICIPIO EZEQUIEL ZAMORA, ESTADO MONAGAS</p>
            <p>PUNTA DE MATA</p>
        </header>

        <h5 class="text-center">Comprobante de Pago</h5>
        <table class="table">
            <tr>
                <th>N° de Pago:</th>
                <td>{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <th>Tipo:</th>
                <td>{{ $pago->tipo }}</td>
            </tr>
            <tr>
                <th>Fecha:</th>
                <td>{{ $fechapago }}</td>
            </tr>
        </table>

        <h5>Datos del Usuario</h5>
        <table class="table">
            <tr>
                <th>C.I / R.I.F:</th>
                <td>{{ $userArray['dni'] }}</td>
            </tr>
            <tr>
                <th>NOMBRE/RAZÓN SOCIAL:</th>
                <td>{{ $userArray['name'] }}</td>
            </tr>
            <tr>
                <th>DIRECCIÓN:</th>
                <td>{{ $userArray['sector'] ?? 'Sector no disponible' }},
                    {{ $userArray['calle'] ?? 'Calle no disponible' }},
                    {{ $userArray['casa'] ?? 'Casa no disponible' }}
                </td>
            </tr>
            <tr>
                <th>CORREO ELECTRÓNICO:</th>
                <td>{{ $userArray['email'] ?? 'Correo no disponible' }}</td>
            </tr>
        </table>

        <h5>Forma de Pago</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Forma de Pago</th>
                    <th>Banco de Destino</th>
                    <th>Referencia</th>
                    <th>Moneda</th>
                    <th>Monto Total</th>
                    <th>Total Pagado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formaPagoArray as $pago)
                    <tr>
                        <td>{{ $pago['metodo'] }}</td>
                        <td>{{ $pago['banco_destino'] }}</td>
                        <td>{{ $pago['numero_referencia'] }}</td>
                        <td>{{ $pago['metodo'] === 'Divisa' ? 'Dólar' : 'Bolívar' }}</td>
                        <td>{{ $pago['metodo'] === 'Divisa' ? number_format($pago['monto_dollar'], 2) : number_format($pago['monto_bs'], 2) }}</td>
                        <td>{{ number_format($pago['cantidad'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <footer class="footer">
            <p>Fecha de emisión: {{ date("d-m-Y") }}</p>
        </footer>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(500, 810, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>

</html>
