@extends('adminlte::page')

@section('title', 'Propuestas Municipales')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-lightbulb text-warning"></i> 
            @if(auth()->user()->isAdmin())
                Todas las Propuestas
            @else
                Mis Propuestas
            @endif
        </h1>
        <a href="{{ route('propuestas.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Nueva Propuesta
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-table"></i> Lista de Propuestas</h3>
        </div>
        <div class="card-body table-responsive">
            <table id="propuestasTable" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> Número</th>
                        <th><i class="fas fa-heading"></i> Título</th>
                        <th><i class="fas fa-tags"></i> Categoría</th>
                        <th><i class="fas fa-user"></i> Creado por</th>
                        <th><i class="fas fa-check-circle"></i> Estado</th>
                        <th><i class="fas fa-align-left"></i> Descripción</th>
                        <th><i class="fas fa-calendar"></i> Fecha</th>
                        <th><i class="fas fa-images"></i> Fotos</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propuestas as $propuesta)
                        <tr>
                            <td><span class="badge badge-primary badge-lg">{{ $propuesta->numero }}</span></td>
                            <td><strong>{{ $propuesta->titulo }}</strong></td>
                            <td><span class="badge badge-info">{{ $propuesta->categoria->nombre }}</span></td>
                            <td>
                                @if($propuesta->user)
                                    <span class="badge badge-success">{{ $propuesta->user->name }}</span>
                                @else
                                    <span class="badge badge-secondary">Sin asignar</span>
                                @endif
                            </td>
                            <td>{!! $propuesta->estadoBadge !!}</td>
                            <td>{{ Str::limit($propuesta->descripcion, 80) }}</td>
                            <td><small class="text-muted">{{ $propuesta->created_at->format('d/m/Y H:i') }}</small></td>
                            <td class="text-center">
                                @if($propuesta->foto1)
                                    <img src="{{ asset('storage/' . $propuesta->foto1) }}" class="img-thumbnail" width="50" data-toggle="modal" data-target="#imageModal{{ $propuesta->id }}" style="cursor: pointer;">
                                @endif
                                @if($propuesta->foto2)
                                    <img src="{{ asset('storage/' . $propuesta->foto2) }}" class="img-thumbnail ml-1" width="50" data-toggle="modal" data-target="#imageModal{{ $propuesta->id }}" style="cursor: pointer;">
                                @endif
                                @if(!$propuesta->foto1 && !$propuesta->foto2)
                                    <span class="text-muted"><i class="fas fa-image"></i> Sin fotos</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('propuestas.show', $propuesta) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        @if($propuesta->estado === 'pendiente')
                                            <form action="{{ route('propuestas.aprobar', $propuesta) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Aprobar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('propuestas.rechazar', $propuesta) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="Rechazar">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#propuestasTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "scrollX": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop