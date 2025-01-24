<style>
    .invalid-feedback {
        color: red !important;
    }
</style>

<form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
            <small class="form-text text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="dni" class="form-label">Cédula</label>
            <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{ old('dni', $usuario->dni) }}" required>
            @error('dni')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="role" class="form-label">Rol</label>
            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                <option value="">Selecciona un rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $usuario->role == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="sector" class="form-label">Sector</label>
            <select class="form-select @error('sector') is-invalid @enderror" id="sector" name="sector" required>
                <option value="">Selecciona un sector</option>
                @foreach($sectores as $sector)
                    <option value="{{ $sector->nombre }}" {{ old('sector', $usuario->sector) == $sector->nombre ? 'selected' : '' }}>{{ $sector->nombre }}</option>
                @endforeach
            </select>
            @error('sector')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control @error('calle') is-invalid @enderror" id="calle" name="calle" value="{{ old('calle', $usuario->calle) }}" required>
            @error('calle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="casa" class="form-label">Casa</label>
            <input type="text" class="form-control @error('casa') is-invalid @enderror" id="casa" name="casa" value="{{ old('casa', $usuario->casa) }}" required>
            @error('casa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
            <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil" name="foto_perfil" accept=".png, .jpg, .jpeg">
            <small class="form-text text-muted">Deja este campo vacío si no deseas cambiar la foto.</small>
            @error('foto_perfil')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <a class="btn btn-success" href="{{ asset('files/users/' . $usuario->foto_perfil) }}" target="_blank">Foto Actual</a>

        </div>

        <div class="mb-3 col-md-4">
            <label for="genero" class="form-label">Género</label>
            <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                <option value="">Selecciona un género</option>
                <option value="Masculino" {{ old('genero', $usuario->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero', $usuario->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero', $usuario->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('genero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-12">
            <label for="referencia" class="form-label">Referencia</label>
            <textarea class="form-control @error('referencia') is-invalid @enderror" id="referencia" name="referencia" rows="3" placeholder="Detalles de la casa donde vive">{{ old('referencia', $usuario->referencia) }}</textarea>
            @error('referencia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>
