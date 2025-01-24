@php
    // Array with Venezuelan banks
    $bancos = [
        'Banco de Venezuela',
        'Banesco',
        'Banco Provincial',
        'Banco Bicentenario',
        'BFC Banco Fondo Común',
        'Mercantil Banco',
        'Banco Nacional de Crédito (BNC)',
        'Banco del Tesoro',
        'Banco Exterior',
        'Banco Caroní',
        'Banco Activo',
        'Banco del Caribe',
        'Banesco Banco Universal',
    ];
    $bancos2 = [
        'Banco de Venezuela',
        'Banesco',
    ];
@endphp

<form action="{{ route('cuentasPorCobrar.store') }}" method="POST" onsubmit="return validateForm()">
    @csrf

    <div class="card shadow-sm p-4 mb-4">
        <!-- Account Details -->
        <div class="form-row">
    <div class="form-group col-md-4">
        <label for="id">
            <i class="material-icons">account_box</i> ID de Cuenta:
        </label>
        <input type="text" id="id" name="id" class="form-control" value="{{ $cuenta->id }}" readonly>
    </div>
    <div class="form-group col-md-4">
        <label for="cliente">
            <i class="material-icons">person</i> Cliente:
        </label>
        <input type="text" id="cliente" class="form-control" value="{{ $cuenta->user->name }}" readonly>
    </div>
    <div class="form-group col-md-4">
        <label for="monto">
        <strong>BS</strong> Monto a Pagar:
        </label>
        <input type="text" id="monto" class="form-control" value="{{ $cuenta->monto }}" readonly>
    </div>
</div>

<!-- Account Status & Creation Date -->
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="estado">
            <i class="material-icons">info</i> Estado:
        </label>
        <input type="text" id="estado" class="form-control" value="{{ ucfirst($cuenta->status) }}" readonly>
    </div>
    <div class="form-group col-md-4">
        <label for="fecha_creacion">
            <i class="material-icons">calendar_today</i> Fecha de Creación:
        </label>
        <input type="text" id="fecha_creacion" class="form-control" value="{{ $cuenta->created_at->format('d/m/Y H:i') }}" readonly>
    </div>
</div>


        <!-- Transferencia Bancaria Section -->
        <div class="form-group">
            <label for="transferencia" class="d-block">
                <i class="material-icons">credit_card</i> Transferencia Bancaria
            </label>
            <input type="checkbox" id="transferencia" class="form-check-input" onclick="toggleTransferFields()">
            <span class="ml-2">Activar</span>
        </div>

        <div id="transfer-fields" style="display: none;">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="banco_origen">
                        <i class="material-icons">account_balance_wallet</i> Banco de Origen:
                    </label>
                    <select id="banco_origen" name="banco_origen_transfer" class="form-control">
                        <option value="" disabled selected>Seleccionar Banco de Origen</option>
                        @foreach($bancos as $banco)
                            <option value="{{ $banco }}">{{ $banco }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="banco_destino">
                        <i class="material-icons">account_balance</i> Banco de Destino:
                    </label>
                    <select id="banco_destino" name="banco_destino_transfer" class="form-control">
                        <option value="" disabled selected>Seleccionar Banco de Destino</option>
                        @foreach($bancos2 as $banco)
                            <option value="{{ $banco }}">{{ $banco }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="referencia">
                        <i class="material-icons">receipt</i> Referencia de Transferencia:
                    </label>
                    <input type="text" id="referencia" name="referencia_transfer" class="form-control" placeholder="Número de referencia">
                </div>
            </div>
        </div>

        <!-- Pago Móvil Section -->
        <div class="form-group">
            <label for="pago_movil" class="d-block">
                <i class="material-icons">phone_android</i> Pago Móvil
            </label>
            <input type="checkbox" id="pago_movil" class="form-check-input" onclick="togglePagoMovilFields()">
            <span class="ml-2">Activar</span>
        </div>

        <div id="pago-movil-fields" style="display: none;">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="banco_origen_movil">
                        <i class="material-icons">account_balance_wallet</i> Banco de Origen:
                    </label>
                    <select id="banco_origen_movil" name="banco_origen_movil" class="form-control">
                        <option value="" disabled selected>Seleccionar Banco de Origen</option>
                        @foreach($bancos as $banco)
                            <option value="{{ $banco }}">{{ $banco }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="banco_destino_movil">
                        <i class="material-icons">account_balance</i> Banco de Destino:
                    </label>
                    <select id="banco_destino_movil" name="banco_destino_movil" class="form-control">
                        <option value="" disabled selected>Seleccionar Banco de Destino</option>
                        @foreach($bancos2 as $banco)
                            <option value="{{ $banco }}">{{ $banco }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="referencia_movil">
                        <i class="material-icons">receipt</i> Referencia de Pago Móvil:
                    </label>
                    <input type="text" id="referencia_movil" name="referencia_movil" class="form-control" placeholder="Número de referencia">
                </div>
            </div>
        </div>

        <!-- Hidden Amount Field -->
        <input type="hidden" id="monto_pago" name="monto_pago" value="{{ $cuenta->monto }}">

        <!-- Submit and Cancel Buttons -->
        <div class="form-group text-start">
            <button type="submit" class="btn btn-primary">
                Registrar Pago
            </button>
            <a href="{{ route('cuentasPorCobrar.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </div>
</form>

@section('js')
<script>
    // Toggle visibility of transfer fields
    function toggleTransferFields() {
        var transferFields = document.getElementById('transfer-fields');
        var pagoMovilCheckbox = document.getElementById('pago_movil');

        if (transferFields.style.display === 'none') {
            transferFields.style.display = 'block';
            if (pagoMovilCheckbox.checked) {
                pagoMovilCheckbox.checked = false; // Uncheck Pago Móvil
                togglePagoMovilFields(); // Hide Pago Móvil if activated
            }
        } else {
            transferFields.style.display = 'none';
        }
    }

    // Toggle visibility of Pago Móvil fields
    function togglePagoMovilFields() {
        var pagoMovilFields = document.getElementById('pago-movil-fields');
        var transferCheckbox = document.getElementById('transferencia');

        if (pagoMovilFields.style.display === 'none') {
            pagoMovilFields.style.display = 'block';
            if (transferCheckbox.checked) {
                transferCheckbox.checked = false; // Uncheck Transferencia
                toggleTransferFields(); // Hide Transferencia if activated
            }
        } else {
            pagoMovilFields.style.display = 'none';
        }
    }

    // Validate form before submission
    function validateForm() {
        var transferFields = document.getElementById('transfer-fields');
        var pagoMovilFields = document.getElementById('pago-movil-fields');
        var isValid = true;

        if (transferFields.style.display === 'block') {
            var bancoOrigen = document.getElementById('banco_origen');
            var bancoDestino = document.getElementById('banco_destino');
            var referencia = document.getElementById('referencia');
            if (!bancoOrigen.value || !bancoDestino.value || !referencia.value) {
                isValid = false;
                alert('Por favor, complete todos los campos para la Transferencia Bancaria.');
            }
        }

        if (pagoMovilFields.style.display === 'block') {
            var bancoOrigenMovil = document.getElementById('banco_origen_movil');
            var bancoDestinoMovil = document.getElementById('banco_destino_movil');
            var referenciaMovil = document.getElementById('referencia_movil');
            if (!bancoOrigenMovil.value || !bancoDestinoMovil.value || !referenciaMovil.value) {
                isValid = false;
                alert('Por favor, complete todos los campos para el Pago Móvil.');
            }
        }

        return isValid;
    }
</script>
@endsection
