@extends('layouts.app')

@section('content')
<section class="vh-100 d-flex align-items-center justify-content-center" style="padding-top: 8rem;">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 col-lg-6 col-xl-5 d-none d-md-block">
                <img src="{{ asset('iconos/reset.avif') }}" 
                     class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="mt-3">¿Olvidaste tu contraseña?</h4>
                            <p class="text-muted">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" id="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autofocus 
                                       placeholder="Ingresa tu correo">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar enlace</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted">Volver al inicio de sesión</a>
                        </div>
                    </div>
                </div>
                <p class="text-center text-muted mt-3 small">© {{ date('Y') }} Los Combatientes de Punta de Mata</p>
            </div>
        </div>
    </div>
</section>
@endsection
