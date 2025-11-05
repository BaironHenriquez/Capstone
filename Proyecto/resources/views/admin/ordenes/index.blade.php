@extends('shared.layouts.admin')

@section('title', 'Órdenes de Servicio')
@section('breadcrumb', 'Órdenes de Servicio')

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
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['orden_por' => 'numero_orden', 'direccion' => request('direccion') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                            <span>Número</span>
                            <i class="fas fa-sort text-xs"></i>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Técnico</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['orden_por' => 'created_at', 'direccion' => request('direccion') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                            <span>Creada</span>
                            <i class="fas fa-sort text-xs"></i>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ordenes ?? [] as $orden)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                        <a href="{{ route('ordenes.show', $orden) }}" class="hover:text-blue-800">
                            {{ $orden->numero_orden ?? 'TS-000' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $orden->cliente->nombre_completo ?? 'Sin cliente' }}
                        </div>
                        @if(isset($orden->cliente->empresa) && $orden->cliente->empresa)
                        <div class="text-sm text-gray-500">{{ $orden->cliente->empresa }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($orden->tecnico)
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs font-semibold text-blue-600">
                                    {{ substr($orden->tecnico->nombre_completo, 0, 2) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $orden->tecnico->nombre_completo }}</div>
                                <div class="text-xs text-gray-500">{{ $orden->tecnico->especialidades_texto ?? '' }}</div>
                            </div>
                        </div>
                        @else
                        <span class="text-sm text-gray-500 italic">Sin asignar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 capitalize">{{ $orden->tipo_servicio ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500 truncate max-w-32" title="{{ $orden->descripcion_problema ?? '' }}">
                            {{ Str::limit($orden->descripcion_problema ?? '', 40) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $orden->estado_badge ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $orden->estado ?? 'pendiente')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $orden->prioridad_badge ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($orden->prioridad ?? 'media') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $orden->created_at ? $orden->created_at->format('d/m/Y') : 'N/A' }}
                        <div class="text-xs text-gray-400">
                            {{ $orden->created_at ? $orden->created_at->format('H:i') : '' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('ordenes.show', $orden) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Ver orden">
                                <i class="fas fa-eye"></i>
                            </a>
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
        // Crear formulario para eliminar
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/ordenes/${ordenId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
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
</script>
@endpush