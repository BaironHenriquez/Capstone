<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .dashboard-card {
            animation: fadeInScale 0.6s ease-out;
        }
        
        .dashboard-metric {
            animation: slideInUp 0.5s ease-out;
        }
        
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .animate-slide-down {
            animation: slideDown 0.6s ease-out;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-tech-dark-blue shadow-lg sticky top-0 z-50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 animate-scale-in">
                        <span class="text-tech-pure-white text-2xl font-bold">TechService Pro</span>
                    </div>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">Inicio</a>
                        <a href="{{ route('dashboard-admin') }}" class="text-tech-electric-blue bg-blue-600 px-3 py-2 rounded-md text-sm font-medium">Panel</a>
                        <a href="{{ route('admin.gestion-tecnicos') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                            <i class="fas fa-users-cog mr-1"></i>Técnicos
                        </a>
                        <a href="{{ route('admin.clientes.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                            <i class="fas fa-users mr-1"></i>Clientes
                        </a>
                        <a href="{{ route('ordenes.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">Órdenes</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-tech-pure-white text-sm">
                        <span class="hidden sm:inline">Panel </span>
                        <span class="font-semibold">Técnico Administrador</span>
                    </div>
                    <a href="{{ route('home') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Dashboard Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel de Control Técnico</h1>
            <p class="text-gray-600">Resumen general del estado del servicio técnico</p>
            <div class="text-sm text-gray-500 mt-1">
                Última actualización: {{ date('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Resumen de Órdenes - Sección Unificada -->
        <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 hover-lift">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-chart-pie text-blue-600 mr-2"></i>
                    Distribución de Órdenes de Servicio
                </h2>
                <div class="text-sm text-gray-500">
                    Total: {{ $resumenOrdenes['total'] }} órdenes
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Gráfico de Distribución -->
                <div class="flex justify-center">
                    <div class="chart-container" style="height: 350px; width: 100%;">
                        <canvas id="ordenesChart"></canvas>
                    </div>
                </div>
                
                <!-- Detalles Numéricos -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Completadas</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['completadas'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-green-600">
                                {{ round(($resumenOrdenes['completadas'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                            <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($resumenOrdenes['completadas'] / $resumenOrdenes['total']) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <i class="fas fa-tools text-blue-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-600">En Progreso</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['en_progreso'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-blue-600">
                                {{ round(($resumenOrdenes['en_progreso'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                            <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($resumenOrdenes['en_progreso'] / $resumenOrdenes['total']) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-yellow-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pendientes</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['pendientes'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-yellow-600">
                                {{ round(($resumenOrdenes['pendientes'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                            <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ ($resumenOrdenes['pendientes'] / $resumenOrdenes['total']) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt text-red-600 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-600">En Revisión</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['revision_necesaria'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-red-600">
                                {{ round(($resumenOrdenes['revision_necesaria'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                            <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($resumenOrdenes['revision_necesaria'] / $resumenOrdenes['total']) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Crecimiento -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Crecimiento mensual</p>
                                <p class="text-lg font-semibold text-green-600">+{{ $metricas['crecimiento'] }}%</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">vs mes anterior</p>
                                <p class="text-sm text-gray-500">{{ $resumenOrdenes['total'] - round($resumenOrdenes['total'] / (1 + $metricas['crecimiento']/100)) }} órdenes más</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos de Administración -->
        <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 hover-lift">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-rocket text-capstone-600 mr-2"></i>
                    Accesos Rápidos de Administración
                </h2>
                <div class="text-sm text-gray-500">
                    Gestión del sistema
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Gestión de Técnicos -->
                <a href="{{ route('admin.gestion-tecnicos') }}" 
                   class="group p-6 bg-gradient-to-br from-capstone-500 to-capstone-600 rounded-xl text-white hover:from-capstone-600 hover:to-capstone-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-users-cog text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">NUEVO</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Gestión de Técnicos</h3>
                    <p class="text-sm opacity-80">Crear, editar y administrar técnicos del sistema</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver todos</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Órdenes de Servicio -->
                <a href="{{ route('ordenes.index') }}" 
                   class="group p-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-clipboard-list text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">{{ $resumenOrdenes['pendientes'] }}</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Órdenes de Servicio</h3>
                    <p class="text-sm opacity-80">Gestionar y supervisar órdenes activas</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Administrar</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Gestión de Clientes -->
                <a href="{{ route('admin.clientes.index') }}" 
                   class="group p-6 bg-gradient-to-br from-green-500 to-green-600 rounded-xl text-white hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-users text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">NUEVO</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Gestión de Clientes</h3>
                    <p class="text-sm opacity-80">Crear, editar y administrar clientes del sistema</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver todos</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Reportes -->
                <a href="#" 
                   class="group p-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl text-white hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-chart-bar text-3xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                        <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">STATS</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Reportes</h3>
                    <p class="text-sm opacity-80">Estadísticas y análisis detallados</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver reportes</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Productividad Semanal -->
        <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 hover-lift">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-chart-line text-green-600 mr-2"></i>
                Productividad Semanal
            </h2>
            <div class="chart-container" style="height: 300px;">
                <canvas id="productividadChart"></canvas>
            </div>
        </div>


        <!-- Carga Laboral de Técnicos - Layout Mejorado -->
        <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 hover-lift">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-users text-blue-600 mr-2"></i>
                    Carga Laboral de Técnicos
                </h2>
                <span class="text-sm text-gray-500">{{ count($tecnicos) }} técnicos activos</span>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Lista de Técnicos -->
                <div class="space-y-4">
                    @foreach($tecnicos as $tecnico)
                    <div class="dashboard-metric">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold
                                    @if($tecnico['estado'] == 'sobrecargado') bg-red-100 text-red-700
                                    @elseif($tecnico['estado'] == 'activo') bg-blue-100 text-blue-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ substr($tecnico['nombre'], 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $tecnico['nombre'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $tecnico['especialidad'] == 'Computadoras' ? 'Computadores' : $tecnico['especialidad'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ $tecnico['carga_trabajo'] }}%</p>
                                <p class="text-xs text-gray-500">{{ $tecnico['ordenes_asignadas'] }} asignadas</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full progress-bar transition-all duration-1000
                                @if($tecnico['carga_trabajo'] >= 90) bg-red-500
                                @elseif($tecnico['carga_trabajo'] >= 70) bg-yellow-500
                                @else bg-green-500
                                @endif" 
                                style="width: {{ $tecnico['carga_trabajo'] }}%">
                            </div>
                        </div>
                        @if($tecnico['estado'] == 'sobrecargado')
                            <p class="text-xs text-red-600 mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Sobrecargado - Requiere redistribución
                            </p>
                        @elseif($tecnico['estado'] == 'disponible')
                            <p class="text-xs text-green-600 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>
                                Disponible para nuevas asignaciones
                            </p>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Gráfico de Barras de Técnicos -->
                <div>
                    <h3 class="text-md font-medium text-gray-900 mb-4">Comparativa de Carga</h3>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="tecnicosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas - Layout Mejorado -->
        <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 hover-lift">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-bell text-orange-600 mr-2"></i>
                    Alertas
                </h2>
                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ count($alertas) }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($alertas as $alerta)
                <div class="dashboard-metric border-l-4 pl-4 
                    @if($alerta['prioridad'] == 'alta') border-red-500 bg-red-50
                    @elseif($alerta['prioridad'] == 'media') border-yellow-500 bg-yellow-50
                    @else border-blue-500 bg-blue-50
                    @endif rounded-r-lg p-3">
                    
                    @if($alerta['tipo'] == 'retraso_critico')
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-500 text-lg mr-2 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Retraso Crítico</p>
                                <p class="text-xs text-gray-600">Orden {{ $alerta['orden'] }}</p>
                                <p class="text-xs text-gray-600">{{ $alerta['dias_retraso'] }} días de retraso</p>
                                <p class="text-xs text-gray-500">Técnico: {{ $alerta['tecnico'] }}</p>
                            </div>
                        </div>
                    @elseif($alerta['tipo'] == 'sobrecarga_tecnico')
                        <div class="flex items-start">
                            <i class="fas fa-user-clock text-yellow-500 text-lg mr-2 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Sobrecarga</p>
                                <p class="text-xs text-gray-600">{{ $alerta['tecnico'] }}</p>
                                <p class="text-xs text-gray-600">{{ $alerta['carga'] }}% de carga</p>
                                <p class="text-xs text-gray-500">{{ $alerta['ordenes_pendientes'] }} órdenes pendientes</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start">
                            <i class="fas fa-file-alt text-blue-500 text-lg mr-2 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Revisión Pendiente</p>
                                <p class="text-xs text-gray-600">Orden {{ $alerta['orden'] }}</p>
                                <p class="text-xs text-gray-600">{{ $alerta['dias_pendiente'] }} días sin revisar</p>
                                <p class="text-xs text-gray-500">Cliente: {{ $alerta['cliente'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <button class="w-full text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-300">
                    <i class="fas fa-eye mr-1"></i>
                    Ver todas las alertas
                </button>
            </div>
        </div>

        <!-- Métricas de Rendimiento -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-stopwatch text-blue-600 text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Tiempo Promedio</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $metricas['tiempo_promedio_resolucion'] }}</p>
                    <p class="text-sm text-gray-500">días por orden</p>
                </div>
            </div>

            <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-smile text-green-600 text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Satisfacción</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $metricas['satisfaccion_cliente'] }}%</p>
                    <p class="text-sm text-gray-500">promedio cliente</p>
                </div>
            </div>

            <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Crecimiento</p>
                    <p class="text-3xl font-bold text-gray-900">+{{ $metricas['crecimiento'] }}%</p>
                    <p class="text-sm text-gray-500">este mes</p>
                </div>
            </div>

            <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop text-orange-600 text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Computadores</p>
                    <p class="text-3xl font-bold text-gray-900">{{ round($resumenOrdenes['total'] * 0.65) }}</p>
                    <p class="text-sm text-gray-500">reparaciones activas</p>
                </div>
            </div>
        </div>

        <!-- Estadísticas por Tipo de Servicio -->
        <div class="dashboard-card bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 hover-lift">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>
                Estadísticas por Tipo de Servicio
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Computadores -->
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <i class="fas fa-desktop text-blue-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Computadores</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">En reparación:</span>
                            <span class="font-medium">{{ round($resumenOrdenes['total'] * 0.45) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Completadas:</span>
                            <span class="font-medium text-green-600">{{ round($resumenOrdenes['completadas'] * 0.50) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tiempo prom:</span>
                            <span class="font-medium">3.5 días</span>
                        </div>
                    </div>
                </div>

                <!-- Móviles -->
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <i class="fas fa-mobile-alt text-green-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Móviles</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">En reparación:</span>
                            <span class="font-medium">{{ round($resumenOrdenes['total'] * 0.25) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Completadas:</span>
                            <span class="font-medium text-green-600">{{ round($resumenOrdenes['completadas'] * 0.30) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tiempo prom:</span>
                            <span class="font-medium">2.1 días</span>
                        </div>
                    </div>
                </div>

                <!-- Soporte -->
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <i class="fas fa-headset text-purple-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Soporte Técnico</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">En proceso:</span>
                            <span class="font-medium">{{ round($resumenOrdenes['total'] * 0.15) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Resueltos:</span>
                            <span class="font-medium text-green-600">{{ round($resumenOrdenes['completadas'] * 0.20) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tiempo prom:</span>
                            <span class="font-medium">1.8 días</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; 2025 TechService Pro - Panel Técnico Administrador</p>
            </div>
        </div>
    </footer>

    <script>
        // Configuración de gráficos
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfico de distribución de órdenes (Donut)
            const ctxOrdenes = document.getElementById('ordenesChart').getContext('2d');
            new Chart(ctxOrdenes, {
                type: 'doughnut',
                data: {
                    labels: ['Completadas', 'En Progreso', 'Pendientes', 'En Revisión'],
                    datasets: [{
                        data: [{{ $resumenOrdenes['completadas'] }}, {{ $resumenOrdenes['en_progreso'] }}, {{ $resumenOrdenes['pendientes'] }}, {{ $resumenOrdenes['revision_necesaria'] }}],
                        backgroundColor: [
                            '#10B981',
                            '#3B82F6', 
                            '#F59E0B',
                            '#EF4444'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Gráfico de productividad semanal (Línea)
            const ctxProductividad = document.getElementById('productividadChart').getContext('2d');
            new Chart(ctxProductividad, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    datasets: [{
                        label: 'Órdenes Completadas',
                        data: [12, 15, 18, 14, 20, 8, 5],
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Gráfico de técnicos (Barras horizontales)
            const ctxTecnicos = document.getElementById('tecnicosChart').getContext('2d');
            new Chart(ctxTecnicos, {
                type: 'bar',
                data: {
                    labels: ['Carlos R.', 'Maria G.', 'Diego S.', 'Ana T.'],
                    datasets: [{
                        label: 'Carga de Trabajo (%)',
                        data: [85, 65, 95, 45],
                        backgroundColor: [
                            '#F59E0B',
                            '#10B981', 
                            '#EF4444',
                            '#10B981'
                        ],
                        borderColor: [
                            '#D97706',
                            '#059669',
                            '#DC2626', 
                            '#059669'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>