@extends('layouts.admin')

@section('title', 'Gestión de Técnicos')

@section('header')
<!-- Title Section -->
<div class="mb-8 text-center">
    <h2 class="text-3xl font-bold text-sky-800 mb-2">Gestión de Técnicos</h2>
    <p class="text-gray-700">Administra el equipo técnico especializado del servicio</p>
</div>
@endsection

@section('content')

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-gradient-to-br from-sky-100 to-sky-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-sky-700 mb-1">Total Técnicos</h3>
            <p class="text-3xl font-bold text-sky-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-amber-100 to-yellow-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-amber-700 mb-1">Activos</h3>
            <p class="text-3xl font-bold text-amber-900">{{ $stats['activos'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-orange-700 mb-1">Inactivos</h3>
            <p class="text-3xl font-bold text-orange-900">{{ $stats['inactivos'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-emerald-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-green-700 mb-1">Disponibles</h3>
            <p class="text-3xl font-bold text-green-900">{{ $stats['activos'] }}</p>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 mb-10">
        <h3 class="text-lg font-semibold text-teal-700 mb-4">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.tecnicos.create') }}" class="flex items-center p-4 rounded-lg bg-gradient-to-r from-sky-400 to-blue-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Nuevo Técnico</h4>
                    <p class="text-sm text-blue-50">Registrar técnico</p>
                </div>
            </a>

            <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-green-400 to-emerald-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Asignar Tareas</h4>
                    <p class="text-sm text-green-50">Gestión de cargas</p>
                </div>
            </button>

            <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-purple-400 to-fuchsia-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Reportes</h4>
                    <p class="text-sm text-purple-50">Rendimiento</p>
                </div>
            </button>
        </div>
    </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 mb-8">
            <form method="GET" action="{{ route('admin.gestion-tecnicos') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>Buscar técnico
                        </label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Nombre, email, RUT..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-toggle-on mr-1"></i>Estado
                        </label>
                        <select name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="baneado" {{ request('estado') == 'baneado' ? 'selected' : '' }}>Baneado</option>
                        </select>
                    </div>
                    <div>
                        <label for="servicio" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tools mr-1"></i>Servicio
                        </label>
                        <select name="servicio" id="servicio" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los servicios</option>
                            @foreach($serviciosTecnicos as $servicio)
                                <option value="{{ $servicio->id }}" {{ request('servicio') == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-4">
                    <a href="{{ route('admin.gestion-tecnicos') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        <i class="fas fa-times-circle mr-1"></i>Limpiar filtros
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                        <i class="fas fa-search mr-2"></i>Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de técnicos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tecnicos->data ?? [] as $tecnico)
                <div class="tecnico-card bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                            </h3>
                            <p class="text-gray-600 text-sm">{{ $tecnico->email }}</p>
                        </div>
                        <span class="status-badge status-{{ $tecnico->estado }}">
                            {{ ucfirst($tecnico->estado) }}
                        </span>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-phone w-4 mr-2"></i>
                            {{ $tecnico->telefono }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-id-card w-4 mr-2"></i>
                            {{ $tecnico->rut }}
                        </div>
                        @if($tecnico->servicioTecnico)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-building w-4 mr-2"></i>
                                {{ $tecnico->servicioTecnico->nombre }}
                            </div>
                        @endif
                    </div>

                    <!-- Especialidades -->
                    @if(!empty($tecnico->especialidades))
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-2">Especialidades:</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($tecnico->especialidades as $especialidad)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                        {{ $especialidad }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Estadísticas -->
                    <div class="grid grid-cols-2 gap-4 mb-4 p-3 bg-gray-50 rounded-lg">
                        <div class="text-center">
                            <p class="text-lg font-bold text-blue-600">{{ $tecnico->ordenes_completadas ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Órdenes</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-green-600">{{ number_format($tecnico->calificacion_promedio ?? 0, 1) }}</p>
                            <p class="text-xs text-gray-500">Calificación</p>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex justify-between space-x-2">
                        <a href="{{ route('admin.tecnicos.edit', $tecnico->id) }}" 
                           class="flex-1 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-2 rounded-lg text-sm font-medium text-center transition-colors duration-200">
                            <i class="fas fa-edit mr-1"></i>Editar
                        </a>
                        
                        <form method="POST" action="{{ route('admin.tecnicos.toggle-ban', $tecnico->id) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-{{ $tecnico->estado === 'activo' ? 'red' : 'green' }}-100 text-{{ $tecnico->estado === 'activo' ? 'red' : 'green' }}-700 hover:bg-{{ $tecnico->estado === 'activo' ? 'red' : 'green' }}-200 px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-{{ $tecnico->estado === 'activo' ? 'ban' : 'check' }} mr-1"></i>
                                {{ $tecnico->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay técnicos registrados</h3>
                        <p class="text-gray-600 mb-6">Comienza agregando tu primer técnico al equipo.</p>
                        <a href="{{ route('admin.tecnicos.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300">
                            <i class="fas fa-plus mr-2"></i>Agregar Primer Técnico
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection