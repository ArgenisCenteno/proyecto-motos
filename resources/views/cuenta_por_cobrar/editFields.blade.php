<form action="{{ route('cuentasPorCobrar.update', $orden->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Indica que es un método PUT para la actualización -->
    @if(Auth::user() && Auth::user()->hasRole('superAdmin'))
    <div class="form-group">
        <label for="estado">Estado de la Orden:</label>
        <select id="estado" name="estado" class="form-control" >
            <option value="" disabled {{ old('estado', $orden->status) ? '' : 'selected' }}>Seleccionar Estado</option>
            <option value="Pendiente" {{ old('estado', $orden->status) === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="En Proceso" {{ old('estado', $orden->status) === 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
            <option value="Pagada" {{ old('estado', $orden->status) === 'Pagada' ? 'selected' : '' }}>Pagada</option>
            <option value="Rechazado" {{ old('estado', $orden->status) === 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
        </select>
    </div>
@endif

    <hr> <!-- Línea horizontal para separar secciones -->

    <h5>Detalles de la Cuenta:</h5>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="cuenta_id">ID de Cuenta:</label>
                <input type="text" id="cuenta_id" class="form-control" value="{{ $orden->id }}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" class="form-control" value="{{ $orden->user->name ?? 'N/A' }}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="monto_total">Monto Total:</label>
                <input type="text" id="monto_total" class="form-control" value="{{ $orden->monto ?? 'N/A' }}" readonly>
            </div>
        </div>
    </div>

    @if($orden->pago) <!-- Verificar si hay un pago asociado -->
        <h5>Detalles del Pago:</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="monto_pago">Monto:</label>
                    <input type="text" id="monto_pago" class="form-control" value="{{ $orden->pago->monto }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago:</label>
                    <input type="text" id="metodo_pago" class="form-control" value="{{ $orden->pago->metodo_pago }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="banco_origen">Banco de Origen:</label>
                    <input type="text" id="banco_origen" class="form-control" value="{{ $orden->pago->banco_origen }}" readonly>
                </div>
            </div>
        </div>
 
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="banco_destino">Banco de Destino:</label>
                    <input type="text" id="banco_destino" class="form-control" value="{{ $orden->pago->banco_destino }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="referencia">Referencia:</label>
                    <input type="text" id="referencia" class="form-control" value="{{ $orden->pago->referencia }}" readonly>
                </div>
            </div>
           
        </div>
    @else
        <h5>Detalles del Pago:</h5>
        <p>No hay información de pago disponible.</p>
    @endif
    @if(Auth::user() && Auth::user()->hasRole('superAdmin'))
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Actualizar Estado</button>
    </div>
    @endif
</form>
