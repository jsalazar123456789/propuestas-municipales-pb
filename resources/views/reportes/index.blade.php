@extends('adminlte::page')

@section('title', 'Reportes de Propuestas')

@section('content_header')
    <h1><i class="fas fa-chart-bar text-primary"></i> Reportes y Estadísticas</h1>
@stop

@section('content')
    <!-- Resumen General -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPropuestas }}</h3>
                    <p>Total Propuestas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $propuestasPorEstado->where('estado', 'aprobada')->first()->total ?? 0 }}</h3>
                    <p>Aprobadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $propuestasPorEstado->where('estado', 'pendiente')->first()->total ?? 0 }}</h3>
                    <p>Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $propuestasPorEstado->where('estado', 'rechazada')->first()->total ?? 0 }}</h3>
                    <p>Rechazadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Propuestas por Categoría -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tags"></i> Propuestas por Categoría</h3>
                </div>
                <div class="card-body">
                    @if($propuestasPorCategoria->count() > 0)
                        @foreach($propuestasPorCategoria as $categoria)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="font-weight-bold">{{ $categoria->nombre }}</span>
                                    <span class="badge badge-primary">{{ $categoria->propuestas_count }} ({{ $categoria->porcentaje }}%)</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ $categoria->porcentaje }}%" 
                                         aria-valuenow="{{ $categoria->porcentaje }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $categoria->porcentaje }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No hay propuestas registradas</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Gráfico de Estados -->
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Estados</h3>
                </div>
                <div class="card-body">
                    <canvas id="estadosChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Propuestas por Mes -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Propuestas por Mes (Últimos 12 meses)</h3>
                </div>
                <div class="card-body">
                    <canvas id="mesesChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Propuestas Detalladas por Categoría -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list-alt"></i> Propuestas Detalladas por Categoría</h3>
                </div>
                <div class="card-body">
                    @foreach($propuestasPorCategoria as $categoria)
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-tag"></i> {{ $categoria->nombre }} 
                                <span class="badge badge-primary ml-2">{{ $categoria->propuestas_count }} propuestas</span>
                            </h5>
                            
                            <div class="row">
                                @foreach($categoria->propuestas as $propuesta)
                                    <div class="col-md-6 mb-3">
                                        <div class="card card-outline 
                                            @if($propuesta->estado === 'aprobada') card-success
                                            @elseif($propuesta->estado === 'rechazada') card-danger
                                            @else card-warning @endif">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="card-title mb-0">
                                                        <strong>{{ $propuesta->numero }}</strong> - {{ $propuesta->titulo }}
                                                    </h6>
                                                    {!! $propuesta->estadoBadge !!}
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-justify">{{ Str::limit($propuesta->descripcion, 150) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-user"></i> 
                                                        {{ $propuesta->user ? $propuesta->user->name : 'Sin asignar' }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> 
                                                        {{ $propuesta->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="{{ route('propuestas.show', $propuesta) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Ver detalles
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Resumen -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table"></i> Resumen Estadístico por Categoría</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Categoría</th>
                                <th>Total</th>
                                <th>Porcentaje</th>
                                <th>Aprobadas</th>
                                <th>Pendientes</th>
                                <th>Rechazadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propuestasPorCategoria as $categoria)
                                <tr>
                                    <td><strong>{{ $categoria->nombre }}</strong></td>
                                    <td><span class="badge badge-primary">{{ $categoria->propuestas_count }}</span></td>
                                    <td>{{ $categoria->porcentaje }}%</td>
                                    <td><span class="badge badge-success">{{ $categoria->propuestas->where('estado', 'aprobada')->count() }}</span></td>
                                    <td><span class="badge badge-warning">{{ $categoria->propuestas->where('estado', 'pendiente')->count() }}</span></td>
                                    <td><span class="badge badge-danger">{{ $categoria->propuestas->where('estado', 'rechazada')->count() }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Estados
    const estadosCtx = document.getElementById('estadosChart').getContext('2d');
    new Chart(estadosCtx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($propuestasPorEstado as $estado)
                    '{{ ucfirst($estado->estado) }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($propuestasPorEstado as $estado)
                        {{ $estado->total }},
                    @endforeach
                ],
                backgroundColor: [
                    '#28a745', // Aprobada - Verde
                    '#ffc107', // Pendiente - Amarillo
                    '#dc3545'  // Rechazada - Rojo
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de Meses
    const mesesCtx = document.getElementById('mesesChart').getContext('2d');
    new Chart(mesesCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($propuestasPorMes->reverse() as $mes)
                    '{{ $mes->mes }}/{{ $mes->año }}',
                @endforeach
            ],
            datasets: [{
                label: 'Propuestas',
                data: [
                    @foreach($propuestasPorMes->reverse() as $mes)
                        {{ $mes->total }},
                    @endforeach
                ],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@stop