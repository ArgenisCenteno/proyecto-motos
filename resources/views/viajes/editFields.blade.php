<!-- Mostrar información del viaje -->
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('viajes.update', $viaje->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>Vehículo:</strong></label>
                        <input type="text" class="form-control"
                            value="{{ $viaje->vehiculo ? $viaje->vehiculo->placa . ' ' . $viaje->vehiculo->user->name : 'Sin asignar' }}"
                            readonly>
                    </div>
                </div>
                @if(Auth::user() && Auth::user()->hasRole('superAdmin'))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>Usuario:</strong></label>
                            <select name="user_id" class="form-control">
                                <option value="">Seleccionar Usuario</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ isset($viaje->user->id) && $viaje->user->id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>Cliente:</strong></label>
                        <input type="text" class="form-control" value="{{  $viaje->user->name  }}" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>Distancia:</strong></label>
                        <input type="text" class="form-control" value="{{ $viaje->distancia_km }} km" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>Precio:</strong></label>
                        <input type="text" class="form-control" value="{{ $viaje->precio }}" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                @if(Auth::user() && Auth::user()->hasRole('superAdmin'))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>Estado:</strong></label>
                            <select name="estado" class="form-control" required {{ $viaje->estado == 'Finalizado' ? 'disabled' : '' }}>
                                <option value="Pendiente" {{ $viaje->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente
                                </option>
                                <option value="Iniciado" {{ $viaje->estado == 'Iniciado' ? 'selected' : '' }}>Iniciado
                                </option>
                                <option value="Finalizado" {{ $viaje->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado
                                </option>
                                <option value="Cancelado" {{ $viaje->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado
                                </option>
                            </select>
                        </div>
                    </div>
                @endif

                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>Hora de Salida:</strong></label>
                        <input type="text" class="form-control"
                            value="{{ $viaje->hora_salida ? $viaje->hora_salida->format('H:i') : 'No iniciada' }}"
                            readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><strong>Hora de Llegada:</strong></label>
                        <input type="text" class="form-control"
                            value="{{ $viaje->hora_llegada ? $viaje->hora_llegada->format('H:i') : 'No finalizada' }}"
                            readonly>
                    </div>
                </div>
            </div>

            <div class="row">

            </div>
            @if(Auth::user() && Auth::user()->hasRole('superAdmin'))
                <!-- Botón para enviar el formulario -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Actualizar Viaje</button>
                </div>
            @endif
        </form>
    </div>


    <!-- Mapa para mostrar la ruta trazada -->
    <div class="col-md-12">
        <h4>Ruta del Viaje</h4>
        <div id="map" style="height: 600px; width: 100%;"></div>
    </div>
</div>

<!-- Incluir los estilos de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Incluir el script de Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Incluir los estilos y scripts de Leaflet Routing Machine -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Verifica si el viaje tiene coordenadas
        @if($origen && $destino)
                // Inicializa el mapa con las coordenadas del origen
                var map = L.map('map').setView([{{ $origen['lat'] }}, {{ $origen['lon'] }}], 13);

                // Agregar el mapa base de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Trazar la ruta entre el origen y destino
                L.Routing.control({
                    waypoints: [
                        L.latLng({{ $origen['lat'] }}, {{ $origen['lon'] }}),
                    L.latLng({{ $destino['lat'] }}, {{ $destino['lon'] }})
                                ],
                routeWhileDragging: true
            }).addTo(map);
        @else
            // Muestra un mensaje si no hay coordenadas disponibles
            alert("No se han proporcionado las coordenadas de origen o destino para este viaje.");
        @endif
    });
</script>