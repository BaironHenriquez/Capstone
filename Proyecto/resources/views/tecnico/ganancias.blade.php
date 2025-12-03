<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ganancias - Baieco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <a href="{{ route('tecnico.ganancias') }}" class="text-white font-semibold border-b-2 border-white flex items-center">
                            <i class="fas fa-dollar-sign mr-2"></i>Ganancias
                        </a>
                        <a href="{{ route('tecnico.ordenes-trabajadas') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
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
                    <i class="fas fa-dollar-sign mr-2 text-green-600"></i>Mis Ganancias
                </h1>
                <p class="text-gray-600">Visualiza tus ingresos y comisiones generadas</p>
            </div>

            <!-- Filtros de Fecha -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('tecnico.ganancias') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ $fechaFin }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                    <a href="{{ route('tecnico.ganancias') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-redo mr-2"></i>Limpiar
                    </a>
                </form>
            </div>

            <!-- Tarjetas de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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

                <!-- Órdenes Completadas -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Órdenes Completadas</p>
                            <p class="text-3xl font-bold">{{ $estadisticas['ordenes_completadas'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Promedio por Orden -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Promedio por Orden</p>
                            <p class="text-3xl font-bold">${{ number_format($estadisticas['promedio_por_orden'], 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Mes Actual -->
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90 mb-1">Mes Actual</p>
                            <p class="text-3xl font-bold">${{ number_format($estadisticas['mes_actual'], 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Ganancias Mensuales -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-chart-area mr-2 text-purple-600"></i>Ganancias Mensuales (Últimos 6 Meses)
                </h3>
                <div class="h-80">
                    <canvas id="gananciasChart"></canvas>
                </div>
            </div>

            <!-- Top 5 Órdenes Más Rentables -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-trophy mr-2 text-yellow-500"></i>Top 5 Órdenes Más Rentables
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Orden
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Equipo
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Comisión
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($topOrdenes as $index => $orden)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($index < 3)
                                                <i class="fas fa-medal text-{{ $index == 0 ? 'yellow' : ($index == 1 ? 'gray' : 'orange') }}-500 mr-2"></i>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900">{{ $orden->numero_orden }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $orden->cliente->nombre_completo ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $orden->equipo->tipo_equipo ?? 'N/A' }} - {{ $orden->equipo->marca->nombre ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $orden->fecha_completada ? $orden->fecha_completada->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold text-green-600">
                                            ${{ number_format($orden->comision_tecnico, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                        <p>No hay órdenes completadas aún</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detalle de Órdenes Completadas -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-list mr-2 text-blue-600"></i>Detalle de Órdenes Completadas
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Número de Orden
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Equipo
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Completada
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Costo Total
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Comisión
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($ordenesCompletadas as $orden)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('tecnico.ordenes.show', $orden->id) }}" class="text-sm font-medium text-purple-600 hover:text-purple-800">
                                            {{ $orden->numero_orden }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $orden->cliente->nombre_completo ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $orden->equipo->tipo_equipo ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $orden->fecha_completada ? $orden->fecha_completada->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ${{ number_format($orden->costo_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-green-600">
                                            ${{ number_format($orden->comision_tecnico, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                        <p>No hay órdenes completadas en este período</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Gráfico de ganancias mensuales
        const ctx = document.getElementById('gananciasChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($gananciasPorMes, 'mes')) !!},
                datasets: [{
                    label: 'Ganancias ($)',
                    data: {!! json_encode(array_column($gananciasPorMes, 'ganancia')) !!},
                    borderColor: 'rgb(147, 51, 234)',
                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgb(147, 51, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Ganancia: $' + context.parsed.y.toLocaleString('es-CL');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-CL');
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
