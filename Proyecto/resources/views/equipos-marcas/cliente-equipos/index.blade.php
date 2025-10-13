@extends('layouts.admin')

@section('title', 'Asociaciones Cliente-Equipo')
@section('breadcrumb', 'Cliente-Equipos')

@push('styles')
<style>
    .association-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }
    
    .association-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-weight: 600;
    }
    
    .warranty-active { background-color: #dcfce7; color: #166534; }
    .warranty-expired { background-color: #fee2e2; color: #dc2626; }
    .warranty-soon { background-color: #fef3c7; color: #d97706; }
    
    .timeline-item {
        border-left: 3px solid #e5e7eb;
        padding-left: 1rem;
        padding-bottom: 1rem;
        position: relative;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #3b82f6;
    }
    
    .client-info {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .equipment-info {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
</style>
@endpush

<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Asociaciones Cliente-Equipo</h1>
                    <p class="text-gray-600 mt-2">Administra las relaciones entre clientes y sus equipos</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('equipos-marcas.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                    </a>
                    <a href="{{ route('equipos-marcas.cliente-equipos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
                        <i class="fas fa-plus mr-2"></i>Nueva Asociación
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas generales -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Total Asociaciones</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $clienteEquipos->count() }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-link text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Garantías Activas</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $clienteEquipos->filter(function($ce) { return $ce->warranty_status === 'active'; })->count() }}
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Por Vencer</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $clienteEquipos->filter(function($ce) { return $ce->warranty_status === 'soon'; })->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Garantías Vencidas</h3>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $clienteEquipos->filter(function($ce) { return $ce->warranty_status === 'expired'; })->count() }}
                        </p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Buscar
                    </label>
                    <input type="text" id="search" placeholder="Cliente, equipo, número de serie..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="warranty_filter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shield-alt mr-1"></i>Estado de Garantía
                    </label>
                    <select id="warranty_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los estados</option>
                        <option value="active">Garantía Activa</option>
                        <option value="soon">Por Vencer (30 días)</option>
                        <option value="expired">Garantía Vencida</option>
                    </select>
                </div>
                <div>
                    <label for="maintenance_filter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-wrench mr-1"></i>Mantenimiento
                    </label>
                    <select id="maintenance_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Cualquier estado</option>
                        <option value="needed">Mantenimiento Requerido</option>
                        <option value="recent">Mantenimiento Reciente</option>
                        <option value="overdue">Mantenimiento Atrasado</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4">
                <button onclick="limpiarFiltros()" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-times-circle mr-1"></i>Limpiar filtros
                </button>
                <div class="text-sm text-gray-600">
                    <span id="resultados-count">{{ $clienteEquipos->count() }}</span> asociaciones encontradas
                </div>
            </div>
        </div>

        <!-- Lista de asociaciones -->
        <div id="asociaciones-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($clienteEquipos as $clienteEquipo)
                <div class="association-card rounded-lg shadow-sm p-6" 
                     data-warranty="{{ $clienteEquipo->warranty_status }}"
                     data-maintenance="{{ $clienteEquipo->maintenance_status }}"
                     data-search="{{ strtolower($clienteEquipo->cliente->nombre . ' ' . $clienteEquipo->cliente->apellido . ' ' . $clienteEquipo->equipo->nombre . ' ' . $clienteEquipo->numero_serie) }}">
                    
                    <!-- Información del cliente -->
                    <div class="client-info">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-lg">
                                    <i class="fas fa-user mr-2"></i>{{ $clienteEquipo->cliente->nombre }} {{ $clienteEquipo->cliente->apellido }}
                                </h3>
                                <p class="text-blue-100">{{ $clienteEquipo->cliente->email }}</p>
                                <p class="text-blue-100">{{ $clienteEquipo->cliente->telefono }}</p>
                            </div>
                            <a href="{{ route('equipos-marcas.cliente-equipos.show', $clienteEquipo->id) }}" 
                               class="bg-white bg-opacity-20 hover:bg-opacity-30 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>Ver Detalles
                            </a>
                        </div>
                    </div>

                    <!-- Información del equipo -->
                    <div class="equipment-info">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold">
                                    <i class="fas fa-laptop mr-2"></i>{{ $clienteEquipo->equipo->nombre }}
                                </h4>
                                <p class="text-green-100">{{ $clienteEquipo->equipo->modelo }}</p>
                                <p class="text-green-100">
                                    <i class="fas fa-tag mr-1"></i>{{ $clienteEquipo->equipo->marca->nombre }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="bg-white bg-opacity-20 px-2 py-1 rounded text-sm">
                                    S/N: {{ $clienteEquipo->numero_serie }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de garantía y mantenimiento -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center">
                            <span class="status-badge warranty-{{ $clienteEquipo->warranty_status }}">
                                @switch($clienteEquipo->warranty_status)
                                    @case('active')
                                        <i class="fas fa-shield-alt mr-1"></i>Garantía Activa
                                        @break
                                    @case('soon')
                                        <i class="fas fa-clock mr-1"></i>Por Vencer
                                        @break
                                    @case('expired')
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Vencida
                                        @break
                                @endswitch
                            </span>
                            @if($clienteEquipo->fecha_vencimiento_garantia)
                                <p class="text-xs text-gray-500 mt-1">
                                    Vence: {{ $clienteEquipo->fecha_vencimiento_garantia->format('d/m/Y') }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="text-center">
                            @if($clienteEquipo->maintenance_status === 'needed')
                                <span class="status-badge warranty-soon">
                                    <i class="fas fa-wrench mr-1"></i>Mantenimiento Requerido
                                </span>
                            @elseif($clienteEquipo->maintenance_status === 'recent')
                                <span class="status-badge warranty-active">
                                    <i class="fas fa-check mr-1"></i>Mantenimiento Reciente
                                </span>
                            @elseif($clienteEquipo->maintenance_status === 'overdue')
                                <span class="status-badge warranty-expired">
                                    <i class="fas fa-exclamation mr-1"></i>Mantenimiento Atrasado
                                </span>
                            @else
                                <span class="status-badge warranty-active">
                                    <i class="fas fa-check mr-1"></i>Al día
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Estadísticas de servicios -->
                    <div class="border-t pt-4">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-2xl font-bold text-blue-600">{{ $clienteEquipo->total_servicios }}</p>
                                <p class="text-xs text-gray-500">Servicios Total</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600">${{ number_format($clienteEquipo->costo_total_servicios, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Costo Total</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-orange-600">
                                    @if($clienteEquipo->ultimo_servicio_date)
                                        {{ $clienteEquipo->ultimo_servicio_date->diffInDays(now()) }}d
                                    @else
                                        --
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">Último Servicio</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fechas importantes -->
                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                Registrado: {{ $clienteEquipo->fecha_adquisicion->format('d/m/Y') }}
                            </span>
                            @if($clienteEquipo->updated_at != $clienteEquipo->created_at)
                                <span>
                                    <i class="fas fa-edit mr-1"></i>
                                    Actualizado: {{ $clienteEquipo->updated_at->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <i class="fas fa-link text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay asociaciones registradas</h3>
                        <p class="text-gray-600 mb-6">Comienza creando la primera asociación entre cliente y equipo.</p>
                        <a href="{{ route('equipos-marcas.cliente-equipos.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300">
                            <i class="fas fa-plus mr-2"></i>Crear Primera Asociación
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
// Variables globales
let asociacionesOriginales = [];

document.addEventListener('DOMContentLoaded', function() {
    // Guardar asociaciones originales para filtrado
    asociacionesOriginales = Array.from(document.querySelectorAll('.association-card'));
    
    // Event listeners para filtros
    document.getElementById('search').addEventListener('input', aplicarFiltros);
    document.getElementById('warranty_filter').addEventListener('change', aplicarFiltros);
    document.getElementById('maintenance_filter').addEventListener('change', aplicarFiltros);
});

function aplicarFiltros() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const warrantyFilter = document.getElementById('warranty_filter').value;
    const maintenanceFilter = document.getElementById('maintenance_filter').value;
    
    let asociacionesFiltradas = asociacionesOriginales.filter(asociacion => {
        const searchData = asociacion.getAttribute('data-search');
        const warranty = asociacion.getAttribute('data-warranty');
        const maintenance = asociacion.getAttribute('data-maintenance');
        
        // Filtro de búsqueda
        if (searchTerm && !searchData.includes(searchTerm)) {
            return false;
        }
        
        // Filtro de garantía
        if (warrantyFilter && warranty !== warrantyFilter) {
            return false;
        }
        
        // Filtro de mantenimiento
        if (maintenanceFilter && maintenance !== maintenanceFilter) {
            return false;
        }
        
        return true;
    });
    
    // Ocultar todas las asociaciones
    asociacionesOriginales.forEach(asociacion => asociacion.style.display = 'none');
    
    // Mostrar asociaciones filtradas
    asociacionesFiltradas.forEach(asociacion => asociacion.style.display = 'block');
    
    // Actualizar contador
    document.getElementById('resultados-count').textContent = asociacionesFiltradas.length;
}

function limpiarFiltros() {
    document.getElementById('search').value = '';
    document.getElementById('warranty_filter').value = '';
    document.getElementById('maintenance_filter').value = '';
    
    // Mostrar todas las asociaciones
    asociacionesOriginales.forEach(asociacion => asociacion.style.display = 'block');
    document.getElementById('resultados-count').textContent = asociacionesOriginales.length;
}
</script>
@endpush