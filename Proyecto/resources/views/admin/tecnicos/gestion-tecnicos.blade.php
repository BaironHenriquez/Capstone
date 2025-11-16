@extends('shared.layouts.admin')

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
                            <option value="vacaciones" {{ request('estado') == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                            <option value="licencia" {{ request('estado') == 'licencia' ? 'selected' : '' }}>Licencia</option>
                            <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            @forelse($tecnicos as $tecnico)
                <div class="tecnico-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <!-- Header con gradiente -->
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xl font-bold">
                                {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                            </h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $tecnico->estado === 'activo' ? 'bg-green-400 text-green-900' : 'bg-gray-400 text-gray-900' }}">
                                {{ ucfirst($tecnico->estado) }}
                            </span>
                        </div>
                        <p class="text-blue-100 text-sm">{{ $tecnico->email }}</p>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="p-6">

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-phone mr-2 text-gray-500"></i>
                                <span class="truncate font-medium">{{ $tecnico->telefono }}</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-id-card mr-2 text-gray-500"></i>
                                <span class="font-medium">{{ $tecnico->rut }}</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-briefcase mr-2 text-gray-500"></i>
                                <span class="capitalize font-medium">{{ $tecnico->nivel_experiencia }}</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                                <span class="truncate font-medium">{{ $tecnico->zona_trabajo ?? 'Sin zona' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Estado de disponibilidad -->
                    <div class="mb-4 p-3 rounded-lg {{ $tecnico->disponible ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-{{ $tecnico->disponible ? 'check-circle' : 'times-circle' }} mr-2 {{ $tecnico->disponible ? 'text-green-600' : 'text-gray-400' }}"></i>
                            <span class="font-semibold {{ $tecnico->disponible ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $tecnico->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </div>
                    </div>

                    <!-- Especialidades -->
                    @if(!empty($tecnico->especialidades))
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-gray-700 mb-2">Especialidades:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tecnico->especialidades as $especialidad)
                                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-medium border border-blue-200">
                                        {{ $especialidad }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Estadísticas -->
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="text-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <p class="text-2xl font-bold text-gray-700">{{ $tecnico->ordenes_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600 font-medium">Órdenes</p>
                        </div>
                        @php
                            $carga = $tecnico->carga_trabajo_actual ?? 0;
                            if ($carga >= 70) {
                                $colorCarga = 'bg-red-50 border-red-200';
                                $colorTexto = 'text-red-700';
                                $colorSubtexto = 'text-red-600';
                            } elseif ($carga >= 50) {
                                $colorCarga = 'bg-yellow-50 border-yellow-200';
                                $colorTexto = 'text-yellow-700';
                                $colorSubtexto = 'text-yellow-600';
                            } else {
                                $colorCarga = 'bg-green-50 border-green-200';
                                $colorTexto = 'text-green-700';
                                $colorSubtexto = 'text-green-600';
                            }
                        @endphp
                        <div class="text-center p-3 rounded-lg border {{ $colorCarga }}">
                            <p class="text-2xl font-bold {{ $colorTexto }}">{{ $carga }}%</p>
                            <p class="text-xs font-medium {{ $colorSubtexto }}">Carga</p>
                        </div>
                        <div class="text-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <p class="text-lg font-bold text-gray-700">
                                ${{ number_format($tecnico->salario_base ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-600 font-medium">Salario</p>
                        </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="text-xs text-center">
                            <span class="text-gray-700 font-semibold">
                                <i class="fas fa-calendar-alt mr-1 text-gray-500"></i>
                                Ingreso: {{ $tecnico->fecha_ingreso ? \Carbon\Carbon::parse($tecnico->fecha_ingreso)->format('d/m/Y') : 'N/A' }}
                            </span>
                        </div>
                        @if($tecnico->horario_trabajo)
                            <div class="mt-2 text-xs text-center text-gray-600">
                                <i class="fas fa-clock mr-1 text-gray-500"></i>
                                {{ $tecnico->horario_trabajo }}
                            </div>
                        @endif
                    </div>

                    <!-- Acciones -->
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.tecnicos.edit', $tecnico->id) }}" 
                           class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2.5 rounded-lg text-sm font-semibold text-center transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-edit mr-1"></i>Editar
                        </a>
                        
                        @if($tecnico->estado === 'activo')
                            <a href="{{ route('admin.tecnicos.asignar', $tecnico->id) }}" 
                               class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2.5 rounded-lg text-sm font-semibold text-center transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-tasks mr-1"></i>Asignar
                            </a>
                        @else
                            <button disabled
                                    title="El técnico debe estar en estado 'Activo' para asignar órdenes"
                                    class="bg-gray-300 text-gray-500 cursor-not-allowed px-4 py-2.5 rounded-lg text-sm font-semibold text-center shadow-md opacity-60">
                                <i class="fas fa-lock mr-1"></i>Asignar
                            </button>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.tecnicos.destroy', $tecnico->id) }}" 
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este técnico? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 text-white hover:bg-red-700 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </form>
                        
                        <div class="relative">
                            <form method="POST" action="{{ route('admin.tecnicos.cambiar-estado', $tecnico->id) }}" id="form-estado-{{ $tecnico->id }}">
                                @csrf
                                @method('PATCH')
                                <select name="estado" 
                                        onchange="document.getElementById('form-estado-{{ $tecnico->id }}').submit()"
                                        class="w-full px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg border-2 cursor-pointer appearance-none
                                        @if($tecnico->estado === 'activo') bg-white hover:bg-gray-50 text-green-700 border-green-500
                                        @elseif($tecnico->estado === 'inactivo') bg-white hover:bg-gray-50 text-gray-700 border-gray-400
                                        @elseif($tecnico->estado === 'vacaciones') bg-white hover:bg-gray-50 text-blue-700 border-blue-500
                                        @elseif($tecnico->estado === 'licencia') bg-white hover:bg-gray-50 text-yellow-700 border-yellow-500
                                        @elseif($tecnico->estado === 'suspendido') bg-white hover:bg-gray-50 text-red-700 border-red-500
                                        @endif">
                                    <option value="activo" {{ $tecnico->estado === 'activo' ? 'selected' : '' }}>✓ Activo</option>
                                    <option value="inactivo" {{ $tecnico->estado === 'inactivo' ? 'selected' : '' }}>○ Inactivo</option>
                                    <option value="vacaciones" {{ $tecnico->estado === 'vacaciones' ? 'selected' : '' }}>✈ Vacaciones</option>
                                    <option value="licencia" {{ $tecnico->estado === 'licencia' ? 'selected' : '' }}>⚕ Licencia</option>
                                    <option value="suspendido" {{ $tecnico->estado === 'suspendido' ? 'selected' : '' }}>⊗ Suspendido</option>
                                </select>
                            </form>
                        </div>
                    </div>
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

<script>
function verDetalle(tecnicoId) {
    // Aquí puedes implementar un modal con más detalles del técnico
    alert('Ver detalle del técnico #' + tecnicoId);
}
</script>
@endsection