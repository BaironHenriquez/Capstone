@extends('layouts.admin')

@section('title', 'Gestión de Equipos y Marcas')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestión de Equipos y Marcas</h1>
        <p class="mt-2 text-gray-600">Catálogo completo de equipos, marcas y asociaciones con clientes</p>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <!-- Total Marcas -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-blue-100 text-sm font-medium">Total Marcas</p>
                    <p class="text-3xl font-bold">{{ number_format($totalMarcas) }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Marcas Activas -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-green-100 text-sm font-medium">Marcas Activas</p>
                    <p class="text-3xl font-bold">{{ number_format($marcasActivas) }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Equipos -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-purple-100 text-sm font-medium">Total Equipos</p>
                    <p class="text-3xl font-bold">{{ number_format($totalEquipos) }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-laptop text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Equipos Activos -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-orange-100 text-sm font-medium">Equipos Activos</p>
                    <p class="text-3xl font-bold">{{ number_format($equiposActivos) }}</p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-desktop text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Equipos en Clientes -->
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-teal-100 text-sm font-medium">En Clientes</p>
                    <p class="text-3xl font-bold">{{ number_format($totalClienteEquipos) }}</p>
                </div>
                <div class="bg-teal-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Con Garantía -->
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-indigo-100 text-sm font-medium">Con Garantía</p>
                    <p class="text-3xl font-bold">{{ number_format($equiposConGarantia) }}</p>
                </div>
                <div class="bg-indigo-400 bg-opacity-30 rounded-lg p-3">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-capstone-500 to-capstone-600">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-bolt mr-2"></i>
                Acciones Rápidas
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Gestión de Marcas -->
                <a href="{{ route('admin.equipos-marcas.marcas.index') }}" 
                   class="group p-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-tags text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">GESTIÓN</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Marcas</h3>
                    <p class="text-sm opacity-80">Administrar catálogo de marcas</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Gestionar</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Gestión de Equipos -->
                <a href="{{ route('admin.equipos-marcas.equipos.index') }}" 
                   class="group p-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl text-white hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-laptop text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">CATÁLOGO</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Equipos</h3>
                    <p class="text-sm opacity-80">Administrar catálogo de equipos</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Gestionar</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Asociaciones Cliente-Equipo -->
                <a href="{{ route('admin.equipos-marcas.cliente-equipos.index') }}" 
                   class="group p-6 bg-gradient-to-br from-green-500 to-green-600 rounded-xl text-white hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-link text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">ASOCIACIONES</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Cliente-Equipos</h3>
                    <p class="text-sm opacity-80">Equipos asociados a clientes</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver asociaciones</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Crear Nueva Marca -->
                <a href="{{ route('admin.equipos-marcas.marcas.create') }}" 
                   class="group p-6 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl text-white hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-plus-circle text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">NUEVO</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Nueva Marca</h3>
                    <p class="text-sm opacity-80">Registrar nueva marca</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Crear marca</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Marcas Más Populares -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-star mr-2"></i>
                    Marcas Más Populares
                </h2>
            </div>
            <div class="p-6">
                @if($marcasPopulares->count() > 0)
                    <div class="space-y-4">
                        @foreach($marcasPopulares as $marca)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tag text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $marca->nombre_marca }}</h4>
                                        <p class="text-sm text-gray-600">{{ $marca->categoria ?? 'Sin categoría' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600">{{ $marca->equipos_count }}</div>
                                    <div class="text-sm text-gray-500">equipos</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-tags text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No hay marcas registradas aún.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Categorías de Equipos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-th-list mr-2"></i>
                    Categorías de Equipos
                </h2>
            </div>
            <div class="p-6">
                @if($categorias->count() > 0)
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($categorias as $categoria)
                            <div class="p-4 bg-gray-50 rounded-lg text-center">
                                <div class="text-2xl font-bold text-purple-600">{{ $categoria->total }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $categoria->categoria }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-laptop text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No hay equipos categorizados aún.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Equipos que Necesitan Mantenimiento -->
    @if($equiposMantenimiento->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-tools mr-2"></i>
                    Equipos que Necesitan Mantenimiento
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Equipo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número de Serie
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
                        @foreach($equiposMantenimiento as $clienteEquipo)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                <i class="fas fa-laptop text-purple-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $clienteEquipo->equipo->marca->nombre_marca }} {{ $clienteEquipo->equipo->modelo }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $clienteEquipo->equipo->tipo_equipo }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $clienteEquipo->cliente->nombre_completo }}</div>
                                    <div class="text-sm text-gray-500">{{ $clienteEquipo->cliente->empresa ?? 'Sin empresa' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $clienteEquipo->numero_serie }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clienteEquipo->estado_badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $clienteEquipo->estado)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.equipos-marcas.cliente-equipos.show', $clienteEquipo->id) }}" 
                                       class="text-capstone-600 hover:text-capstone-900 mr-3">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="#" 
                                       class="text-orange-600 hover:text-orange-900">
                                        <i class="fas fa-tools"></i> Programar Mantto.
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection