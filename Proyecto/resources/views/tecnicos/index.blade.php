@extends('layouts.admin')

@section('title', 'Gestión de Técnicos')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Técnicos</h1>
            <p class="text-gray-600 mt-1">Gestiona el equipo técnico del servicio</p>
        </div>
        <div class="flex space-x-3">
            <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Nuevo Técnico
            </button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-download mr-2"></i>
                Exportar
            </button>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disponibles</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['disponibles'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-user-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Activos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['activos'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-user-slash text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sobrecargados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['sobrecargados'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('tecnicos.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                        <div class="relative">
                            <input type="text" 
                                   name="buscar"
                                   value="{{ request('buscar') }}"
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Buscar por nombre, email...">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="suspendido" {{ request('estado') === 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                        </select>
                    </div>
                
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Especialidad</label>
                        <select name="especialidad" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las especialidades</option>
                            @foreach($especialidades as $esp)
                                <option value="{{ $esp }}" {{ request('especialidad') === $esp ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $esp)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilidad</label>
                        <select name="disponible" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Cualquier disponibilidad</option>
                            <option value="1" {{ request('disponible') === '1' ? 'selected' : '' }}>Disponible</option>
                            <option value="0" {{ request('disponible') === '0' ? 'selected' : '' }}>No Disponible</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-4">
                    <a href="{{ route('tecnicos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg">
                        Limpiar Filtros
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                        Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de técnicos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Técnico
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Especialidades
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Experiencia
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Zona de Trabajo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Carga Actual
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tecnicos as $tecnico)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-600">
                                                {{ strtoupper(substr($tecnico->user->nombre, 0, 1) . substr($tecnico->user->apellido, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $tecnico->user->nombre }} {{ $tecnico->user->apellido }}</div>
                                        <div class="text-sm text-gray-500">{{ $tecnico->user->email }}</div>
                                        <div class="text-xs text-gray-400">{{ $tecnico->telefono_trabajo ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @php
                                        $especialidades = json_decode($tecnico->especialidades, true) ?? [];
                                        $colorClasses = [
                                            'computadoras' => 'bg-blue-100 text-blue-800',
                                            'moviles' => 'bg-red-100 text-red-800',
                                            'tablets' => 'bg-indigo-100 text-indigo-800',
                                            'redes' => 'bg-green-100 text-green-800',
                                            'servidores' => 'bg-gray-100 text-gray-800',
                                            'hardware' => 'bg-purple-100 text-purple-800',
                                            'laptops' => 'bg-yellow-100 text-yellow-800',
                                            'reparacion_pantallas' => 'bg-pink-100 text-pink-800'
                                        ];
                                    @endphp
                                    @foreach($especialidades as $esp)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClasses[$esp] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $esp)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $nivelColors = [
                                        'junior' => 'bg-green-100 text-green-800',
                                        'semi-senior' => 'bg-blue-100 text-blue-800',
                                        'senior' => 'bg-yellow-100 text-yellow-800',
                                        'experto' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $nivelColors[$tecnico->nivel_experiencia] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('-', ' ', $tecnico->nivel_experiencia)) }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    Desde {{ \Carbon\Carbon::parse($tecnico->fecha_ingreso)->format('M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $tecnico->zona_trabajo }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                        @php
                                            $carga = $tecnico->carga_trabajo_actual;
                                            $color = $carga >= 90 ? 'bg-red-600' : ($carga >= 70 ? 'bg-orange-600' : 'bg-yellow-500');
                                        @endphp
                                        <div class="{{ $color }} h-2 rounded-full" style="width: {{ $carga }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $carga }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoColors = [
                                        'activo' => 'bg-green-100 text-green-800',
                                        'inactivo' => 'bg-red-100 text-red-800',
                                        'suspendido' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoColors[$tecnico->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    {{ ucfirst($tecnico->estado) }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    @if($tecnico->disponible)
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Disponible
                                    @else
                                        <i class="fas fa-times-circle text-red-500 mr-1"></i>No Disponible
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('tecnicos.show', $tecnico) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tecnicos.edit', $tecnico) }}" class="text-green-600 hover:text-green-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($tecnico->disponible)
                                        <button class="text-purple-600 hover:text-purple-900" title="Asignar orden">
                                            <i class="fas fa-tasks"></i>
                                        </button>
                                    @else
                                        <button class="text-gray-400" title="No disponible" disabled>
                                            <i class="fas fa-tasks"></i>
                                        </button>
                                    @endif
                                    <button class="text-yellow-600 hover:text-yellow-900" title="Contactar">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No hay técnicos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($tecnicos->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($tecnicos->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                            Anterior
                        </span>
                    @else
                        <a href="{{ $tecnicos->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Anterior
                        </a>
                    @endif
                    
                    @if ($tecnicos->hasMorePages())
                        <a href="{{ $tecnicos->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Siguiente
                        </a>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                            Siguiente
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Mostrando 
                            <span class="font-medium">{{ $tecnicos->firstItem() ?? 0 }}</span>
                            a 
                            <span class="font-medium">{{ $tecnicos->lastItem() ?? 0 }}</span>
                            de 
                            <span class="font-medium">{{ $tecnicos->total() }}</span>
                            técnicos
                        </p>
                    </div>
                    <div>
                        {{ $tecnicos->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection