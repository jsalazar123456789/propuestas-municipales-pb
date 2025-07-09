@extends('adminlte::auth.register')

@section('auth_header', 'Registrar Usuario')
@section('auth_body')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   placeholder="Nombre completo" value="{{ old('name') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                   placeholder="Correo electrónico" value="{{ old('email') }}" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" 
                   placeholder="Confirmar contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-8">
                <p class="mb-0">
                    <a href="{{ route('login') }}" class="text-center">¿Ya tienes cuenta?</a>
                </p>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
        </div>
    </form>
@stop
