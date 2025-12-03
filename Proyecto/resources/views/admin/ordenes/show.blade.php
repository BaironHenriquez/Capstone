@extends('shared.layouts.admin')

@section('title', 'Orden de Servicio #' . $orden->numero_orden)
@section('breadcrumb', 'Detalles de Orden')

@section('content')
<style>
    .imagen-galeria {
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 0.75rem;
        transition: transform 0.3s ease;
    }
    
    .imagen-galeria:hover {
        transform: scale(1.05);
        cursor: pointer;
    }
    
    .modal-imagen {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
    }
    
    .modal-imagen.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        max-width: 90%;
        max-height: 90vh;
        position: relative;
    }
    
    .modal-content img {
        max-width: 100%;
        max-height: 85vh;
        object-fit: contain;
    }
    
    .close-modal {
        position: absolute;
        right: 20px;
        top: 20px;
        color: white;
        font-size: 28px;
        cursor: pointer;
        background: rgba(0,0,0,0.5);
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 1001;
    }
    
    .close-modal:hover {
        background: rgba(0,0,0,0.8);
    }
    
    .estado-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .estado-pendiente { background-color: #fef3c7; color: #92400e; }
    .estado-asignada { background-color: #dbeafe; color: #1e40af; }
    .estado-en_progreso { background-color: #bfdbfe; color: #1e3a8a; }
    .estado-completada { background-color: #bbf7d0; color: #166534; }
    .estado-cancelada { background-color: #fecaca; color: #991b1b; }
    
    .prioridad-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .prioridad-baja { background-color: #dcfce7; color: #166534; }
    .prioridad-media { background-color: #fef3c7; color: #92400e; }
    .prioridad-alta { background-color: #fed7aa; color: #9a3412; }
    .prioridad-urgente { background-color: #fecaca; color: #991b1b; }
</style>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-4xl font-bold text-gray-900">Orden #{{ $orden->numero_orden }}</h1>
                <p class="text-gray-600 mt-2">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ $orden->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('ordenes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <a href="{{ route('ordenes.edit', $orden->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 text-center">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>

        <!-- Grid de información -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Estado -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Estado</h3>
                <div class="estado-badge estado-{{ $orden->estado }}">
                    {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
                </div>
            </div>

            <!-- Prioridad -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Prioridad</h3>
                <div class="prioridad-badge prioridad-{{ $orden->prioridad }}">
                    {{ ucfirst($orden->prioridad) }}
                </div>
            </div>

            <!-- Técnico -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Técnico Asignado</h3>
                <p class="text-lg font-semibold text-gray-900">
                    @if($orden->tecnico)
                        {{ $orden->tecnico->nombre }}
                    @else
                        <span class="text-gray-500">Sin asignar</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Secciones de información -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Información General -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-gray-200">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Información General
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cliente -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Cliente</label>
                        <p class="text-lg text-gray-900">{{ $orden->cliente->nombre ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $orden->cliente->email ?? '' }}</p>
                    </div>

                    <!-- Equipo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Equipo</label>
                        <p class="text-lg text-gray-900">{{ $orden->equipo->modelo ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $orden->equipo->marca->nombre_marca ?? '' }}</p>
                    </div>

                    <!-- Tipo de Servicio -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Tipo de Servicio</label>
                        <p class="text-lg text-gray-900">{{ ucfirst(str_replace('_', ' ', $orden->tipo_servicio)) }}</p>
                    </div>

                    <!-- Tipo de Trabajo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Tipo de Trabajo</label>
                        <p class="text-lg text-gray-900">{{ $orden->tipo_de_trabajo ?? 'N/A' }}</p>
                    </div>

                    <!-- Descripción del Problema -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Descripción del Problema</label>
                        <p class="text-gray-900 bg-gray-50 p-3 rounded">{{ $orden->descripcion_problema }}</p>
                    </div>
                </div>
            </div>

            <!-- Datos Económicos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-gray-200">
                    <i class="fas fa-dollar-sign text-green-500 mr-2"></i>Datos Económicos
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Precio Presupuestado</label>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($orden->precio_presupuestado, 2) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Abono</label>
                        <p class="text-2xl font-bold text-blue-600">${{ number_format($orden->abono, 2) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600">Saldo Pendiente</label>
                        <p class="text-2xl font-bold text-orange-600">${{ number_format($orden->saldo, 2) }}</p>
                    </div>

                    <div class="pt-4 border-t">
                        <label class="text-sm font-semibold text-gray-600">Medio de Pago</label>
                        <p class="text-lg text-gray-900">{{ $orden->medio_de_pago ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles Adicionales -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-gray-200">
                <i class="fas fa-clipboard-list text-purple-500 mr-2"></i>Detalles Adicionales
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Contacto en Sitio</label>
                    <p class="text-gray-900">{{ $orden->contacto_en_sitio ?? 'N/A' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Teléfono</label>
                    <p class="text-gray-900">{{ $orden->telefono_contacto ?? 'N/A' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Ubicación del Servicio</label>
                    <p class="text-gray-900">{{ $orden->ubicacion_servicio ?? 'N/A' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Horas Estimadas</label>
                    <p class="text-gray-900">{{ $orden->horas_estimadas ?? 'N/A' }} horas</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha Programada</label>
                    <p class="text-gray-900">
                        @if($orden->fecha_programada)
                            {{ \Carbon\Carbon::parse($orden->fecha_programada)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha Aprox. Entrega</label>
                    <p class="text-gray-900">
                        @if($orden->fecha_aprox_entrega)
                            {{ \Carbon\Carbon::parse($orden->fecha_aprox_entrega)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha de Ingreso</label>
                    <p class="text-gray-900">
                        {{ \Carbon\Carbon::parse($orden->fecha_ingreso)->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Creado por</label>
                    <p class="text-gray-900">{{ $orden->user->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Fotos de Ingreso desde Bunny CDN -->
        @if($orden->fotos_ingreso && count($orden->fotos_ingreso) > 0)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b-2 border-gray-200">
                <i class="fas fa-images text-yellow-500 mr-2"></i>Fotos del Ingreso del Equipo
            </h2>

            <p class="text-gray-600 mb-4">Se encontraron <strong>{{ count($orden->fotos_ingreso) }}</strong> imagen(es)</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($orden->fotos_ingreso as $index => $foto)
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow">
                    <img src="{{ $foto }}" 
                         alt="Foto de ingreso {{ $index + 1 }}" 
                         class="imagen-galeria w-full h-full"
                         onclick="abrirModalImagen('{{ $foto }}', 'Foto de ingreso {{ $index + 1 }}')">
                    <div class="p-2 bg-gray-50 text-center">
                        <p class="text-xs text-gray-600">Foto {{ $index + 1 }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6 mb-8">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-yellow-500 mr-3 text-xl"></i>
                <div>
                    <h3 class="font-semibold text-yellow-800">No hay fotos de ingreso</h3>
                    <p class="text-yellow-700 text-sm">Esta orden no tiene fotos del equipo al momento del ingreso.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal para ver imágenes en grande -->
        <div id="modalImagen" class="modal-imagen">
            <div class="modal-content">
                <span class="close-modal" onclick="cerrarModalImagen()">&times;</span>
                <img id="imagenModal" src="" alt="Imagen ampliada">
            </div>
        </div>

    </div>
</div>

<script>
function abrirModalImagen(src, alt) {
    const modal = document.getElementById('modalImagen');
    const img = document.getElementById('imagenModal');
    img.src = src;
    img.alt = alt;
    modal.classList.add('active');
}

function cerrarModalImagen() {
    const modal = document.getElementById('modalImagen');
    modal.classList.remove('active');
}

// Cerrar modal al presionar ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        cerrarModalImagen();
    }
});

// Cerrar modal al hacer click fuera de la imagen
document.getElementById('modalImagen')?.addEventListener('click', function(event) {
    if (event.target === this) {
        cerrarModalImagen();
    }
});
</script>
@endsection
