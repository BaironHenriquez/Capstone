@extends('shared.layouts.admin')

@section('title', 'Órdenes de Servicio')
@section('breadcrumb', 'Órdenes de Servicio')

@push('styles')
<style>
    /* Asegurar que los dropdowns no se corten */
    .tabla-ordenes-container {
        overflow: visible !important;
    }
    .tabla-ordenes-container table {
        overflow: visible !important;
    }
    .tabla-ordenes-container tbody {
        overflow: visible !important;
    }
    tbody tr {
        position: relative;
    }
    tbody td {
        overflow: visible !important;
    }
    /* Asegurar que el contenedor padre no corte el contenido */
    .bg-white.rounded-lg {
        overflow: visible !important;
    }
</style>
@endpush

@section('content')
<!-- Header de la página -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Órdenes de Servicio</h1>
        <p class="text-gray-600">Gestiona todas las órdenes de servicio del sistema</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('ordenes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
            <i class="fas fa-plus mr-2"></i>Nueva Orden
        </a>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-clipboard-list text-gray-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Pendientes</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['pendientes'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-tools text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">En Progreso</p>
                <p class="text-2xl font-bold text-blue-600">{{ $estadisticas['en_progreso'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Completadas</p>
                <p class="text-2xl font-bold text-green-600">{{ $estadisticas['completadas'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Retrasadas</p>
                <p class="text-2xl font-bold text-red-600">{{ $estadisticas['retrasadas'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Alertas -->
@if(($estadisticas['pendientes'] ?? 0) > 5)
<div class="bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-500 rounded-lg p-5 mb-8 flex items-start space-x-4 shadow-sm">
    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
    </div>
    <div>
        <h3 class="font-bold text-orange-800 text-lg">⚠️ Advertencia: Órdenes Pendientes Acumuladas</h3>
        <p class="text-orange-700 text-sm mt-1">Hay <strong>{{ $estadisticas['pendientes'] }} órdenes pendientes</strong>. Se recomienda revisar y asignar los trabajos pendientes para optimizar el flujo de trabajo.</p>
    </div>
</div>
@endif

@if(($estadisticas['retrasadas'] ?? 0) > 0)
<div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-lg p-5 mb-8 flex items-start space-x-4 shadow-sm">
    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
        <i class="fas fa-calendar-times text-white text-lg"></i>
    </div>
    <div>
        <h3 class="font-bold text-red-800 text-lg">🚨 Atención: Órdenes Retrasadas</h3>
        <p class="text-red-700 text-sm mt-1">Hay <strong>{{ $estadisticas['retrasadas'] }} órdenes retrasadas</strong>. Por favor, acelera su resolución para mantener la calidad del servicio.</p>
    </div>
</div>
@endif

<!-- Filtros y búsqueda -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
    <form method="GET" action="{{ route('ordenes.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
        <!-- Búsqueda -->
        <div class="flex-1">
            <label for="buscar" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
            <input type="text" id="buscar" name="buscar" value="{{ request('buscar') }}" 
                   placeholder="Número de orden, cliente, descripción..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Estado -->
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select id="estado" name="estado" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="asignada" {{ request('estado') === 'asignada' ? 'selected' : '' }}>Asignada</option>
                <option value="en_progreso" {{ request('estado') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                <option value="completada" {{ request('estado') === 'completada' ? 'selected' : '' }}>Completada</option>
                <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <!-- Prioridad -->
        <div>
            <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
            <select id="prioridad" name="prioridad" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todas las prioridades</option>
                <option value="baja" {{ request('prioridad') === 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ request('prioridad') === 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ request('prioridad') === 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="urgente" {{ request('prioridad') === 'urgente' ? 'selected' : '' }}>Urgente</option>
            </select>
        </div>

        <!-- Técnico -->
        @if(isset($tecnicos))
        <div>
            <label for="tecnico_id" class="block text-sm font-medium text-gray-700 mb-2">Técnico</label>
            <select id="tecnico_id" name="tecnico_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todos los técnicos</option>
                @foreach($tecnicos as $tecnico)
                <option value="{{ $tecnico->id }}" {{ request('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                    {{ $tecnico->nombre_completo }}
                </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Botones -->
        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-300">
                <i class="fas fa-search mr-1"></i> Filtrar
            </button>
            <a href="{{ route('ordenes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                <i class="fas fa-times mr-1"></i> Limpiar
            </a>
        </div>
    </form>
</div>

<!-- Lista de órdenes -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200" style="overflow: visible !important;">
    <div class="overflow-x-auto tabla-ordenes-container" style="overflow-y: visible !important;">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['orden_por' => 'numero_orden', 'direccion' => request('direccion') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center justify-center space-x-1 hover:text-gray-700">
                            <span>Número</span>
                            <i class="fas fa-sort text-xs"></i>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Técnico</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['orden_por' => 'created_at', 'direccion' => request('direccion') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center justify-center space-x-1 hover:text-gray-700">
                            <span>Creada</span>
                            <i class="fas fa-sort text-xs"></i>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ordenes ?? [] as $orden)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 text-center">
                        <button onclick="abrirModalOrden({{ $orden->id }})" class="hover:text-blue-800 hover:underline cursor-pointer">
                            {{ $orden->numero_orden ?? 'TS-000' }}
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $orden->cliente->nombre_completo ?? 'Sin cliente' }}
                        </div>
                        @if(isset($orden->cliente->empresa) && $orden->cliente->empresa)
                        <div class="text-sm text-gray-500">{{ $orden->cliente->empresa }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($orden->tecnico)
                        <div class="text-sm font-medium text-gray-900">{{ $orden->tecnico->nombre_completo }}</div>
                        <div class="text-xs text-gray-500">{{ Str::limit($orden->tecnico->especialidades_texto ?? '', 30) }}</div>
                        @else
                        <span class="text-sm text-gray-500 italic">Sin asignar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-sm font-medium text-gray-900 capitalize">{{ $orden->tipo_servicio ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500 truncate max-w-32 mx-auto" title="{{ $orden->descripcion_problema ?? '' }}">
                            {{ Str::limit($orden->descripcion_problema ?? '', 40) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="relative inline-block" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="px-3 py-1.5 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $orden->estado_badge ?? 'bg-gray-100 text-gray-800' }} hover:opacity-80 transition-opacity cursor-pointer min-w-[120px] justify-between">
                                <span>{{ ucfirst(str_replace('_', ' ', $orden->estado ?? 'pendiente')) }}</span>
                                <i class="fas fa-chevron-down text-xs ml-2"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute z-50 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 py-1 min-w-[160px] left-0">
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'pendiente')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Pendiente</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'asignada')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">Asignada</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'diagnostico')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">Diagnóstico</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'espera_repuesto')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-semibold">Espera Repuesto</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'en_progreso')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-semibold">En Progreso</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'listo_retiro')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-xs font-semibold">Listo para Retiro</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'completada')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Completada</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'entregada')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">Entregada</span>
                                </button>
                                <button type="button" onclick="cambiarEstado({{ $orden->id }}, 'cancelada')" class="block w-full text-center px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">Cancelada</span>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="relative inline-block" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $orden->prioridad_badge ?? 'bg-gray-100 text-gray-800' }} hover:opacity-80 transition-opacity cursor-pointer">
                                <span class="mr-1">{{ ucfirst($orden->prioridad ?? 'media') }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute z-10 mt-1 bg-white rounded-lg shadow-xl border border-gray-200 py-1 min-w-32">
                                <button type="button" onclick="cambiarPrioridad({{ $orden->id }}, 'baja')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                    <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-semibold">Baja</span>
                                </button>
                                <button type="button" onclick="cambiarPrioridad({{ $orden->id }}, 'media')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">Media</span>
                                </button>
                                <button type="button" onclick="cambiarPrioridad({{ $orden->id }}, 'alta')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                    <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-semibold">Alta</span>
                                </button>
                                <button type="button" onclick="cambiarPrioridad({{ $orden->id }}, 'urgente')" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">Urgente</span>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        {{ $orden->created_at ? $orden->created_at->format('d/m/Y') : 'N/A' }}
                        <div class="text-xs text-gray-400">
                            {{ $orden->created_at ? $orden->created_at->format('H:i') : '' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center justify-center space-x-2">
                            <button onclick="abrirModalOrden({{ $orden->id }})" class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Ver orden">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($orden->puedeSerEditada ?? true)
                            <a href="{{ route('ordenes.edit', $orden) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200" title="Editar orden">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                            <button onclick="confirmarEliminar({{ $orden->id }})" class="text-red-600 hover:text-red-900 transition-colors duration-200" title="Eliminar orden">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay órdenes de servicio</h3>
                            <p class="text-gray-500 mb-4">Comienza creando tu primera orden de servicio.</p>
                            <a href="{{ route('ordenes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                                <i class="fas fa-plus mr-2"></i>Nueva Orden
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginación -->
@if(isset($ordenes) && method_exists($ordenes, 'hasPages') && $ordenes->hasPages())
<div class="mt-6">
    {{ $ordenes->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function confirmarEliminar(ordenId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta orden? Esta acción no se puede deshacer.')) {
        // Usar AJAX para eliminar
        fetch(`/admin/ordenes/${ordenId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Recargar la página después de 1 segundo
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Error al eliminar la orden', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al eliminar la orden', 'error');
        });
    }
}

// Funciones para actualizar estado y prioridad inline
function cambiarEstado(ordenId, nuevoEstado) {
    fetch(`/ordenes/${ordenId}/estado`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ estado: nuevoEstado })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Estado actualizado correctamente', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            // Si hay saldo pendiente y requiere pago
            if (data.requiere_pago && data.saldo_pendiente) {
                mostrarModalPagoPendiente(ordenId, data.saldo_pendiente, data.message);
            } else {
                throw new Error(data.message || 'Error al actualizar');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Error al actualizar el estado', 'error');
    });
}

function cambiarPrioridad(ordenId, nuevaPrioridad) {
    fetch(`/ordenes/${ordenId}/prioridad`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ prioridad: nuevaPrioridad })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar notificación de éxito
            showNotification('Prioridad actualizada correctamente', 'success');
            // Recargar la página para actualizar el badge
            setTimeout(() => location.reload(), 1000);
        } else {
            throw new Error(data.message || 'Error al actualizar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error al actualizar la prioridad', 'error');
    });
}

// Auto-submit en cambio de filtros
document.addEventListener('DOMContentLoaded', function() {
    const filtros = ['estado', 'prioridad', 'tecnico_id'];
    filtros.forEach(filtro => {
        const elemento = document.getElementById(filtro);
        if (elemento) {
            elemento.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
});

// Función para mostrar notificaciones
function showNotification(message, type = 'success') {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Agregar al DOM
    document.body.appendChild(notification);
    
    // Animación de entrada
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Función para mostrar modal de pago pendiente
function mostrarModalPagoPendiente(ordenId, saldoPendiente, mensaje) {
    const modal = document.getElementById('modalPagoPendiente');
    const mensajeModal = document.getElementById('mensajeSaldoPendiente');
    const montoSaldo = document.getElementById('montoSaldoPendiente');
    
    mensajeModal.textContent = mensaje;
    montoSaldo.textContent = '$' + Math.round(saldoPendiente).toLocaleString('es-CL');
    
    // Configurar botones
    document.getElementById('btnVerOrden').onclick = async () => {
        // Registrar el pago automáticamente
        await registrarPagoAutomatico(ordenId, saldoPendiente);
    };
    
    document.getElementById('btnCancelarModal').onclick = cerrarModalPago;
    document.getElementById('btnCerrarModal').onclick = cerrarModalPago;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
        modal.querySelector('.transform').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function cerrarModalPago() {
    const modal = document.getElementById('modalPagoPendiente');
    modal.querySelector('.transform').classList.add('scale-95', 'opacity-0');
    modal.querySelector('.transform').classList.remove('scale-100', 'opacity-100');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Función para registrar el pago automáticamente
async function registrarPagoAutomatico(ordenId, montoPago) {
    const btnPagar = document.getElementById('btnVerOrden');
    const textoOriginal = btnPagar.innerHTML;
    
    // Cambiar botón a estado de carga
    btnPagar.disabled = true;
    btnPagar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...';
    
    try {
        const response = await fetch(`/ordenes/${ordenId}/registrar-pago`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                monto: montoPago,
                medio_pago: 'efectivo',
                notas: 'Pago automático del saldo pendiente'
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('✅ Pago registrado exitosamente. Saldo: $0', 'success');
            cerrarModalPago();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            throw new Error(result.message || 'Error al procesar el pago');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('❌ Error al procesar el pago: ' + error.message, 'error');
        btnPagar.disabled = false;
        btnPagar.innerHTML = textoOriginal;
    }
}
</script>

<!-- Modal de Pago Pendiente -->
<div id="modalPagoPendiente" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="transform transition-all duration-300 scale-95 opacity-0 bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                    <h3 class="text-xl font-bold">Saldo Pendiente</h3>
                </div>
                <button onclick="cerrarModalPago()" id="btnCerrarModal" class="hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Body -->
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="bg-orange-100 text-orange-800 rounded-lg p-4 mb-4">
                    <i class="fas fa-dollar-sign text-3xl mb-2"></i>
                    <p class="text-sm font-medium mb-2" id="mensajeSaldoPendiente"></p>
                    <p class="text-2xl font-bold" id="montoSaldoPendiente"></p>
                </div>
                <p class="text-gray-600 text-sm">
                    Para completar o entregar esta orden, debe registrar el pago del saldo pendiente.
                </p>
            </div>
            
            <!-- Botones -->
            <div class="flex gap-3">
                <button onclick="cerrarModalPago()" id="btnCancelarModal" 
                    class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button id="btnVerOrden"
                    class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-dollar-sign mr-2"></i>Registrar Pago
                </button>
            </div>
        </div>
    </div>
</div>
</script>

@include('admin.ordenes.modal-orden')
@endpush