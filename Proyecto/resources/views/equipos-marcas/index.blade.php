@extends('layouts.admin')

@section('title', 'Gestión de Equipos y Marcas')

@section('header')
<!-- Title Section -->
<div class="mb-8 text-center">
    <h2 class="text-3xl font-bold text-sky-800 mb-2">Gestión de Equipos y Marcas</h2>
    <p class="text-gray-700">Administra el catálogo de equipos electrónicos y marcas disponibles para reparación</p>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-gradient-to-br from-sky-100 to-sky-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-sky-700 mb-1">Total Marcas</h3>
            <p class="text-3xl font-bold text-sky-900">{{ number_format($totalMarcas) }}</p>
        </div>
        <div class="bg-gradient-to-br from-amber-100 to-yellow-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-amber-700 mb-1">Total Equipos</h3>
            <p class="text-3xl font-bold text-amber-900">{{ number_format($totalEquipos) }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-orange-700 mb-1">En Clientes</h3>
            <p class="text-3xl font-bold text-orange-900">{{ number_format($totalClienteEquipos) }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-100 to-emerald-200 rounded-xl p-6 shadow-md">
            <h3 class="text-sm font-semibold text-green-700 mb-1">Con Garantía</h3>
            <p class="text-3xl font-bold text-green-900">{{ number_format($equiposConGarantia) }}</p>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 mb-10">
        <h3 class="text-lg font-semibold text-teal-700 mb-4">Acciones Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.equipos-marcas.marcas.index') }}" class="flex items-center p-4 rounded-lg bg-gradient-to-r from-sky-400 to-blue-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Gestionar Marcas</h4>
                    <p class="text-sm text-blue-50">Catálogo de marcas</p>
                </div>
            </a>

            <a href="{{ route('admin.equipos-marcas.equipos.index') }}" class="flex items-center p-4 rounded-lg bg-gradient-to-r from-green-400 to-emerald-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Gestionar Equipos</h4>
                    <p class="text-sm text-green-50">Catálogo de equipos</p>
                </div>
            </a>

            <a href="{{ route('admin.equipos-marcas.cliente-equipos.index') }}" class="flex items-center p-4 rounded-lg bg-gradient-to-r from-purple-400 to-fuchsia-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Asociaciones</h4>
                    <p class="text-sm text-purple-50">Cliente-Equipos</p>
                </div>
            </a>

            <a href="#reportes" class="flex items-center p-4 rounded-lg bg-gradient-to-r from-amber-400 to-orange-500 text-white hover:opacity-90 transition">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <div class="text-left">
                    <h4 class="font-medium">Reportes</h4>
                    <p class="text-sm text-orange-50">Estadísticas</p>
                </div>
            </a>
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

    <!-- Marcas Más Populares -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
        <h3 class="text-lg font-semibold text-teal-700 mb-4">Marcas Más Populares</h3>
        <div class="space-y-4">
            @if($marcasPopulares->count() > 0)
                @foreach($marcasPopulares as $marca)
                <div class="flex items-center justify-between p-4 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-sky-200 to-sky-300 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-sm font-semibold text-sky-800">#{{ $loop->iteration }}</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $marca->nombre }}</h4>
                            <p class="text-sm text-gray-600">{{ $marca->categoria ?? 'Sin categoría' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-emerald-200 text-emerald-800">
                            {{ $marca->equipos_count }} equipos
                        </span>
                        <button class="text-sky-600 hover:text-sky-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <p class="text-gray-600">No hay marcas registradas aún.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Equipos que Necesitan Mantenimiento -->
    @if($equiposMantenimiento->count() > 0)
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 mt-10">
            <h3 class="text-lg font-semibold text-teal-700 mb-4">Equipos que Necesitan Mantenimiento</h3>
            <div class="space-y-4">
                @foreach($equiposMantenimiento as $clienteEquipo)
                <div class="flex items-center justify-between p-4 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-200 to-amber-300 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $clienteEquipo->equipo->marca->nombre }} {{ $clienteEquipo->equipo->modelo }}</h4>
                            <p class="text-sm text-gray-600">{{ $clienteEquipo->cliente->nombre_completo }} - {{ $clienteEquipo->numero_serie }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-amber-200 text-amber-800">
                            {{ ucfirst(str_replace('_', ' ', $clienteEquipo->estado)) }}
                        </span>
                        <button class="text-sky-600 hover:text-sky-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection