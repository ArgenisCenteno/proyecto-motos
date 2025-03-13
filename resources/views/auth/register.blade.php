@extends('layouts.app')

@section('content')
@php
  use App\Models\Sector;
  $sectores = Sector::all(); // Obtener los sectores
@endphp

<!-- Section: Design Block -->
<section class="text-center bg-light" style="margin-top: 100px;">
  <div class="mx-4 mx-md-5 shadow-5-strong bg-body-tertiary" style="backdrop-filter: blur(30px);">
    <div class="py-5 px-md-5 pr-md-5">
      <div class="row d-flex justify-content-center pt-5 pb-5" style="border-radius: 12px; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
        <div class="col-lg-8">
          <h2 class="fw-bold mb-5">Formulario de Registro</h2>

          <!-- Formulario de registro -->
          <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
            @csrf <!-- Token CSRF para Laravel -->

            <!-- Grupo de Nombre, Cédula y Email -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="name"><strong>Nombre</strong></label>
                  <input type="text" id="name" name="name" placeholder="Ingrese nombre" class="form-control" required pattern="^[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+$" />
                  @error('name')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                  <small class="text-danger" id="nameError" style="display:none;">El nombre solo debe contener letras y espacios.</small>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="cedula"><strong>Cédula</strong></label>
                  <input type="text" id="cedula" name="cedula" placeholder="Ingrese cédula" class="form-control" required pattern="^[0-9]{7,8}$" />
                  @error('cedula')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                  <small class="text-danger" id="cedulaError" style="display:none;">La cédula debe ser un número de 7 u 8 dígitos.</small>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="email"><strong>Email</strong></label>
                  <input type="email" id="email" name="email" placeholder="Ingrese email" class="form-control" required />
                  @error('email')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Grupo de Teléfono, Sector y Calle -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="phone"><strong>Teléfono</strong></label>
                  <input type="text" id="phone" name="telefono" class="form-control" placeholder="Ingrese teléfono" required pattern="^(0412|0424|0416|0426|0414)[0-9]{7}$" />
                  @error('telefono')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                  <small class="text-danger" id="phoneError" style="display:none;">El teléfono debe tener el formato: 0412xxxxxxx, 0424xxxxxxx, 0416xxxxxxx, 0426xxxxxxx, 0414xxxxxxx.</small>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="sector"><strong>Sector</strong></label>
                  <select id="sector" name="sector" class="form-control" required>
                    <option value="" disabled selected>Seleccione un sector</option>
                    @foreach($sectores as $sector)
                      <option value="{{ $sector->nombre }}">{{ $sector->nombre }}</option>
                    @endforeach
                  </select>
                  @error('sector')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="calle"><strong>Calle</strong></label>
                  <input type="text" id="calle" name="calle" placeholder="Ingrese calle" class="form-control" />
                  @error('calle')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Grupo de Casa, Contraseña y Género -->
            <div class="row mb-4">
              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="casa"><strong>Casa</strong></label>
                  <input type="text" id="casa" name="casa" placeholder="Ingrese casa" class="form-control" />
                  @error('casa')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="password"><strong>Contraseña</strong></label>
                  <input type="password" id="password" name="password" placeholder="Ingrese contraseña" class="form-control" required minlength="8" />
                  @error('password')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                  <small class="text-danger" id="passwordError" style="display:none;">La contraseña debe tener al menos 8 caracteres.</small>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-outline">
                  <label class="form-label" for="gender"><strong>Género</strong></label>
                  <select id="gender" name="genero" class="form-control" required>
                    <option value="" disabled selected>Seleccione su género</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                  </select>
                  @error('genero')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-dark btn-lg mb-4" id="submitButton" disabled>Registrarse</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  const form = document.getElementById('registerForm');
  const submitButton = document.getElementById('submitButton');

  form.addEventListener('input', () => {
    const nameValid = form.name.validity.valid;
    const cedulaValid = form.cedula.validity.valid;
    const phoneValid = form.telefono.validity.valid;
    const passwordValid = form.password.validity.valid;

    if (nameValid && cedulaValid && phoneValid && passwordValid) {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
    }

    document.getElementById('nameError').style.display = nameValid ? 'none' : 'block';
    document.getElementById('cedulaError').style.display = cedulaValid ? 'none' : 'block';
    document.getElementById('phoneError').style.display = phoneValid ? 'none' : 'block';
    document.getElementById('passwordError').style.display = passwordValid ? 'none' : 'block';
  });
</script>
@endsection
