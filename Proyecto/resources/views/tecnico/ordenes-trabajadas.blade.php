<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes Trabajadas - Baieco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools text-2xl text-white mr-3"></i>
                        <span class="text-white text-xl font-bold">Baieco</span>
                    </div>
                    <div class="ml-8 flex space-x-6">
                        <a href="{{ route('tecnico.dashboard') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('tecnico.ganancias') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
                            <i class="fas fa-dollar-sign mr-2"></i>Ganancias
                        </a>
                        <a href="{{ route('tecnico.ordenes-trabajadas') }}" class="text-white font-semibold border-b-2 border-white flex items-center">
                            <i class="fas fa-history mr-2"></i>Órdenes Trabajadas
                        </a>
                        <a href="{{ route('tecnico.perfil') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
                            <i class="fas fa-user mr-2"></i>Perfil
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</span>
                    <form method="POST" action="{{ route('tecnico.logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-history mr-2 text-blue-600"></i>Órdenes Trabajadas
                </h1>
                <p class="text-gray-600">Historial completo de órdenes completadas</p>
            </div>

            <!-- Estadísticas del Período -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Completadas -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Total Completadas</p>
                            <p class="text-3xl font-bold">{{ $estadisticas['total_completadas'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Ganado -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Total Ganado</p>
                            <p class="text-3xl font-bold">${{ number_format($estadisticas['total_ganado'], 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-dollar-sign text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Promedio Duración -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Promedio Duración</p>
                            <p class="text-3xl font-bold">{{ $estadisticas['promedio_duracion'] ? round($estadisticas['promedio_duracion']) : 0 }}h</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Mes Actual -->
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Mes Actual</p>
                            <p class="text-3xl font-bold">{{ $estadisticas['mes_actual'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros Avanzados -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-filter mr-2 text-purple-600"></i>Filtros Avanzados
                </h3>
                <form method="GET" action="{{ route('tecnico.ordenes-trabajadas') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Fecha Inicio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Fecha Fin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Cliente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                        <input type="text" name="cliente" value="{{ request('cliente') }}" 
                            placeholder="Nombre del cliente"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Tipo de Equipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Equipo</label>
                        <select name="equipo_tipo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Todos</option>
                            <option value="computadora" {{ request('equipo_tipo') == 'computadora' ? 'selected' : '' }}>Computadora</option>
                            <option value="laptop" {{ request('equipo_tipo') == 'laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="impresora" {{ request('equipo_tipo') == 'impresora' ? 'selected' : '' }}>Impresora</option>
                            <option value="servidor" {{ request('equipo_tipo') == 'servidor' ? 'selected' : '' }}>Servidor</option>
                            <option value="otro" {{ request('equipo_tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <!-- Comisión Mínima -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Comisión Mínima</label>
                        <input type="number" name="comision_min" value="{{ request('comision_min') }}" 
                            placeholder="$ Mínimo"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Ordenar Por -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar Por</label>
                        <select name="orden_por" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="fecha_completada" {{ request('orden_por') == 'fecha_completada' ? 'selected' : '' }}>Fecha Completada</option>
                            <option value="comision_tecnico" {{ request('orden_por') == 'comision_tecnico' ? 'selected' : '' }}>Comisión</option>
                            <option value="costo_total" {{ request('orden_por') == 'costo_total' ? 'selected' : '' }}>Costo Total</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="flex-1 px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Buscar
                        </button>
                        <a href="{{ route('tecnico.ordenes-trabajadas') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabla de Órdenes -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">
                        <i class="fas fa-list mr-2 text-blue-600"></i>Historial de Órdenes Completadas
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Número de Orden
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Equipo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Completada
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Duración
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Costo Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Comisión
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($ordenes as $orden)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-purple-600">{{ $orden->numero_orden }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $orden->cliente->nombre_completo ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $orden->cliente->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $orden->equipo->tipo_equipo ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $orden->equipo->marca->nombre ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $orden->fecha_completada ? $orden->fecha_completada->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($orden->fecha_inicio_trabajo && $orden->fecha_completada)
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ round($orden->fecha_inicio_trabajo->diffInHours($orden->fecha_completada)) }}h
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">
                                            ${{ number_format($orden->costo_total, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-green-800 bg-green-100">
                                            <i class="fas fa-dollar-sign mr-1"></i>
                                            {{ number_format($orden->comision_tecnico, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('tecnico.ordenes.show', $orden->id) }}" 
                                            class="text-purple-600 hover:text-purple-900 transition-colors">
                                            <i class="fas fa-eye mr-1"></i>Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                                        <p class="text-gray-500 text-lg">No se encontraron órdenes con los filtros aplicados</p>
                                        <a href="{{ route('tecnico.ordenes-trabajadas') }}" class="mt-4 inline-block text-purple-600 hover:text-purple-800">
                                            Limpiar filtros
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($ordenes->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $ordenes->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>
</html>
