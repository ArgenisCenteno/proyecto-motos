<div class="row">
    <!-- Nombre del sector -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre">Nombre del Sector</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre del sector" required>
            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Parroquia -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="parroquia_id">Parroquia</label>
            <select name="parroquia_id" class="form-control @error('parroquia_id') is-invalid @enderror" id="parroquia_id" required>
                <option value="" selected disabled>Seleccione una parroquia</option>
                @foreach($parroquias as $parroquia)
                    <option value="{{ $parroquia->id }}" {{ old('parroquia_id') == $parroquia->id ? 'selected' : '' }}>{{ $parroquia->parish }}</option>
                @endforeach
            </select>
            @error('parroquia_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Estado -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" class="form-control @error('estado') is-invalid @enderror" id="estado" required>
                <option value="" selected disabled>Seleccione el estado</option>
                <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<!-- Botón de enviar -->
<div class="form-group">
    <button type="submit" class="btn btn-primary">Guardar Sector</button>
</div>
