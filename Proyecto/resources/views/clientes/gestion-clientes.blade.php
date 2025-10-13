@extends('layouts.admin')

@section('title', 'Gestión de Clientes')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestión de Clientes</h1>
        <p class="mt-2 text-gray-600">Administra clientes y visualiza sus órdenes de servicio</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.clientes.create') }}" 
           class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Cliente
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Clientes -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-blue-100 text-sm font-medium">Total Clientes</p>
                    <p class="text-3xl font-bold">{{ number_format($totalClientes) }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Clientes Activos -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-green-100 text-sm font-medium">Clientes Activos</p>
                    <p class="text-3xl font-bold">{{ number_format($clientesActivos) }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Clientes VIP -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-purple-100 text-sm font-medium">Clientes VIP</p>
                    <p class="text-3xl font-bold">{{ number_format($clientesVip) }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-crown text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Clientes con Órdenes -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-orange-100 text-sm font-medium">Con Órdenes</p>
                    <p class="text-3xl font-bold">{{ number_format($clientesConOrdenes) }}</p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
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
                        <option value="vip" {{ request('estado') == 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="moroso" {{ request('estado') == 'moroso' ? 'selected' : '' }}>Moroso</option>
                    </select>
                </div>

                <!-- Tipo de Cliente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Cliente</label>
                    <select name="tipo_cliente" class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500">
                        <option value="todos" {{ request('tipo_cliente') == 'todos' ? 'selected' : '' }}>Todos los tipos</option>
                        <option value="regular" {{ request('tipo_cliente') == 'regular' ? 'selected' : '' }}>Regular</option>
                        <option value="vip" {{ request('tipo_cliente') == 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="corporativo" {{ request('tipo_cliente') == 'corporativo' ? 'selected' : '' }}>Corporativo</option>
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
        @if($clientes->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
                @foreach($clientes as $cliente)
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                        <!-- Header del Cliente -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-900">
                                    {{ $cliente->nombre_completo }}
                                </h3>
                                @if($cliente->empresa)
                                    <p class="text-sm text-gray-600">{{ $cliente->empresa }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col items-end space-y-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $cliente->estado_badge }}">
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

            <!-- Paginación -->
            @if($clientes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $clientes->links() }}
                </div>
            @endif
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