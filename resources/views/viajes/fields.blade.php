<form action="{{ route('viajes.store') }}" method="POST">
    @csrf
    <div>
        @if(Auth::user()->hasRole('superAdmin'))
        <div class="row mt-3">
            <div class="col-md-4 ">
                <label for="cedula" class="d-flex align-items-center">
                    <i class="material-icons me-2">badge</i> Cédula:
                </label>
                <div class="input-group">
                    <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Ingrese Cédula">
                    <button type="button" class="btn btn-success buscar">Buscar</button>
                </div>
            </div>
            <div class="col-md-4">
                <label for="name" class="d-flex align-items-center">
                    <i class="material-icons me-2">person</i> Nombre:
                </label>
                <input type="text" id="name" name="name" class="form-control" readonly>
                <input type="hidden" id="nuevoUser" name="nuevoUser">
            </div>
            <div class="col-md-4">
                <label for="email" class="d-flex align-items-center">
                    <i class="material-icons me-2">email</i> Email:
                </label>
                <input type="email" id="email" id="email" name="email" class="form-control" readonly>
                @error('email')
                    <div class="invalid-feedback">Este email esta en uso</div>
                @enderror
            </div>
        </div>
    @endif

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="sector">
                    <i class="material-icons">location_on</i> Selecciona un sector:
                </label>
                <select id="sector" name="sector" class="form-control" readonly>
                    <option value="">Seleccione un sector</option>
                    @foreach($sectores as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="sector">
                    <i class="material-icons">payment</i> Costo(BS):
                </label>
                <input type="text" id="costo" name="costo" class="form-control" readonly>

            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-3">
                <label for="origen_lat">
                    <i class="material-icons">my_location</i> Latitud de Origen:
                </label>
                <input type="text" id="origen_lat" name="origen_lat" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label for="origen_lon">
                    <i class="material-icons">location_searching</i> Longitud de Origen:
                </label>
                <input type="text" id="origen_lon" name="origen_lon" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label for="destino_lat">
                    <i class="material-icons">location_on</i> Latitud de Destino:
                </label>
                <input type="text" id="destino_lat" name="destino_lat" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label for="destino_lon">
                    <i class="material-icons">location_on</i> Longitud de Destino:
                </label>
                <input type="text" id="destino_lon" name="destino_lon" class="form-control" readonly>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-3">
                <label for="distancia">
                    <i class="material-icons">directions_car</i> Distancia(km):
                </label>
                <input type="text" id="distancia" name="distancia" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label for="tiempo">
                    <i class="material-icons">timer</i> Tiempo (h):
                </label>
                <input type="text" id="tiempo" name="tiempo" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label for="direccion_destino">
                    <i class="material-icons">location_city</i> Dirección de Destino:
                </label>
                <textarea id="direccion_destino" name="direccion_destino" class="form-control" readonly></textarea>
            </div>
        </div>

        <!-- Contenedor del mapa -->
        <label for="">
            <i class="material-icons">map</i> Seleccione su destino en el mapa
        </label>
        <div id="map" style="height: 600px;"></div>

        <button class="btn btn-primary mt-4" style="width: 100%;" type="submit">
            Generar Viaje
        </button>
    </div>
</form>


<!-- Incluir los estilos de Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Incluir el script de Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Incluir los estilos y scripts de Leaflet Routing Machine -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<!-- Leaflet Control Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!-- Incluir el script del buscador ya está incluido -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa el mapa y establece las coordenadas iniciales
        var map = L.map('map').setView([10.5000, -66.9167], 13); // Coordenadas iniciales (ejemplo de Caracas)

        // Agregar el mapa base de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Agregar buscador al mapa
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        }).on('markgeocode', function (e) {
            var bbox = e.geocode.bbox;
            var destLat = e.geocode.center.lat;
            var destLon = e.geocode.center.lng;

            // Si ya existe un marcador de destino, remuévelo
            if (destinationMarker) {
                map.removeLayer(destinationMarker);
            }

            // Establece el marcador en el destino
            destinationMarker = L.marker([destLat, destLon]).addTo(map)
                .bindPopup(e.geocode.name)
                .openPopup();

            // Establecer los valores en los campos ocultos
            document.getElementById('destino_lat').value = destLat;
            document.getElementById('destino_lon').value = destLon;
            obtenerNombreZona(destLat, destLon); // Obtener el nombre de la zona
            calculateRoute(userLat, userLon, destLat, destLon); // Calcular la ruta

            map.fitBounds(bbox);
        }).addTo(map);

        // Variables para marcadores y rutas
        var userLat, userLon;
        var destinationMarker = null;
        var routeControl = null;

        // Obtiene la ubicación actual del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                userLat = position.coords.latitude;
                userLon = position.coords.longitude;

                // Establece los valores del origen en los campos ocultos
                document.getElementById('origen_lat').value = userLat;
                document.getElementById('origen_lon').value = userLon;

                var userLocation = L.marker([userLat, userLon]).addTo(map);
                userLocation.bindPopup('Tu ubicación actual').openPopup();
                map.setView([userLat, userLon], 13);

                // Permite al usuario seleccionar el destino haciendo clic en el mapa
                map.on('click', function (e) {
                    var destLat = e.latlng.lat;
                    var destLon = e.latlng.lng;

                    // Si ya existe un marcador de destino, remuévelo
                    if (destinationMarker) {
                        map.removeLayer(destinationMarker);
                    }

                    // Agregar un nuevo marcador en el destino
                    destinationMarker = L.marker([destLat, destLon]).addTo(map);
                    destinationMarker.bindPopup('Destino seleccionado').openPopup();

                    // Llamar a la función para obtener el nombre de la zona
                    obtenerNombreZona(destLat, destLon);

                    // Establecer los valores del destino en los campos ocultos
                    document.getElementById('destino_lat').value = destLat;
                    document.getElementById('destino_lon').value = destLon;

                    // Trazar la ruta entre la ubicación actual y el destino
                    calculateRoute(userLat, userLon, destLat, destLon);
                });
            }, function () {
                alert('No se pudo obtener la ubicación');
            });
        } else {
            alert('La geolocalización no está disponible en este navegador');
        }

        // Función para calcular la ruta entre dos puntos
        function calculateRoute(userLat, userLon, destLat, destLon) {
            if (routeControl) {
                map.removeControl(routeControl); // Remover la ruta anterior
            }

            routeControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLat, userLon),
                    L.latLng(destLat, destLon)
                ],
                routeWhileDragging: true
            }).on('routesfound', function (e) {
                var routes = e.routes;
                var summary = routes[0].summary;

                const carreraCorta = @json($corta);
                const carreraLarga = @json($larga);

                var costo = 0;
                if (summary.totalDistance / 1000 > 3) {
                    costo = carreraLarga.costo;
                } else {
                    costo = carreraCorta.costo;
                }

                // Establecer la distancia y el tiempo en los campos ocultos
                document.getElementById('distancia').value = (summary.totalDistance / 1000).toFixed(2); // Convertir a kilómetros
                document.getElementById('tiempo').value = (summary.totalTime / 60).toFixed(2); // Convertir a minutos
                document.getElementById('costo').value = costo; // Convertir a minutos

            }).addTo(map);
        }

        // Función para obtener el nombre de la zona
        function obtenerNombreZona(lat, lon) {
            var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.address) {
                        var direccion = data.display_name || 'Dirección no disponible';
                        document.getElementById('direccion_destino').value = direccion;
                    } else {
                        document.getElementById('direccion_destino').value = 'Dirección no disponible';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el nombre de la zona:', error);
                    document.getElementById('direccion_destino').value = 'Dirección no disponible';
                });
        }
    });
</script>
@include('layout.script')
<script>
    $(document).ready(function () {
        $('.buscar').click(function () {
            const cedula = $('#cedula').val();

            if (cedula != '') {
                // Realizar la búsqueda mediante AJAX
                $.ajax({
                    url: "/buscarUsuario/" + cedula, // URL actualizada según tu ruta
                    type: "GET",
                    success: function (response) {
                        if (response.data) {
                            // Si se encuentra el usuario, mostrar los datos
                            $('#name').val(response.data.name);
                            $('#email').val(response.data.email);
                            $('#nuevoUser').val('SI');
                            $('#name, #email').prop('readonly', true); // Hacer los campos de sólo lectura
                        } else {
                            // Si no se encuentra el usuario, habilitar los campos y mostrar mensaje
                            $('#name').prop('readonly', false).val('');
                            $('#email').prop('readonly', false).val('');
                            alert('Usuario no encontrado. ¿Deseas registrarlo?');
                        }
                    },
                    error: function () {
                        alert('Hubo un error al buscar la cédula.');
                    }
                });
            } else {
                alert('Por favor ingresa una cédula válida.');
            }
        });


        $('#email').on('input', function () {
            var email = $(this).val(); // Obtener el valor del email
            var emailInput = $(this); // Almacenar el elemento del input

            // Solo hacer la validación si el email no está vacío
            if (email != '') {
                $.ajax({
                    url: "/buscarEmail/" + email, // URL que usas para la validación
                    type: "GET",
                    success: function (response) {
                        if (response.data) {
                            // Si el email ya existe, mostrar mensaje de error y marcar el campo en rojo
                            emailInput.addClass('is-invalid');
                            emailInput.removeClass('is-valid');
                            emailInput.next('.invalid-feedback').text('Este email ya existe.');
                        } else {
                            // Si el email no existe, marcar el campo como válido
                            emailInput.removeClass('is-invalid');
                            emailInput.addClass('is-valid');
                            emailInput.next('.invalid-feedback').text('');
                        }
                    },
                    error: function () {
                        console.log("Error en la solicitud AJAX");
                    }
                });
            } else {
                // Si el campo está vacío, quitar cualquier clase de validación
                emailInput.removeClass('is-invalid is-valid');
            }
        });

    });


</script>