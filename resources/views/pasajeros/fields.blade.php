<div class="row mb-3">
    <div class="col-md-4">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" value="{{ $pasajero->name }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" value="{{ $pasajero->email }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" value="{{ $pasajero->dni }}" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="sector" class="form-label">Sector</label>
        <input type="text" class="form-control" id="sector" value="{{ $pasajero->sector }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="calle" class="form-label">Calle</label>
        <input type="text" class="form-control" id="calle" value="{{ $pasajero->calle }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="genero" class="form-label">Género</label>
        <input type="text" class="form-control" id="genero" value="{{ $pasajero->genero }}" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="referencia" class="form-label">Referencia</label>
        <input type="text" class="form-control" id="referencia" value="{{ $pasajero->referencia }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="casa" class="form-label">Casa</label>
        <input type="text" class="form-control" id="casa" value="{{ $pasajero->casa }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="status" class="form-label">Estado</label>
        <input type="text" class="form-control" id="status" value="{{ $pasajero->status }}" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="foto_perfil" class="form-label">Foto de Perfil</label>
        <div>
            <img src="{{ asset('files/users/' . $pasajero->foto_perfil) }}" alt="Foto de {{ $pasajero->name }}" class="img-fluid rounded" style="max-width: 150px;">
        </div>
    </div>
</div>
