<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Tipo</label>
            <p class="form-control-plaintext">{{ $tramite->tipo ?? '' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Descripción</label>
            <p class="form-control-plaintext">{{ $tramite->descripcion ?? '' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Estado</label>
            <p class="form-control-plaintext">{{ $tramite->estado }}</p>
        </div>
        @if($tramite->estado === 'Rechazado')
            <div class="mb-3">
                <label class="form-label fw-bold text-dark">Motivo del Rechazo</label>
                <p class="form-control-plaintext">{{ $tramite->motivo_rechazo ?? '' }}</p>
            </div>
        @endif
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Nombre del Conductor</label>
            <p class="form-control-plaintext">{{ $conductor->name }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Email del Conductor</label>
            <p class="form-control-plaintext">{{ $conductor->email ?? '' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">DNI del Conductor</label>
            <p class="form-control-plaintext">{{ $conductor->dni ?? '' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Sector</label>
            <p class="form-control-plaintext">{{ $conductor->sector ?? '' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Calle</label>
            <p class="form-control-plaintext">{{ $conductor->calle ?? '' }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Tipo de Vehículo</label>
        <p class="form-control-plaintext">{{ $vehiculo->tipo ?? '' }}</p>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Marca</label>
        <p class="form-control-plaintext">{{ $vehiculo->marca ?? '' }}</p>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold text-dark">Modelo</label>
        <p class="form-control-plaintext">{{ $vehiculo->modelo ?? '' }}</p>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        @if(isset($registro->documento_conducir) && !empty($registro->documento_conducir))
            <a href="{{ asset('files/users/' . $registro->documento_conducir) }}" class="btn btn-success" target="_blank">Documento de Conducir</a>
        @else
            <button class="btn btn-secondary" disabled>Sin Documento de Conducir</button>
        @endif
    </div>
    <div class="col-md-4">
        @if(isset($registro->documento_contrato) && !empty($registro->documento_contrato))
            <a href="{{ asset('files/users/' . $registro->documento_contrato) }}" class="btn btn-success" target="_blank">Documento de Contrato</a>
        @else
            <button class="btn btn-secondary" disabled>Sin Documento de Contrato</button>
        @endif
    </div>
    <div class="col-md-4">
        @if(isset($registro->documento_propiedad) && !empty($registro->documento_propiedad))
            <a href="{{ asset('files/users/' . $registro->documento_propiedad) }}" class="btn btn-success" target="_blank">Documento de Propiedad</a>
        @else
            <button class="btn btn-secondary" disabled>Sin Documento de Propiedad</button>
        @endif
    </div>
</div>