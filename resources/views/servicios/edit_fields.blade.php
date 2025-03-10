<div class="row">
    <!-- Nombre del servicio -->
   
    <!-- Descripción del servicio -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="descripcion">Nombre</label>
            <input type="text" name="descripcion" 
    value="{{ old('descripcion', $servicio->descripcion) }}" 
    class="form-control @error('descripcion') is-invalid @enderror" 
    id="descripcion" 
    placeholder="Ingrese una descripción del servicio" 
    required 
    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
            @error('descripcion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Costo del servicio -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="costo">Costo del Servicio (Bs)</label>
            <input type="number" value="{{$servicio->costo}}" name="costo" class="form-control @error('costo') is-invalid @enderror" id="costo" value="{{ old('costo') }}" placeholder="Ingrese el costo del servicio" required step="0.01">
            @error('costo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<!-- Botón de enviar -->
<div class="form-group">
    <button type="submit" class="btn btn-primary">Guardar Servicio</button>
</div>
