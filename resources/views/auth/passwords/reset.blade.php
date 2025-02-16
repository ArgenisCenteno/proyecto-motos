@extends('layouts.app')

@section('content')
<section class="vh-100 d-flex align-items-center justify-content-center" style="padding-top: 6rem;">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <!-- Imagen (Oculta en pantallas pequeñas) -->
            <div class="col-md-6 d-none d-md-block">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" 
                     class="img-fluid" alt="Reset Password Image">
            </div>

            <!-- Formulario de Reset Password -->
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Restablecer Contraseña</h4>
                            <p class="text-muted">Ingresa tu nueva contraseña</p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ $email ?? old('email') }}" required autofocus>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nueva Contraseña -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="form-group mb-3">
                                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required>
                            </div>

                            <!-- Botón Restablecer -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Restablecer Contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 small">© {{ date('Y') }} Los Combatientes de Punta de Mata</p>
            </div>
        </div>
    </div>
</section>
@endsection
