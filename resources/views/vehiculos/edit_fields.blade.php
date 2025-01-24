<form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="servicio_id" class="form-label">Servicio</label>
            <select class="form-select" id="servicio_id" name="servicio_id" required>
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ $vehiculo->servicio_id == $servicio->id ? 'selected' : '' }}>{{ $servicio->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
    <label for="user_id" class="form-label">Conductor</label>
    <select class="form-select" id="user_id" name="user_id" required>
        <option value="">Selecciona un conductor</option>
        @foreach($conductores as $usuario)
            <option value="{{ $usuario->id }}" {{ old('user_id', $vehiculo->user_id) == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
        @endforeach
    </select>
</div>

    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tipo" class="form-label">Tipo de Vehículo</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Selecciona un tipo de vehículo</option>
                <option value="Moto" {{ $vehiculo->tipo == 'Moto' ? 'selected' : '' }}>Moto</option>
                <option value="Carro" {{ $vehiculo->tipo == 'Carro' ? 'selected' : '' }}>Carro</option>
                <option value="SUV" {{ $vehiculo->tipo == 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="Camioneta" {{ $vehiculo->tipo == 'Camioneta' ? 'selected' : '' }}>Camioneta</option>
                <option value="Deportivo" {{ $vehiculo->tipo == 'Deportivo' ? 'selected' : '' }}>Deportivo</option>
                <option value="Otro" {{ $vehiculo->tipo == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{ $vehiculo->marca }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $vehiculo->modelo }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" class="form-control" id="color" name="color" value="{{ $vehiculo->color }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="placa" class="form-label">Placa</label>
            <input type="text" class="form-control" id="placa" name="placa" value="{{ $vehiculo->placa }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" class="form-control" id="anio" name="anio" value="{{ $vehiculo->anio }}" required>
        </div>
    </div>

  

    <button type="submit" class="btn btn-primary">Actualizar Vehículo</button>
</form>
