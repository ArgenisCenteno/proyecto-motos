<form action="{{ route('vehiculos.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="servicio_id" class="form-label">Servicio</label>
            <select class="form-select" id="servicio_id" name="servicio_id" required>
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                        {{ $servicio->descripcion }}
                    </option>
                @endforeach
            </select>
            @error('servicio_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="user_id" class="form-label">Conductor</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">Selecciona un conductor</option>
                @foreach($conductores as $conductor)
                    <option value="{{ $conductor->id }}" {{ old('user_id') == $conductor->id ? 'selected' : '' }}>
                        {{ $conductor->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tipo" class="form-label">Tipo de Vehículo</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Selecciona un tipo de vehículo</option>
                <option value="Moto" {{ old('tipo') == 'Moto' ? 'selected' : '' }}>Moto</option>
                <option value="Carro" {{ old('tipo') == 'Carro' ? 'selected' : '' }}>Carro</option>
                <option value="SUV" {{ old('tipo') == 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="Camioneta" {{ old('tipo') == 'Camioneta' ? 'selected' : '' }}>Camioneta</option>
                <option value="Deportivo" {{ old('tipo') == 'Deportivo' ? 'selected' : '' }}>Deportivo</option>
                <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('tipo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{ old('marca') }}" required>
            @error('marca')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="{{ old('modelo') }}" required>
            @error('modelo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" class="form-control" id="color" name="color" value="{{ old('color') }}" required>
            @error('color')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="placa" class="form-label">Placa</label>
            <input type="text" class="form-control" id="placa" name="placa" value="{{ old('placa') }}" required>
            @error('placa')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" class="form-control" id="anio" name="anio" value="{{ old('anio') }}" required>
            @error('anio')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Agregar Vehículo</button>
</form>
