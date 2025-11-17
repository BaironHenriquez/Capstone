@extends('shared.layouts.admin')

@section('title', 'Historial de Órdenes')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('dashboard-admin') }}" 
                       class="bg-white bg-opacity-20 hover:bg-opacity-30 p-2 rounded-lg transition-all">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-3xl font-bold">📊 Historial de Órdenes</h1>
                </div>
                <p class="text-blue-100">Registro completo de todas las órdenes de servicio con detalles y precios</p>
            </div>
            <button onclick="window.print()" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition-all">
                <i class="fas fa-print mr-2"></i>Imprimir
            </button>
        </div>
    </div>

    {{-- Estadísticas Resumidas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">{{ number_format($estadisticas['total_ordenes']) }}</p>
            <p class="text-sm text-blue-100">Total de Órdenes</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">{{ number_format($estadisticas['completadas']) }}</p>
            <p class="text-sm text-green-100">Completadas</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">${{ number_format($estadisticas['total_facturado'], 0, ',', '.') }}</p>
            <p class="text-sm text-purple-100">Total Facturado</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-calendar text-2xl"></i>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">${{ number_format($estadisticas['facturado_mes'], 0, ',', '.') }}</p>
            <p class="text-sm text-orange-100">Facturado Este Mes</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center mb-4">
            <i class="fas fa-filter text-blue-500 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-900">Filtros de Búsqueda</h2>
        </div>

        <form method="GET" action="{{ route('admin.ordenes.historicas') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Búsqueda general --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           name="buscar" 
                           value="{{ request('buscar') }}"
                           placeholder="N° orden, cliente, descripción..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="asignada" {{ request('estado') == 'asignada' ? 'selected' : '' }}>Asignada</option>
                        <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="diagnostico" {{ request('estado') == 'diagnostico' ? 'selected' : '' }}>Diagnóstico</option>
                        <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                {{-- Técnico --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Técnico</label>
                    <select name="tecnico_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos los técnicos</option>
                        @foreach($tecnicos as $tecnico)
                            <option value="{{ $tecnico->id }}" {{ request('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                                {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Ordenar por --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                    <select name="orden_por" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="fecha_ingreso" {{ request('orden_por') == 'fecha_ingreso' ? 'selected' : '' }}>Fecha Ingreso</option>
                        <option value="numero_orden" {{ request('orden_por') == 'numero_orden' ? 'selected' : '' }}>N° Orden</option>
                        <option value="precio_presupuestado" {{ request('orden_por') == 'precio_presupuestado' ? 'selected' : '' }}>Precio</option>
                        <option value="estado" {{ request('orden_por') == 'estado' ? 'selected' : '' }}>Estado</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Fecha desde --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                    <input type="date" 
                           name="fecha_desde" 
                           value="{{ request('fecha_desde') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Fecha hasta --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                    <input type="date" 
                           name="fecha_hasta" 
                           value="{{ request('fecha_hasta') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Dirección --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                    <select name="direccion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="desc" {{ request('direccion') == 'desc' ? 'selected' : '' }}>Más reciente primero</option>
                        <option value="asc" {{ request('direccion') == 'asc' ? 'selected' : '' }}>Más antiguo primero</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                <a href="{{ route('admin.ordenes.historicas') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- Listado de Órdenes - Formato Card Responsivo --}}
    <div class="space-y-4">
        @forelse($ordenes as $orden)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all overflow-hidden">
                {{-- Header de la Card --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-blue-600">{{ $orden->numero_orden }}</span>
                            @php
                                $estadoConfig = match($orden->estado) {
                                    'pendiente' => ['color' => 'yellow', 'icon' => 'clock', 'texto' => 'Pendiente'],
                                    'asignada' => ['color' => 'blue', 'icon' => 'user-check', 'texto' => 'Asignada'],
                                    'en_proceso' => ['color' => 'indigo', 'icon' => 'tools', 'texto' => 'En Proceso'],
                                    'diagnostico' => ['color' => 'purple', 'icon' => 'search', 'texto' => 'Diagnóstico'],
                                    'completada' => ['color' => 'green', 'icon' => 'check-circle', 'texto' => 'Completada'],
                                    'cancelada' => ['color' => 'red', 'icon' => 'times-circle', 'texto' => 'Cancelada'],
                                    default => ['color' => 'gray', 'icon' => 'question', 'texto' => ucfirst($orden->estado)]
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $estadoConfig['color'] }}-100 text-{{ $estadoConfig['color'] }}-700 flex items-center gap-1">
                                <i class="fas fa-{{ $estadoConfig['icon'] }}"></i>
                                {{ $estadoConfig['texto'] }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">
                                <i class="far fa-calendar text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($orden->fecha_ingreso)->format('d/m/Y') }}
                            </span>
                            <div class="flex gap-2 ml-2">
                                <a href="{{ route('ordenes.show', $orden->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs font-medium transition-colors"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('ordenes.edit', $orden->id) }}" 
                                   class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-md text-xs font-medium transition-colors"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cuerpo de la Card --}}
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Cliente --}}
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 mb-1">Cliente</p>
                                <p class="font-semibold text-gray-900 truncate">
                                    {{ $orden->cliente->nombre ?? 'N/A' }} {{ $orden->cliente->apellido ?? '' }}
                                </p>
                                @if($orden->cliente && $orden->cliente->telefono)
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-phone text-gray-400"></i>
                                        {{ $orden->cliente->telefono }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Equipo --}}
                        <div class="flex items-start gap-3">
                            <div class="bg-purple-100 rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-laptop text-purple-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 mb-1">Equipo</p>
                                @if($orden->equipo)
                                    <p class="font-semibold text-gray-900">{{ $orden->equipo->tipo }}</p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        {{ $orden->equipo->marca->nombre ?? 'Sin marca' }} 
                                        {{ $orden->equipo->modelo ?? '' }}
                                    </p>
                                @else
                                    <p class="text-gray-400 italic text-sm">Sin equipo</p>
                                @endif
                            </div>
                        </div>

                        {{-- Técnico --}}
                        <div class="flex items-start gap-3">
                            <div class="bg-green-100 rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-user-cog text-green-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 mb-1">Técnico</p>
                                <p class="font-semibold text-gray-900 truncate">
                                    {{ $orden->tecnico ? $orden->tecnico->nombre . ' ' . $orden->tecnico->apellido : 'Sin asignar' }}
                                </p>
                            </div>
                        </div>

                        {{-- Precio --}}
                        <div class="flex items-start gap-3">
                            <div class="bg-orange-100 rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-dollar-sign text-orange-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 mb-1">Precio</p>
                                @if($orden->precio_presupuestado)
                                    <p class="text-xl font-bold text-green-600">
                                        ${{ number_format($orden->precio_presupuestado, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="text-gray-400 italic text-sm">Sin presupuestar</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Problema --}}
                    @if($orden->descripcion_problema)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-tools text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Problema reportado</p>
                                    <p class="text-sm text-gray-700 line-clamp-2">{{ $orden->descripcion_problema }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                    <p class="text-xl font-semibold mb-2">No se encontraron órdenes</p>
                    <p class="text-sm text-gray-400">Intenta ajustar los filtros de búsqueda</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginación y Resumen --}}
    @if($ordenes->hasPages() || $ordenes->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        Mostrando <strong class="text-gray-900">{{ $ordenes->firstItem() ?? 0 }} - {{ $ordenes->lastItem() ?? 0 }}</strong> de <strong class="text-gray-900">{{ $ordenes->total() }}</strong> órdenes
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <div class="bg-white px-3 py-1.5 rounded-lg border border-green-200 shadow-sm">
                        <span class="text-xs text-gray-500">Precio promedio:</span>
                        <strong class="text-green-600 ml-1">${{ number_format($estadisticas['promedio_precio'], 0, ',', '.') }}</strong>
                    </div>
                    <div class="bg-white px-3 py-1.5 rounded-lg border border-blue-200 shadow-sm">
                        <span class="text-xs text-gray-500">Total en página:</span>
                        <strong class="text-blue-600 ml-1">${{ number_format($ordenes->sum('precio_presupuestado'), 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        @if($ordenes->hasPages())
        <div class="px-6 py-4">
            {{ $ordenes->links() }}
        </div>
        @endif
    </div>
    @endif
</div>

<style>
@media print {
    .bg-gradient-to-r button,
    form,
    .fas.fa-eye,
    .fas.fa-edit {
        display: none !important;
    }
}
</style>
@endsection
