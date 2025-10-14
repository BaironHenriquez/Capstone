@extends('layouts.admin')

@section('title', 'Gestión de Clientes')

@section('header')
<!-- Title Section -->
<div class="mb-8 text-center">
    <h2 class="text-3xl font-bold text-sky-800 mb-2">Gestión de Clientes</h2>
    <p class="text-gray-700">Administra clientes y visualiza sus órdenes de servicio técnico</p>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-gradient-to-br from-sky-100 to-sky-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-sky-700 mb-1">Total Clientes</h3>
            <p class="text-3xl font-bold text-sky-900">{{ number_format($totalClientes) }}</p>
        </div>
        <div class="bg-gradient-to-br from-amber-100 to-yellow-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-amber-700 mb-1">Clientes Activos</h3>
            <p class="text-3xl font-bold text-amber-900">{{ number_format($clientesActivos) }}</p>
        </div>

        <div class="bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-orange-700 mb-1">Clientes Inactivos</h3>
            <p class="text-3xl font-bold text-orange-900">{{ number_format($clientesInactivos) }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-emerald-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-green-700 mb-1">Con Órdenes</h3>
            <p class="text-3xl font-bold text-green-900">{{ number_format($clientesConOrdenes) }}</p>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 mb-10">
        <h3 class="text-lg font-semibold text-teal-700 mb-4">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.clientes.create') }}" class="flex items-center p-4 rounded-lg bg-gradient-to-r from-sky-400 to-blue-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Nuevo Cliente</h4>
                    <p class="text-sm text-blue-50">Registrar cliente</p>
                </div>
            </a>

            <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-green-400 to-emerald-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Reportes</h4>
                    <p class="text-sm text-green-50">Ver estadísticas</p>
                </div>
            </button>

            <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-purple-400 to-fuchsia-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Exportar</h4>
                    <p class="text-sm text-purple-50">Lista de clientes</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
        <form method="GET" action="{{ route('admin.clientes.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           name="buscar" 
                           value="{{ request('buscar') }}"
                           placeholder="Nombre, email, RUT, empresa..."
                           class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="todos" {{ request('estado') == 'todos' ? 'selected' : '' }}>Todos los estados</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <!-- Tipo de Cliente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Cliente</label>
                    <select name="tipo_cliente" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="todos" {{ request('tipo_cliente') == 'todos' ? 'selected' : '' }}>Todos los tipos</option>
                        <option value="particular" {{ request('tipo_cliente') == 'particular' ? 'selected' : '' }}>Particular</option>
                        <option value="regular" {{ request('tipo_cliente') == 'regular' ? 'selected' : '' }}>Regular</option>
                    </select>
                </div>

                <!-- Servicio Técnico -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Servicio Técnico</label>
                    <select name="servicio_tecnico" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="todos" {{ request('servicio_tecnico') == 'todos' ? 'selected' : '' }}>Todos los servicios</option>
                        @foreach($serviciosTecnicos as $servicio)
                            <option value="{{ $servicio->id }}" {{ request('servicio_tecnico') == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button type="submit" class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                    <a href="{{ route('admin.clientes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Limpiar
                    </a>
                </div>

                <!-- Ordenamiento -->
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Ordenar por:</label>
                    <select name="orden" onchange="this.form.submit()" class="rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="created_at" {{ request('orden') == 'created_at' ? 'selected' : '' }}>Fecha de creación</option>
                        <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                        <option value="ordenes" {{ request('orden') == 'ordenes' ? 'selected' : '' }}>Número de órdenes</option>
                        <option value="ultima_orden" {{ request('orden') == 'ultima_orden' ? 'selected' : '' }}>Última orden</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Lista de Clientes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if(count($clientes->data ?? []) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
                @foreach($clientes->data as $cliente)
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                        <!-- Header del Cliente -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-900">
                                    {{ $cliente->nombre }} {{ $cliente->apellido }}
                                </h3>
                                @if($cliente->empresa)
                                    <p class="text-sm text-gray-600">{{ $cliente->empresa }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col items-end space-y-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($cliente->estado == 'activo') bg-green-100 text-green-800
                                    @elseif($cliente->estado == 'inactivo') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($cliente->estado) }}
                                </span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($cliente->tipo_cliente) }}
                                </span>
                            </div>
                        </div>

                        <!-- Información de contacto -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-envelope w-4 mr-2"></i>
                                <span>{{ $cliente->email }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-phone w-4 mr-2"></i>
                                <span>{{ $cliente->telefono }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-id-card w-4 mr-2"></i>
                                <span>{{ $cliente->rut }}</span>
                            </div>
                        </div>

                        <!-- Estadísticas de Órdenes -->
                        <div class="grid grid-cols-3 gap-4 mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="text-center">
                                <div class="text-lg font-bold text-capstone-600">{{ $cliente->ordenes_count }}</div>
                                <div class="text-xs text-gray-600">Total</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-green-600">{{ $cliente->ordenes_completadas_count }}</div>
                                <div class="text-xs text-gray-600">Completadas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-orange-600">{{ $cliente->ordenes_pendientes_count }}</div>
                                <div class="text-xs text-gray-600">Pendientes</div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.clientes.show', $cliente->id) }}" 
                                   class="text-capstone-600 hover:text-capstone-800 transition-colors duration-200"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.clientes.edit', $cliente->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>

                            <div class="flex space-x-2">
                                <!-- Toggle Estado -->
                                <form method="POST" action="{{ route('admin.clientes.toggle-status', $cliente->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-sm px-3 py-1 rounded-full font-medium transition-colors duration-200
                                                   {{ $cliente->estado === 'activo' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}"
                                            title="{{ $cliente->estado === 'activo' ? 'Desactivar' : 'Activar' }}">
                                        <i class="fas {{ $cliente->estado === 'activo' ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                                        {{ $cliente->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>

                                <!-- Eliminar -->
                                <form method="POST" action="{{ route('admin.clientes.destroy', $cliente->id) }}" 
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition-colors duration-200"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación (deshabilitada para datos simulados) -->
            {{-- @if($clientes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $clientes->links() }}
                </div>
            @endif --}}
        @else
            <div class="text-center py-12">
                <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron clientes</h3>
                <p class="text-gray-600 mb-6">No hay clientes que coincidan con los criterios de búsqueda.</p>
                <a href="{{ route('admin.clientes.create') }}" 
                   class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primer Cliente
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