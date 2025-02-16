<form action="{{ route('tramites.update', $tramite->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Esto le indica a Laravel que es una solicitud PUT -->
<div class="row">
        <!-- Tramite Information -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="{{ $tramite->tipo ?? '' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $tramite->descripcion ?? '' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="Pendiente" {{ $tramite->estado === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="En proceso" {{ $tramite->estado === 'En proceso' ? 'selected' : '' }}>En proceso</option>

                    <option value="Aprobado" {{ $tramite->estado === 'Aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="Rechazado" {{ $tramite->estado === 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <div class="mb-3" id="rechazoMotivo" style="display: {{ $tramite->estado === 'Rechazado' ? 'block' : 'none' }};">
                <label for="motivo_rechazo" class="form-label">Motivo del Rechazo</label>
                <textarea class="form-control" id="motivo_rechazo" name="observacion" rows="3">{{ $tramite->motivo_rechazo ?? '' }}</textarea>
            </div>

            <div class="mb-3">
                <label for="conductor_name" class="form-label">Nombre del Conductor</label>
                <input type="text" class="form-control" id="conductor_name" name="conductor_name" value="{{ $conductor->name }}" readonly>
            </div>
        </div>

        <!-- Conductor Information -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="conductor_email" class="form-label">Email del Conductor</label>
                <input type="email" class="form-control" id="conductor_email" name="conductor_email" value="{{ $conductor->email ?? '' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="conductor_dni" class="form-label">DNI del Conductor</label>
                <input type="text" class="form-control" id="conductor_dni" name="conductor_dni" value="{{ $conductor->dni ?? '' }}" readonly>
            </div>
            <div class="mb-3">
                <label for="conductor_sector" class="form-label">Sector del Conductor</label>
                <input type="text" class="form-control" id="conductor_sector" name="conductor_sector" value="{{ $conductor->sector ??''}}" readonly>
            </div>
            <div class="mb-3">
                <label for="conductor_calle" class="form-label">Calle del Conductor</label>
                <input type="text" class="form-control" id="conductor_calle" name="conductor_calle" value="{{ $conductor->calle ?? '' }}" readonly>
            </div>
        </div>
    </div>

    <!-- Vehículo Information -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="vehiculo_tipo" class="form-label">Tipo de Vehículo</label>
            <input type="text" class="form-control" id="vehiculo_tipo" value="{{ $vehiculo->tipo ?? '' }}" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label for="vehiculo_marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="vehiculo_marca" value="{{ $vehiculo->marca ?? '' }}" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label for="vehiculo_modelo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="vehiculo_modelo" value="{{ $vehiculo->modelo ?? '' }}" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label for="vehiculo_color" class="form-label">Color</label>
            <input type="text" class="form-control" id="vehiculo_color" value="{{ $vehiculo->color ?? '' }}" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label for="vehiculo_placa" class="form-label">Placa</label>
            <input type="text" class="form-control" id="vehiculo_placa" value="{{ $vehiculo->placa ?? '' }}" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label for="vehiculo_anio" class="form-label">Año</label>
            <input type="text" class="form-control" id="vehiculo_anio" value="{{ $vehiculo->anio ??'' }}" readonly>
        </div>
    </div>

    <!-- Document Links -->
    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            @if(isset($registro->documento_conducir) && !empty($registro->documento_conducir))
                <a href="{{ asset('files/users/' . $registro->documento_conducir) }}" class="btn btn-success" target="_blank">Documento de Conducir</a>
            @else
                <button class="btn btn-secondary" disabled>Sin Documento de Conducir</button>
            @endif
        </div>

        <div class="col-md-4 mb-3">
            @if(isset($registro->documento_contrato) && !empty($registro->documento_contrato))
                <a href="{{ asset('files/users/' . $registro->documento_contrato) }}" class="btn btn-success" target="_blank">Documento de Contrato</a>
            @else
                <button class="btn btn-secondary" disabled>Sin Documento de Contrato</button>
            @endif
        </div>

        <div class="col-md-4 mb-3">
            @if(isset($registro->documento_propiedad) && !empty($registro->documento_propiedad))
                <a href="{{ asset('files/users/' . $registro->documento_propiedad) }}" class="btn btn-success" target="_blank">Documento de Propiedad</a>
            @else
                <button class="btn btn-secondary" disabled>Sin Documento de Propiedad</button>
            @endif
        </div>
    </div>

    <!-- Submit Button -->
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Actualizar Tramite</button>
    </div>

</form>


 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const estadoSelect = document.getElementById('estado');
        const rechazoMotivo = document.getElementById('rechazoMotivo');

        estadoSelect.addEventListener('change', function () {
            if (this.value === 'Rechazado') {
                rechazoMotivo.style.display = 'block';
            } else {
                rechazoMotivo.style.display = 'none';
            }
        });
    });
</script>
