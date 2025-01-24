

    {{-- Conductor Information --}}
   

<div class="row mb-3">
    <div class="col-md-4">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" value="{{ $conductor->name }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" value="{{ $conductor->email }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" value="{{ $conductor->dni }}" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="sector" class="form-label">Sector</label>
        <input type="text" class="form-control" id="sector" value="{{ $conductor->sector }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="calle" class="form-label">Calle</label>
        <input type="text" class="form-control" id="calle" value="{{ $conductor->calle }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="genero" class="form-label">Género</label>
        <input type="text" class="form-control" id="genero" value="{{ $conductor->genero }}" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="referencia" class="form-label">Referencia</label>
        <input type="text" class="form-control" id="referencia" value="{{ $conductor->referencia }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="casa" class="form-label">Casa</label>
        <input type="text" class="form-control" id="casa" value="{{ $conductor->casa }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="status" class="form-label">Telefono de emergencia</label>
        <input type="text" class="form-control" id="status" value="{{ $conductor->telefono_emergencia ?? '' }}" readonly>
    </div>
    <div class="col-md-4">
        <label for="status" class="form-label">Estado</label>
        <input type="text" class="form-control" id="status" value="{{ $conductor->status }}" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="foto_perfil" class="form-label">Foto de Perfil</label>
        <div>
            <img src="{{ asset('files/users/' . $conductor->foto_perfil) }}" alt="Foto de {{ $conductor->name }}" class="img-fluid rounded" style="max-width: 150px;">
        </div>
    </div>
</div>


    {{-- Vehicles --}}
    <h4 class="py-4">Vehículos del Conductor</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="vehiculos-table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Color</th>
                    <th>Placa</th>
                    <th>Año</th>
                    <th>Propietario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conductor->vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->tipo }}</td>
                        <td>{{ $vehicle->marca }}</td>
                        <td>{{ $vehicle->modelo }}</td>
                        <td>{{ $vehicle->color }}</td>
                        <td>{{ $vehicle->placa }}</td>
                        <td>{{ $vehicle->anio }}</td>
                        <td>{{ $vehicle->propietario }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Registro de Conductor --}}
    <h4 class="py-4">Registro del Conductor</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="registro-conductores-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Registro</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conductor->registroConductores as $registro)
                    <tr>
                        <td>{{ $registro->id ?? 'N/A'}}</td>
                        <td>{{ $registro->created_at ?? 'N/A' }}</td>
                        <td>{{ $registro->estado ?? 'N/A'}}</td>
                        <td>{{ $registro->observaciones ?? 'N/A'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tramites --}}
    <h4 class="py-4">Trámites del Conductor</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="tramites-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conductor->tramites as $tramite)
                    <tr>
                        <td>{{ $tramite->id ?? 'N/A'}}</td>
                        <td>{{ $tramite->descripcion ?? 'N/A'}}</td>
                        <td>{{ $tramite->estado ?? 'N/A'}}</td>
                        <td>{{ $tramite->created_at ?? 'N/A'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>