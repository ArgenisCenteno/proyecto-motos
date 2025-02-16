@extends('layouts.app')

@section('content')
<section class="vh-100 d-flex align-items-center justify-content-center" style="padding-top: 6rem;">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <!-- Imagen (Oculta en pantallas pequeñas) -->
            <div class="col-md-6 d-none d-md-block">
                <img src="iconos/login.avif" 
                     class="img-fluid" alt="Sample image">
            </div>

            <!-- Formulario de Login -->
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Bienvenido de nuevo</h4>
                            <p class="text-muted">Inicia sesión para continuar</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autofocus placeholder="Ingresa tu correo">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror" required
                                       placeholder="Ingresa tu contraseña">
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Recordar y Olvidaste contraseña -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Recordar</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-muted">¿Olvidaste tu contraseña?</a>
                            </div>

                            <!-- Botón de Login -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Iniciar sesión</button>
                            </div>

                            <!-- Registro -->
                            <div class="text-center mt-3">
                                <p class="small">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-primary">Regístrate</a></p>
                            </div>
                        </form>

                        <!-- Login con redes sociales -->
                       
                    </div>
                </div>

                <p class="text-center text-muted mt-3 small">© {{ date('Y') }} Los Combatientes de Punta de Mata</p>
            </div>
        </div>
    </div>
</section>
@endsection
