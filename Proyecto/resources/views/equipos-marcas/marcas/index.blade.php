@extends('layouts.admin')

@section('title', 'Gestión de Marcas')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestión de Marcas</h1>
        <p class="mt-2 text-gray-600">Administra el catálogo de marcas del sistema</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.equipos-marcas.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver al Dashboard
        </a>
        <a href="{{ route('admin.equipos-marcas.marcas.create') }}" 
           class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nueva Marca
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros y Búsqueda -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.equipos-marcas.marcas.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           name="buscar" 
                           value="{{ request('buscar') }}"
                           placeholder="Nombre, descripción, categoría..."
                           class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="categoria" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="todas" {{ request('categoria') == 'todas' ? 'selected' : '' }}>Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                {{ ucfirst($categoria) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="todas" {{ request('estado') == 'todas' ? 'selected' : '' }}>Todos los estados</option>
                        <option value="activa" {{ request('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="inactiva" {{ request('estado') == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                    </select>
                </div>

                <!-- Ordenamiento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                    <select name="orden" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="created_at" {{ request('orden') == 'created_at' ? 'selected' : '' }}>Fecha de creación</option>
                        <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                        <option value="equipos" {{ request('orden') == 'equipos' ? 'selected' : '' }}>Número de equipos</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button type="submit" class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    <a href="{{ route('admin.equipos-marcas.marcas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Lista de Marcas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($marcas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                @foreach($marcas as $marca)
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                        <!-- Header de la Marca -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    @if($marca->logo)
                                        <img src="{{ $marca->logo_url }}" alt="{{ $marca->nombre_marca }}" class="w-10 h-10 object-contain">
                                    @else
                                        <i class="fas fa-tag text-blue-600 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $marca->nombre_marca }}</h3>
                                    @if($marca->categoria)
                                        <p class="text-sm text-gray-600">{{ ucfirst($marca->categoria) }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $marca->estado_badge }}">
                                {{ $marca->activa ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>

                        <!-- Información de la Marca -->
                        <div class="space-y-3 mb-4">
                            @if($marca->descripcion)
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $marca->descripcion }}</p>
                            @endif
                            
                            <div class="space-y-2">
                                @if($marca->pais_origen)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-globe w-4 mr-2"></i>
                                        <span>{{ $marca->pais_origen }}</span>
                                    </div>
                                @endif
                                
                                @if($marca->sitio_web)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-link w-4 mr-2"></i>
                                        <a href="{{ $marca->sitio_web }}" target="_blank" class="text-capstone-600 hover:text-capstone-800 truncate">
                                            {{ $marca->sitio_web }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <div class="flex justify-between items-center">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-capstone-600">{{ $marca->equipos_count }}</div>
                                    <div class="text-xs text-gray-600">Equipos</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-green-600">{{ $marca->equiposActivos() }}</div>
                                    <div class="text-xs text-gray-600">Activos</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-purple-600">{{ $marca->clientesAsociados() }}</div>
                                    <div class="text-xs text-gray-600">Clientes</div>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Registro -->
                        <div class="text-xs text-gray-500 mb-4">
                            Registrada: {{ $marca->created_at->format('d/m/Y') }}
                        </div>

                        <!-- Acciones -->
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.equipos-marcas.marcas.edit', $marca->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                   title="Editar marca">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>

                            <div class="flex space-x-2">
                                <!-- Toggle Estado -->
                                <form method="POST" action="{{ route('admin.equipos-marcas.marcas.toggle-status', $marca->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-sm px-3 py-1 rounded-full font-medium transition-colors duration-200
                                                   {{ $marca->activa ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}"
                                            title="{{ $marca->activa ? 'Desactivar' : 'Activar' }}">
                                        <i class="fas {{ $marca->activa ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                                        {{ $marca->activa ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>

                                <!-- Eliminar -->
                                <form method="POST" action="{{ route('admin.equipos-marcas.marcas.destroy', $marca->id) }}" 
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta marca? Esta acción no se puede deshacer.')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition-colors duration-200"
                                            title="Eliminar marca"
                                            {{ $marca->equipos_count > 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($marca->equipos_count > 0 && !$marca->activa)
                            <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-700">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Marca con equipos asociados
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($marcas->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $marcas->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <i class="fas fa-tags text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron marcas</h3>
                <p class="text-gray-600 mb-6">No hay marcas que coincidan con los criterios de búsqueda.</p>
                <a href="{{ route('admin.equipos-marcas.marcas.create') }}" 
                   class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primera Marca
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Auto-submit form on filter change
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[method="GET"]');
    const selects = form.querySelectorAll('select:not([name="orden"])');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            form.submit();
        });
    });
});
</script>
@endpush
@endsection