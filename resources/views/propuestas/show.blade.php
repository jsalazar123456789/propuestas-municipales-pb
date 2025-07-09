@extends('adminlte::page')

@section('title', 'Propuesta ' . $propuesta->numero)

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-lightbulb text-warning"></i> 
                        Propuesta {{ $propuesta->numero }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('propuestas.index') }}"><i class="fas fa-list"></i> Propuestas</a></li>
                        <li class="breadcrumb-item active">{{ $propuesta->numero }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <div class="card card-primary card-outline shadow-lg">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-info-circle"></i> Información de la Propuesta
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ $propuesta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Título -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fas fa-heading"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-white">Título</span>
                                    <span class="info-box-number text-white">{{ $propuesta->titulo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-success">
                                <span class="info-box-icon"><i class="fas fa-tags"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-white">Categoría</span>
                                    <span class="info-box-number text-white">{{ $propuesta->categoria->nombre }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-warning">
                                <span class="info-box-icon"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-dark">Creado por</span>
                                    <span class="info-box-number text-dark">
                                        @if($propuesta->user)
                                            {{ $propuesta->user->name }}
                                        @else
                                            Sin asignar
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="info-box 
                                @if($propuesta->estado === 'aprobada') bg-gradient-success
                                @elseif($propuesta->estado === 'rechazada') bg-gradient-danger
                                @else bg-gradient-warning @endif">
                                <span class="info-box-icon">
                                    @if($propuesta->estado === 'aprobada')
                                        <i class="fas fa-check-circle"></i>
                                    @elseif($propuesta->estado === 'rechazada')
                                        <i class="fas fa-times-circle"></i>
                                    @else
                                        <i class="fas fa-clock"></i>
                                    @endif
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-white">Estado de la Propuesta</span>
                                    <span class="info-box-number text-white text-uppercase">{{ $propuesta->estado }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-align-left"></i> Descripción Detallada
                        </h5>
                        <div class="card card-light">
                            <div class="card-body">
                                <p class="text-justify" style="line-height: 1.8;">{{ $propuesta->descripcion }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    @if($propuesta->observaciones)
                        <div class="mb-4">
                            <h5 class="text-warning">
                                <i class="fas fa-sticky-note"></i> Observaciones Adicionales
                            </h5>
                            <div class="card card-warning card-outline">
                                <div class="card-body">
                                    <p class="text-justify" style="line-height: 1.8;">{{ $propuesta->observaciones }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Estadísticas -->
            <div class="card card-success card-outline shadow">
                <div class="card-header bg-gradient-success">
                    <h3 class="card-title text-white">
                        <i class="fas fa-chart-bar"></i> Estadísticas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-success">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <h5 class="description-header">{{ $propuesta->created_at->diffForHumans() }}</h5>
                                <span class="description-text">CREADA</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <span class="description-percentage text-info">
                                    <i class="fas fa-eye"></i>
                                </span>
                                <h5 class="description-header">{{ rand(15, 150) }}</h5>
                                <span class="description-text">VISTAS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="card card-warning card-outline shadow">
                <div class="card-header bg-gradient-warning">
                    <h3 class="card-title text-dark">
                        <i class="fas fa-cogs"></i> Acciones
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(auth()->user()->isAdmin() && $propuesta->estado === 'pendiente')
                            <form action="{{ route('propuestas.aprobar', $propuesta) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block mb-2">
                                    <i class="fas fa-check"></i> Aprobar Propuesta
                                </button>
                            </form>
                            <form action="{{ route('propuestas.rechazar', $propuesta) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block mb-2">
                                    <i class="fas fa-times"></i> Rechazar Propuesta
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('propuestas.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Volver a Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Galería de Fotos -->
    @if($propuesta->foto1 || $propuesta->foto2)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-purple card-outline shadow-lg">
                    <div class="card-header bg-gradient-purple">
                        <h3 class="card-title text-white">
                            <i class="fas fa-images"></i> Galería de Fotos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($propuesta->foto1)
                                <div class="col-md-6 mb-3">
                                    <div class="card card-light">
                                        <div class="card-header text-center">
                                            <h5><i class="fas fa-camera"></i> Foto Principal</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{ asset('storage/' . $propuesta->foto1) }}" 
                                                 class="img-fluid rounded shadow" 
                                                 style="max-height: 300px; cursor: pointer;"
                                                 data-toggle="modal" 
                                                 data-target="#imageModal1">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($propuesta->foto2)
                                <div class="col-md-6 mb-3">
                                    <div class="card card-light">
                                        <div class="card-header text-center">
                                            <h5><i class="fas fa-images"></i> Foto Secundaria</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{ asset('storage/' . $propuesta->foto2) }}" 
                                                 class="img-fluid rounded shadow" 
                                                 style="max-height: 300px; cursor: pointer;"
                                                 data-toggle="modal" 
                                                 data-target="#imageModal2">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modales para imágenes -->
    @if($propuesta->foto1)
        <div class="modal fade" id="imageModal1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title text-white">
                            <i class="fas fa-camera"></i> {{ $propuesta->titulo }} - Foto Principal
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="{{ asset('storage/' . $propuesta->foto1) }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($propuesta->foto2)
        <div class="modal fade" id="imageModal2">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title text-white">
                            <i class="fas fa-images"></i> {{ $propuesta->titulo }} - Foto Secundaria
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="{{ asset('storage/' . $propuesta->foto2) }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
        }
        .info-box {
            border-radius: 10px;
        }
        .description-block {
            text-align: center;
        }
        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
        .bg-gradient-purple {
            background: linear-gradient(45deg, #6f42c1, #e83e8c) !important;
        }
        .card-purple {
            border-color: #6f42c1;
        }
        .text-justify {
            text-align: justify;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Efecto de hover en las imágenes
            $('img[data-toggle="modal"]').hover(
                function() {
                    $(this).css('transform', 'scale(1.05)');
                    $(this).css('transition', 'transform 0.3s ease');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );
        });
    </script>
@stop