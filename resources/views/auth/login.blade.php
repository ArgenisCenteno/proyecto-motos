@extends('layouts.app')

@section('content')
<section class="vh-100 p-0  bg-light" >
  <div class="container-fluid">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-sm-6 text-black">

        <div class="d-flex align-items-center justify-content-center h-custom-2 px-5 mt-5 pt-5  pb-5" style=" border-radius: 20px; margin-top: 120px !important; box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">

          <!-- Formulario de inicio de sesión -->
          <form method="POST" action="{{ route('login') }}" style="width: 23rem;">
            @csrf <!-- Agregar token CSRF obligatorio -->

            <h3 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;"><strong>Delivery</strong></h3>

            <!-- Campo de correo electrónico -->
            <div class="form-outline mb-4">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="Ingrese email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus />
              @error('email')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
            </div>

            <!-- Campo de contraseña -->
            <div class="form-outline mb-4">
              <label class="form-label" for="password">Contraseña</label>
              <input type="password" id="password" name="password" placeholder="Ingrese Contraseña" class="form-control form-control-lg" required />
              @error('password')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
            </div>

            <!-- Botón de inicio de sesión -->
            <div class="pt-1 mb-4">
              <button class="btn btn-dark btn-lg btn-block" >Acceder</button>
            </div>

            <!-- Enlace para recuperar la contraseña -->
           

            <!-- Enlace para registrarse -->
            <p>¿No tienes cuenta? <a href="{{ route('register') }}" class="link-info">Registrarse</a></p>
          </form>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
