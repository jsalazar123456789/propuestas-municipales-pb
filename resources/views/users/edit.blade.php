@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-user-edit text-warning"></i> Editar Usuario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}"><i class="fas fa-users"></i> Usuarios</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning card-outline shadow-lg">
                <div class="card-header bg-gradient-warning">
                    <h3 class="card-title text-dark"><i class="fas fa-user-edit"></i> Editar Usuario: {{ $user->name }}</h3>
                </div>
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-user text-primary"></i> Nombre Completo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-envelope text-info"></i> Correo Electrónico</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-shield-alt text-success"></i> Rol del Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white"><i class="fas fa-shield-alt"></i></span>
                                </div>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="Administrador" {{ old('role', $user->role) === 'Administrador' ? 'selected' : '' }}>
                                        Administrador
                                    </option>
                                    <option value="Amigo" {{ old('role', $user->role) === 'Amigo' ? 'selected' : '' }}>
                                        Amigo
                                    </option>
                                </select>
                            </div>
                            @error('role')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="text-muted"><i class="fas fa-key"></i> Cambiar Contraseña (Opcional)</h5>
                        
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-lock text-warning"></i> Nueva Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-dark"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Dejar vacío para mantener la actual">
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-lock text-warning"></i> Confirmar Nueva Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-dark"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password_confirmation" class="form-control" 
                                       placeholder="Confirmar nueva contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning btn-lg btn-block">
                                    <i class="fas fa-save"></i> Actualizar Usuario
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg btn-block">
                                    <i class="fas fa-arrow-left"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop