<style>
    .invalid-feedback {
        color: red !important;
    }
</style>

<form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
    id="name" 
    name="name"  
    value="{{ old('name') }}" 
    placeholder="Ingrese el nombre"
    required 
    oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '')">
                
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="dni" class="form-label">Cédula</label>
            <input type="text" class="form-control @error('dni') is-invalid @enderror" 
    id="dni" 
    name="dni"  
    value="{{ old('dni') }}" 
    placeholder="Ingrese su DNI"
    required 
    oninput="this.value = this.value.replace(/[^0-9]/g, '')">

            @error('dni')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-select role" id="role" name="role" required>
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="mb-3 col-md-4">
            <label for="sector" class="form-label">Sector</label>
            <select class="form-select @error('sector') is-invalid @enderror" id="sector" name="sector" required>
                <option value="">Selecciona un sector</option>
                @foreach($sectores as $sector)
                    <option value="{{ $sector->nombre }}" {{ old('sector') == $sector->nombre ? 'selected' : '' }}>
                        {{ $sector->nombre }}
                    </option>
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
            <input type="text" class="form-control @error('calle') is-invalid @enderror" id="calle" name="calle"
                value="{{ old('calle') }}" required>
            @error('calle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="casa" class="form-label">Casa</label>
            <input type="text" class="form-control @error('casa') is-invalid @enderror" id="casa" name="casa"
                value="{{ old('casa') }}" required>
            @error('casa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
            <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil"
                name="foto_perfil" accept=".png, .jpg, .jpeg" required>
            @error('foto_perfil')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="genero" class="form-label">Género</label>
            <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                <option value="">Selecciona un género</option>
                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('genero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-12">
            <label for="referencia" class="form-label">Referencia</label>
            <textarea class="form-control @error('referencia') is-invalid @enderror" id="referencia" name="referencia"
                rows="3" placeholder="Detalles de la casa donde vive">{{ old('referencia') }}</textarea>
            @error('referencia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div id="document-upload-fields" style="display: none;">
        <div class="row">
            <h4>Documentación</h4>
            <div class="col-md-4 mb-3">
                <label for="documento_conducir" class="form-label">Documento de Conducir</label>
                <input type="file" class="form-control" id="documento_conducir" name="documento_conducir">
            </div>
            <div class="col-md-4 mb-3">
                <label for="documento_contrato" class="form-label">Documento de Contrato</label>
                <input type="file" class="form-control" id="documento_contrato" name="documento_contrato">
            </div>
            <div class="col-md-4 mb-3">
                <label for="documento_propiedad" class="form-label">Documento de Propiedad</label>
                <input type="file" class="form-control" id="documento_propiedad" name="documento_propiedad">
            </div>
        </div>

        <div class="row">
    <h4>Datos del vehículo</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="servicio_id" class="form-label">Servicio</label>
            <select class="form-select @error('servicio_id') is-invalid @enderror" id="servicio_id" name="servicio_id">
                <option value="">Selecciona un servicio</option>
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                        {{ $servicio->descripcion }}
                    </option>
                @endforeach
            </select>
            @error('servicio_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tipo" class="form-label">Tipo de Vehículo</label>
            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo">
                <option value="">Selecciona un tipo de vehículo</option>
                <option value="Moto" {{ old('tipo') == 'Moto' ? 'selected' : '' }}>Moto</option>
                <option value="Carro" {{ old('tipo') == 'Carro' ? 'selected' : '' }}>Carro</option>
                <option value="SUV" {{ old('tipo') == 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="Camioneta" {{ old('tipo') == 'Camioneta' ? 'selected' : '' }}>Camioneta</option>
                <option value="Deportivo" {{ old('tipo') == 'Deportivo' ? 'selected' : '' }}>Deportivo</option>
                <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('tipo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        @php
            $fields = [
                'marca' => 'Marca',
                'modelo' => 'Modelo',
                'color' => 'Color',
                'placa' => 'Placa',
                'anio' => 'Año',
                'dni2' => 'DNI',
                'numero_cuenta' => 'Número de Cuenta',
                'telefono_emergencia' => 'Teléfono de Emergencia'
            ];
        @endphp

@foreach ($fields as $name => $label)
    <div class="col-md-6 mb-3">
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
        <input type="{{ $name === 'anio' ? 'number' : 'text' }}" 
            class="form-control @error($name) is-invalid @enderror" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ old($name) }}" 
            @if($name === 'color') 
                oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
            @elseif($name === 'telefono_emergencia' || $name === 'numero_cuenta') 
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            @endif>
        @error($name)
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
@endforeach



        @php
            $selectFields = [
                'propietario' => ['SI' => 'Sí', 'NO' => 'No'],
                'banco' => [
                    'Banco de Venezuela', 'Banco Mercantil', 'Bancaribe', 'Banco Provincial',
                    'BBVA', 'Banco Nacional de Crédito (BNC)', 'Banesco', 'Banco del Tesoro',
                    'Banco Exterior', 'Fondo Común', 'Venezolano de Crédito', 'BFC Banco Fondo Común'
                ],
                'tipo_cuenta' => ['CORRIENTE' => 'CORRIENTE', 'AHORRO' => 'AHORRO'],
                'estatus' => ['ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO']
            ];
        @endphp

        @foreach ($selectFields as $name => $options)
            <div class="col-md-6 mb-3">
                <label for="{{ $name }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $name)) }}</label>
                <select class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}">
                    @foreach ($options as $key => $value)
                        @if (is_array($options))
                            <option value="{{ $key }}" {{ old($name) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @else
                            <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
                @error($name)
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
    </div>
</div>

    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Aceptar</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#role').change(function () {
            var selectedRole = $(this).val();

            // Show document upload fields if the selected role is "Conductor"
            if (selectedRole === 'conductor') { // Make sure the value matches the role name
                $('#document-upload-fields').show();
            } else {
                $('#document-upload-fields').hide();
            }
        });
    });

    $(document).ready(function () {
        $('#telefono_emergencia').on('input', function () {
            var telefono = $(this).val();
            var regex = /^(0412|0414|0424|0416|0426)[0-9]{7}$/; // Regex para validar el teléfono venezolano

            if (!regex.test(telefono)) {
                $(this).css('border-color', 'red');
                $(this).next('.error-message').remove(); // Eliminar mensaje de error previo
                $(this).after('<span class="error-message" style="color: red;">El número de teléfono debe ser válido.</span>');
            } else {
                $(this).css('border-color', 'green');
                $(this).next('.error-message').remove(); // Eliminar mensaje de error si es válido
            }
        });
    });
    $(document).ready(function () {
        // Validar placa
        $('#placa').on('input', function () {
            var placa = $(this).val();
            // Expresión regular para la placa (4 letras + 3 números o 4 letras + 4 números)
            var regexPlaca = /^[A-Z]{3,4}-\d{3,4}$/;

            if (!regexPlaca.test(placa)) {
                $(this).css('border-color', 'red');
                $(this).next('.error-message').remove(); // Eliminar mensaje de error previo
                $(this).after('<span class="error-message" style="color: red;">La placa debe seguir el formato válido (ej. ABC-123 o ABCD-1234).</span>');
            } else {
                $(this).css('border-color', 'green');
                $(this).next('.error-message').remove(); // Eliminar mensaje de error si es válido
            }
        });

        // Validar año
        $('#anio').on('input', function () {
            var anio = $(this).val();
            var currentYear = new Date().getFullYear();
            // Verificar que el año esté en el rango válido
            if (anio < 2000 || anio > currentYear) {
                $(this).css('border-color', 'red');
                $(this).next('.error-message').remove(); // Eliminar mensaje de error previo
                $(this).after('<span class="error-message" style="color: red;">El año debe ser mayor o igual a 1900 y menor o igual al año actual.</span>');
            } else {
                $(this).css('border-color', 'green');
                $(this).next('.error-message').remove(); // Eliminar mensaje de error si es válido
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dni').on('input', function () {
            var cedula = $(this).val(); // Obtener el valor del email
            var cedulainput = $(this); // Almacenar el elemento del input
            if (cedula != '') {
                // Realizar la búsqueda mediante AJAX
                $.ajax({
                    url: "/buscarUsuario/" + cedula, // URL actualizada según tu ruta
                    type: "GET",
                    success: function (response) {
                        if (response.data) {
                            cedulainput.addClass('is-invalid');
                            cedulainput.removeClass('is-valid');
                            cedulainput.next('.invalid-feedback').text('Este email ya existe.');
                        } else {
                            // Si no se encuentra el usuario, habilitar los campos y mostrar mensaje
                            cedulainput.removeClass('is-invalid');
                            cedulainput.addClass('is-valid');
                            cedulainput.next('.invalid-feedback').text('');
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