@extends('layouts.admin')

@section('title', 'Clientes')
@section('breadcrumb', 'Gestión de Clientes')

@section('content')
<!-- Header de la página -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Clientes</h1>
        <p class="text-gray-600">Gestiona todos los clientes del servicio técnico</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('clientes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
            <i class="fas fa-plus mr-2"></i>Nuevo Cliente
        </a>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clientes->total() ?? count($clientes ?? []) }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-user-plus text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Nuevos Este Mes</p>
                <p class="text-2xl font-bold text-green-600">{{ $estadisticas['nuevos_mes'] ?? 8 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-tools text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Con Servicio Activo</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['activos'] ?? 15 }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-star text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Clientes VIP</p>
                <p class="text-2xl font-bold text-purple-600">{{ $estadisticas['vip'] ?? 5 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros y búsqueda -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
    <form method="GET" action="{{ route('clientes.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
        <!-- Búsqueda -->
        <div class="flex-1">
            <label for="buscar" class="block text-sm font-medium text-gray-700 mb-2">Buscar Cliente</label>
            <input type="text" id="buscar" name="buscar" value="{{ request('buscar') }}" 
                   placeholder="Nombre, apellido, email, teléfono..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Filtro por RUT -->
        <div>
            <label for="rut" class="block text-sm font-medium text-gray-700 mb-2">RUT</label>
            <input type="text" id="rut" name="rut" value="{{ request('rut') }}" 
                   placeholder="12345678-9" 
                   class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Botones -->
        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-300">
                <i class="fas fa-search mr-1"></i> Buscar
            </button>
            <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                <i class="fas fa-times mr-1"></i> Limpiar
            </a>
        </div>
    </form>
</div>

<!-- Lista de clientes -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['orden_por' => 'nombre', 'direccion' => request('direccion') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                            <span>Cliente</span>
                            <i class="fas fa-sort text-xs"></i>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RUT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['orden_por' => 'created_at', 'direccion' => request('direccion') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700">
                            <span>Registro</span>
                            <i class="fas fa-sort text-xs"></i>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clientes ?? [] as $cliente)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-semibold text-blue-600">
                                    {{ substr($cliente->nombre ?? '', 0, 1) }}{{ substr($cliente->apellido ?? '', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $cliente->nombre ?? '' }} {{ $cliente->apellido ?? '' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    Cliente desde {{ $cliente->created_at ? $cliente->created_at->format('M Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $cliente->correo ?? 'Sin email' }}</div>
                        <div class="text-sm text-gray-500">{{ $cliente->telefono ?? 'Sin teléfono' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 max-w-32 truncate" title="{{ $cliente->direccion ?? '' }}">
                            {{ $cliente->direccion ?? 'Sin dirección' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 font-mono">{{ $cliente->rut ?? 'Sin RUT' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $cliente->created_at ? $cliente->created_at->format('d/m/Y') : 'N/A' }}
                        <div class="text-xs text-gray-400">
                            {{ $cliente->created_at ? $cliente->created_at->format('H:i') : '' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('clientes.show', $cliente) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Ver cliente">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200" title="Editar cliente">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(isset($cliente->estadisticas))
                            <a href="{{ route('clientes.estadisticas', $cliente) }}" class="text-green-600 hover:text-green-900 transition-colors duration-200" title="Ver estadísticas">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                            @endif
                            <button onclick="confirmarEliminar({{ $cliente->id }})" class="text-red-600 hover:text-red-900 transition-colors duration-200" title="Eliminar cliente">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay clientes registrados</h3>
                            <p class="text-gray-500 mb-4">Comienza registrando tu primer cliente.</p>
                            <a href="{{ route('clientes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                                <i class="fas fa-plus mr-2"></i>Nuevo Cliente
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
@if(isset($clientes) && method_exists($clientes, 'hasPages') && $clientes->hasPages())
<div class="mt-6">
    {{ $clientes->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function confirmarEliminar(clienteId) {
    if (confirm('¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.')) {
        // Crear formulario para eliminar
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/clientes/${clienteId}`;
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
    const searchInput = document.getElementById('buscar');
    const rutInput = document.getElementById('rut');
    
    // Búsqueda en tiempo real con debounce
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
    
    // Formato automático de RUT
    rutInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, -1) + '-' + value.slice(-1);
        }
        this.value = value;
    });
});
</script>
@endpush