@extends('adminlte::page')

@section('title', 'Nueva Propuesta')

@section('adminlte_css_pre')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-lightbulb text-warning"></i> Nueva Propuesta Municipal</h1>
                    <p class="text-muted">Comparte tu idea para mejorar nuestro municipio</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('propuestas.index') }}"><i class="fas fa-home"></i> Propuestas</a></li>
                        <li class="breadcrumb-item active">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary card-outline shadow-lg">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title text-white"><i class="fas fa-edit"></i> Formulario de Propuesta</h3>
                    <div class="card-tools">
                        <span class="badge badge-light">Paso 1 de 1</span>
                    </div>
                </div>
                <form action="{{ route('propuestas.store') }}" method="POST" enctype="multipart/form-data" id="propuestaForm">
                    @csrf
                    <div class="card-body">
                        <!-- Título -->
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-heading text-primary"></i> Título de la Propuesta</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-pen"></i></span>
                                </div>
                                <input type="text" name="titulo" class="form-control form-control-lg @error('titulo') is-invalid @enderror" placeholder="Ej: Mejora del parque central" value="{{ old('titulo') }}" required>
                            </div>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Describe brevemente tu propuesta</small>
                        </div>

                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-tags text-info"></i> Categoría</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-list"></i></span>
                                </div>
                                <select name="categoria_id" class="form-control form-control-lg @error('categoria_id') is-invalid @enderror" required>
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#categoriaModal" title="Agregar nueva categoría">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-align-left text-success"></i> Descripción Detallada</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white"><i class="fas fa-file-alt"></i></span>
                                </div>
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="5" placeholder="Explica detalladamente tu propuesta, qué problema resuelve y cómo beneficiaría al municipio..." required>{{ old('descripcion') }}</textarea>
                            </div>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Mínimo 50 caracteres</small>
                        </div>

                        <!-- Observaciones -->
                        <div class="form-group">
                            <label class="font-weight-bold"><i class="fas fa-sticky-note text-warning"></i> Observaciones Adicionales</label>
                            <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="3" placeholder="Comentarios adicionales, sugerencias de implementación, etc. (Opcional)">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Campo opcional para comentarios adicionales</small>
                        </div>

                        <!-- Fotos -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold"><i class="fas fa-camera text-purple"></i> Foto Principal</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto1" class="custom-file-input" id="foto1" accept="image/*" onchange="previewImage(this, 'preview1')">
                                        <label class="custom-file-label" for="foto1">Seleccionar imagen...</label>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <div id="preview1-container" class="preview-container" style="display: none;">
                                            <img id="preview1" class="img-thumbnail shadow" style="max-width: 200px; max-height: 200px;">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('foto1', 'preview1')">
                                                    <i class="fas fa-trash"></i> Quitar
                                                </button>
                                            </div>
                                        </div>
                                        <div id="placeholder1" class="upload-placeholder">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                            <p class="text-muted mt-2 mb-1"><strong>Arrastra una imagen aquí</strong></p>
                                            <p class="text-muted small">o haz clic para seleccionar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold"><i class="fas fa-images text-purple"></i> Foto Secundaria</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto2" class="custom-file-input" id="foto2" accept="image/*" onchange="previewImage(this, 'preview2')">
                                        <label class="custom-file-label" for="foto2">Seleccionar imagen...</label>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <div id="preview2-container" class="preview-container" style="display: none;">
                                            <img id="preview2" class="img-thumbnail shadow" style="max-width: 200px; max-height: 200px;">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('foto2', 'preview2')">
                                                    <i class="fas fa-trash"></i> Quitar
                                                </button>
                                            </div>
                                        </div>
                                        <div id="placeholder2" class="upload-placeholder">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                            <p class="text-muted mt-2 mb-1"><strong>Arrastra una imagen aquí</strong></p>
                                            <p class="text-muted small">o haz clic para seleccionar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    <i class="fas fa-paper-plane"></i> Enviar Propuesta
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('propuestas.index') }}" class="btn btn-secondary btn-lg btn-block">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para nueva categoría -->
    <div class="modal fade" id="categoriaModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-gradient-success">
                    <h4 class="modal-title text-white"><i class="fas fa-plus-circle"></i> Nueva Categoría</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fas fa-tag"></i> Nombre de la Categoría</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-tags"></i></span>
                            </div>
                            <input type="text" id="nuevaCategoria" class="form-control form-control-lg" placeholder="Ej: Deportes y Recreación">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="crearCategoria()">
                        <i class="fas fa-check"></i> Crear Categoría
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .upload-placeholder {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .upload-placeholder:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
            transform: scale(1.02);
        }
        .upload-placeholder.drag-over {
            border-color: #28a745;
            background-color: #e8f5e8;
            transform: scale(1.05);
        }
        .preview-container {
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 15px;
            background-color: #f8fff9;
        }
        .card {
            border-radius: 15px;
        }
        .input-group-text {
            border-radius: 8px 0 0 8px;
        }
        .form-control {
            border-radius: 0 8px 8px 0;
        }
        .btn {
            border-radius: 8px;
        }
        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Actualizar etiquetas de archivos
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Validación del formulario
            $('#propuestaForm').on('submit', function(e) {
                let descripcion = $('textarea[name="descripcion"]').val();
                if (descripcion.length < 50) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Descripción muy corta',
                        text: 'La descripción debe tener al menos 50 caracteres'
                    });
                    return false;
                }
            });

            // Configurar drag & drop para ambas áreas
            setupDragDrop('placeholder1', 'foto1', 'preview1');
            setupDragDrop('placeholder2', 'foto2', 'preview2');
            
            // Hacer clickeables los placeholders
            $('#placeholder1').click(function() {
                $('#foto1').click();
            });
            $('#placeholder2').click(function() {
                $('#foto2').click();
            });
        });

        function setupDragDrop(placeholderId, inputId, previewId) {
            const placeholder = document.getElementById(placeholderId);
            const input = document.getElementById(inputId);

            // Eventos de drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                placeholder.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                placeholder.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                placeholder.addEventListener(eventName, unhighlight, false);
            });

            placeholder.addEventListener('drop', function(e) {
                handleDrop(e, inputId, previewId);
            }, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                placeholder.style.borderColor = '#007bff';
                placeholder.style.backgroundColor = '#e3f2fd';
                placeholder.style.transform = 'scale(1.02)';
            }

            function unhighlight() {
                placeholder.style.borderColor = '#ddd';
                placeholder.style.backgroundColor = '';
                placeholder.style.transform = 'scale(1)';
            }
        }

        function handleDrop(e, inputId, previewId) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const input = document.getElementById(inputId);
            
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    // Crear un nuevo FileList
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    input.files = dataTransfer.files;
                    
                    // Actualizar etiqueta del archivo
                    const label = document.querySelector('label[for="' + inputId + '"]');
                    label.innerHTML = file.name;
                    label.classList.add('selected');
                    
                    // Mostrar preview
                    previewImage(input, previewId);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo inválido',
                        text: 'Por favor selecciona solo archivos de imagen'
                    });
                }
            }
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const container = document.getElementById(previewId + '-container');
            const placeholder = document.getElementById('placeholder' + previewId.slice(-1));
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage(inputId, previewId) {
            document.getElementById(inputId).value = '';
            document.getElementById(previewId + '-container').style.display = 'none';
            document.getElementById('placeholder' + previewId.slice(-1)).style.display = 'block';
            document.querySelector('label[for="' + inputId + '"]').innerHTML = 'Seleccionar imagen...';
        }

        function crearCategoria() {
            const nombre = $('#nuevaCategoria').val().trim();
            
            if (!nombre) {
                alert('Por favor ingresa el nombre de la categoría');
                return;
            }

            $.post({
                url: '{{ route("categorias.store") }}',
                data: {
                    nombre: nombre,
                    _token: '{{ csrf_token() }}'
                }
            })
            .done(function(data) {
                const select = $('select[name="categoria_id"]');
                select.append($('<option>', {
                    value: data.id,
                    text: data.nombre,
                    selected: true
                }));
                $('#nuevaCategoria').val('');
                $('#categoriaModal').modal('hide');
                alert('Categoría "' + data.nombre + '" creada exitosamente');
            })
            .fail(function(xhr) {
                console.error('Error:', xhr.responseText);
                alert('Error al crear la categoría: ' + (xhr.responseJSON?.message || 'Error desconocido'));
            });
        }
    </script>
@stop