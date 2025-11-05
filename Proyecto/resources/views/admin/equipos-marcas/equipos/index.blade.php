@extends('shared.layouts.admin')

@section('title', 'Gestión de Equipos')
@section('breadcrumb', 'Equipos')

@push('styles')
<style>
    .equipment-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .equipment-card:hover {
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
    
    .status-activo { background-color: #dcfce7; color: #166534; }
    .status-inactivo { background-color: #fee2e2; color: #dc2626; }
    .status-mantenimiento { background-color: #fef3c7; color: #d97706; }
    
    .price-tag {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }
    
    .warranty-info {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
    }
    
    .filter-section {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Equipos</h1>
                    <p class="text-gray-600 mt-2">Administra el catálogo de equipos disponibles</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('equipos-marcas.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                    </a>
                    <a href="{{ route('equipos-marcas.equipos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
                        <i class="fas fa-plus mr-2"></i>Nuevo Equipo
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros avanzados -->
        <div class="filter-section">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Buscar equipos
                    </label>
                    <input type="text" id="search" placeholder="Nombre, modelo, marca..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="marca_filter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-1"></i>Marca
                    </label>
                    <select id="marca_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las marcas</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-1"></i>Estado
                    </label>
                    <select id="status_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="mantenimiento">En Mantenimiento</option>
                    </select>
                </div>
                <div>
                    <label for="precio_filter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign mr-1"></i>Rango de Precio
                    </label>
                    <select id="precio_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Cualquier precio</option>
                        <option value="0-100">$0 - $100</option>
                        <option value="100-500">$100 - $500</option>
                        <option value="500-1000">$500 - $1,000</option>
                        <option value="1000-5000">$1,000 - $5,000</option>
                        <option value="5000+">$5,000+</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4">
                <button onclick="limpiarFiltros()" class="text-gray-600 hover:text-gray-800 font-medium">
                    <i class="fas fa-times-circle mr-1"></i>Limpiar filtros
                </button>
                <div class="text-sm text-gray-600">
                    <span id="resultados-count">{{ $equipos->count() }}</span> equipos encontrados
                </div>
            </div>
        </div>

        <!-- Lista de equipos -->
        <div id="equipos-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($equipos as $equipo)
                <div class="equipment-card bg-white rounded-lg shadow-sm p-6" 
                     data-marca="{{ $equipo->marca_id }}" 
                     data-status="{{ $equipo->estado }}" 
                     data-precio="{{ $equipo->precio_referencial }}"
                     data-search="{{ strtolower($equipo->nombre . ' ' . $equipo->modelo . ' ' . $equipo->marca->nombre) }}">
                    
                    <!-- Imagen del equipo -->
                    <div class="relative mb-4">
                        @if($equipo->imagen)
                            <img src="{{ Storage::url($equipo->imagen) }}" 
                                 alt="{{ $equipo->nombre }}" 
                                 class="w-full h-48 object-cover rounded-lg">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-laptop text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        <!-- Badge de estado -->
                        <div class="absolute top-2 right-2">
                            <span class="status-badge status-{{ $equipo->estado }}">
                                {{ ucfirst($equipo->estado) }}
                            </span>
                        </div>
                    </div>

                    <!-- Información del equipo -->
                    <div class="mb-4">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $equipo->nombre }}</h3>
                            <div class="text-right">
                                <div class="price-tag text-sm">
                                    ${{ number_format($equipo->precio_referencial, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-2">{{ $equipo->modelo }}</p>
                        
                        <!-- Información de marca -->
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-tag mr-1"></i>{{ $equipo->marca->nombre }}
                            </span>
                            @if($equipo->meses_garantia)
                                <span class="warranty-info ml-2">
                                    <i class="fas fa-shield-alt mr-1"></i>{{ $equipo->meses_garantia }} meses garantía
                                </span>
                            @endif
                        </div>

                        <!-- Especificaciones técnicas -->
                        @if($equipo->especificaciones_tecnicas)
                            <div class="text-sm text-gray-600 mb-3">
                                <p class="line-clamp-2">{{ Str::limit($equipo->especificaciones_tecnicas, 100) }}</p>
                            </div>
                        @endif

                        <!-- Estadísticas -->
                        <div class="flex justify-between text-xs text-gray-500 mb-4">
                            <span><i class="fas fa-users mr-1"></i>{{ $equipo->clienteEquipos()->count() }} clientes</span>
                            <span><i class="fas fa-wrench mr-1"></i>{{ $equipo->servicios()->count() }} servicios</span>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('equipos-marcas.equipos.edit', $equipo->id) }}" 
                               class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i>Editar
                            </a>
                            <button onclick="toggleEstado({{ $equipo->id }})" 
                                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-toggle-{{ $equipo->estado === 'activo' ? 'on' : 'off' }} mr-1"></i>
                                {{ $equipo->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                            </button>
                        </div>
                        <button onclick="eliminarEquipo({{ $equipo->id }})" 
                                class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200">
                            <i class="fas fa-trash mr-1"></i>Eliminar
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <i class="fas fa-laptop text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay equipos registrados</h3>
                        <p class="text-gray-600 mb-6">Comienza agregando tu primer equipo al catálogo.</p>
                        <a href="{{ route('equipos-marcas.equipos.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300">
                            <i class="fas fa-plus mr-2"></i>Agregar Primer Equipo
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
let equiposOriginales = [];

document.addEventListener('DOMContentLoaded', function() {
    // Guardar equipos originales para filtrado
    equiposOriginales = Array.from(document.querySelectorAll('.equipment-card'));
    
    // Event listeners para filtros
    document.getElementById('search').addEventListener('input', aplicarFiltros);
    document.getElementById('marca_filter').addEventListener('change', aplicarFiltros);
    document.getElementById('status_filter').addEventListener('change', aplicarFiltros);
    document.getElementById('precio_filter').addEventListener('change', aplicarFiltros);
});

function aplicarFiltros() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const marcaFilter = document.getElementById('marca_filter').value;
    const statusFilter = document.getElementById('status_filter').value;
    const precioFilter = document.getElementById('precio_filter').value;
    
    let equiposFiltrados = equiposOriginales.filter(equipo => {
        const searchData = equipo.getAttribute('data-search');
        const marca = equipo.getAttribute('data-marca');
        const status = equipo.getAttribute('data-status');
        const precio = parseFloat(equipo.getAttribute('data-precio')) || 0;
        
        // Filtro de búsqueda
        if (searchTerm && !searchData.includes(searchTerm)) {
            return false;
        }
        
        // Filtro de marca
        if (marcaFilter && marca !== marcaFilter) {
            return false;
        }
        
        // Filtro de estado
        if (statusFilter && status !== statusFilter) {
            return false;
        }
        
        // Filtro de precio
        if (precioFilter) {
            const [min, max] = precioFilter === '5000+' 
                ? [5000, Infinity] 
                : precioFilter.split('-').map(p => parseFloat(p));
                
            if (precio < min || precio > max) {
                return false;
            }
        }
        
        return true;
    });
    
    // Ocultar todos los equipos
    equiposOriginales.forEach(equipo => equipo.style.display = 'none');
    
    // Mostrar equipos filtrados
    equiposFiltrados.forEach(equipo => equipo.style.display = 'block');
    
    // Actualizar contador
    document.getElementById('resultados-count').textContent = equiposFiltrados.length;
}

function limpiarFiltros() {
    document.getElementById('search').value = '';
    document.getElementById('marca_filter').value = '';
    document.getElementById('status_filter').value = '';
    document.getElementById('precio_filter').value = '';
    
    // Mostrar todos los equipos
    equiposOriginales.forEach(equipo => equipo.style.display = 'block');
    document.getElementById('resultados-count').textContent = equiposOriginales.length;
}

function toggleEstado(equipoId) {
    if (confirm('¿Estás seguro de cambiar el estado de este equipo?')) {
        fetch(`/admin/equipos/${equipoId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al cambiar el estado del equipo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}

function eliminarEquipo(equipoId) {
    if (confirm('¿Estás seguro de eliminar este equipo? Esta acción no se puede deshacer.')) {
        fetch(`/admin/equipos/${equipoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar el equipo: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}
</script>
@endpush