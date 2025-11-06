@extends('shared.layouts.admin')

@section('title', 'Panel Administrativo')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .progress-bar {
        transition: width 1s ease-in-out;
    }
    .alert-card {
        border-left: 4px solid;
        transition: all 0.2s ease;
    }
    .alert-card:hover {
        transform: translateX(5px);
    }
    .alert-critical { border-color: #ef4444; background: #fef2f2; }
    .alert-warning { border-color: #f59e0b; background: #fffbeb; }
    .alert-info { border-color: #3b82f6; background: #eff6ff; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Panel de Control Técnico</h1>
                <p class="text-gray-600">Resumen general del estado del servicio técnico</p>
                <p class="text-sm text-gray-500 mt-2">Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Distribución de Órdenes --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <i class="fas fa-chart-pie text-blue-500 text-xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-900">Distribución de Órdenes de Servicio</h2>
            </div>
            <span class="text-sm text-gray-600">Total: <strong>{{ $resumenOrdenes['total'] ?? 0 }}</strong> órdenes</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Gráfico de Donut --}}
            <div class="flex items-center justify-center">
                <div style="max-width: 400px; max-height: 400px;">
                    <canvas id="ordenesChart"></canvas>
                </div>
            </div>

            {{-- Estadísticas detalladas --}}
            <div class="space-y-4">
                {{-- Completadas --}}
                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-green-500 rounded-full p-3 mr-4">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Completadas</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $resumenOrdenes['completadas'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">
                                {{ $resumenOrdenes['total'] > 0 ? number_format(($resumenOrdenes['completadas'] / $resumenOrdenes['total']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                {{-- En Progreso --}}
                <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-blue-500 rounded-full p-3 mr-4">
                                <i class="fas fa-tools text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">En Progreso</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $resumenOrdenes['en_progreso'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $resumenOrdenes['total'] > 0 ? number_format(($resumenOrdenes['en_progreso'] / $resumenOrdenes['total']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Pendientes --}}
                <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-3 mr-4">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Pendientes</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $resumenOrdenes['pendientes'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ $resumenOrdenes['total'] > 0 ? number_format(($resumenOrdenes['pendientes'] / $resumenOrdenes['total']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                {{-- En Revisión --}}
                <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-red-500 rounded-full p-3 mr-4">
                                <i class="fas fa-clipboard-check text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">En Revisión</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $resumenOrdenes['en_revision'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-red-600">
                                {{ $resumenOrdenes['total'] > 0 ? number_format((($resumenOrdenes['en_revision'] ?? 0) / $resumenOrdenes['total']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Crecimiento mensual --}}
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Crecimiento mensual</p>
                    <p class="text-2xl font-bold text-green-600">+17.1%</p>
                    <p class="text-xs text-gray-500">vs mes anterior<br>23 órdenes más</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos Rápidos --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <i class="fas fa-rocket text-blue-500 text-xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-900">Accesos Rápidos de Administración</h2>
            </div>
            <span class="text-sm text-gray-500">Gestión del sistema</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Gestión de Técnicos --}}
            <a href="{{ route('tecnicos.index') }}" class="block stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-user-cog text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">NUEVO</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Gestión de Técnicos</h3>
                <p class="text-sm text-blue-100 mb-4">Crear, editar y administrar técnicos del sistema</p>
                <div class="flex items-center text-sm">
                    <span>Ver todos</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            {{-- Órdenes de Servicio --}}
            <a href="{{ route('ordenes.index') }}" class="block stat-card bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg p-6 text-white hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">23</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Órdenes de Servicio</h3>
                <p class="text-sm text-indigo-100 mb-4">Gestionar y supervisar órdenes activas</p>
                <div class="flex items-center text-sm">
                    <span>Administrar</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            {{-- Gestión de Clientes --}}
            <a href="{{ route('clientes.index') }}" class="block stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">NUEVO</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Gestión de Clientes</h3>
                <p class="text-sm text-green-100 mb-4">Crear, editar y administrar clientes del sistema</p>
                <div class="flex items-center text-sm">
                    <span>Ver todos</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            {{-- Reportes --}}
            <a href="#" class="block stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-chart-bar text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">STATS</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Reportes</h3>
                <p class="text-sm text-purple-100 mb-4">Estadísticas y análisis detallados</p>
                <div class="flex items-center text-sm">
                    <span>Ver reportes</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>
    </div>

    {{-- Productividad Semanal y Carga Laboral --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Productividad Semanal --}}
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center mb-6">
                <i class="fas fa-chart-line text-blue-500 text-xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-900">Productividad Semanal</h2>
            </div>
            <div style="height: 300px;">
                <canvas id="productividadChart"></canvas>
            </div>
        </div>

        {{-- Carga Laboral de Técnicos --}}
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <i class="fas fa-user-hard-hat text-blue-500 text-xl mr-3"></i>
                    <h2 class="text-xl font-bold text-gray-900">Carga Laboral de Técnicos</h2>
                </div>
                <span class="text-sm text-gray-500">4 técnicos activos</span>
            </div>

            <div class="space-y-4">
                {{-- Técnico 1 --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                        Ca
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <div>
                                <p class="font-semibold text-gray-900">Carlos Rodríguez</p>
                                <p class="text-xs text-gray-500">Computadoras</p>
                            </div>
                            <span class="text-sm font-bold text-gray-700">85%</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>8 asignadas</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                {{-- Técnico 2 --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                        Ma
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <div>
                                <p class="font-semibold text-gray-900">María González</p>
                                <p class="text-xs text-gray-500">Móviles</p>
                            </div>
                            <span class="text-sm font-bold text-gray-700">65%</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>6 asignadas</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full progress-bar" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                {{-- Técnico 3 --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                        Di
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <div>
                                <p class="font-semibold text-gray-900">Diego Sánchez</p>
                                <p class="text-xs text-gray-500">Soporte</p>
                            </div>
                            <span class="text-sm font-bold text-gray-700">95%</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>10 asignadas</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full progress-bar" style="width: 95%"></div>
                        </div>
                        <p class="text-xs text-red-600 mt-1 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Sobrecargado - Requiere redistribución
                        </p>
                    </div>
                </div>

                {{-- Técnico 4 --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                        An
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <div>
                                <p class="font-semibold text-gray-900">Ana Torres</p>
                                <p class="text-xs text-gray-500">Reparaciones</p>
                            </div>
                            <span class="text-sm font-bold text-gray-700">45%</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>4 asignadas</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full progress-bar" style="width: 45%"></div>
                        </div>
                        <p class="text-xs text-green-600 mt-1 flex items-center">
                            <i class="fas fa-check-circle mr-1"></i>
                            Disponible para nuevas asignaciones
                        </p>
                    </div>
                </div>

                {{-- Gráfico comparativo --}}
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Comparativa de Carga</p>
                    <div style="height: 150px;">
                        <canvas id="cargaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <i class="fas fa-bell text-yellow-500 text-xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-900">Alertas</h2>
            </div>
            <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">3</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            {{-- Retraso Crítico --}}
            <div class="alert-card alert-critical rounded-lg p-4">
                <div class="flex items-start">
                    <div class="bg-red-100 rounded-full p-2 mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 mb-1">Retraso Crítico</h3>
                        <p class="text-sm text-gray-700 mb-2">Orden TS-2025-089</p>
                        <p class="text-xs text-gray-600 mb-2">5 días de retraso</p>
                        <p class="text-xs text-gray-500">Técnico: Carlos Rodríguez</p>
                    </div>
                </div>
            </div>

            {{-- Sobrecarga --}}
            <div class="alert-card alert-warning rounded-lg p-4">
                <div class="flex items-start">
                    <div class="bg-yellow-100 rounded-full p-2 mr-3">
                        <i class="fas fa-user-clock text-yellow-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 mb-1">Sobrecarga</h3>
                        <p class="text-sm text-gray-700 mb-2">Diego Sánchez</p>
                        <p class="text-xs text-gray-600 mb-2">83% de carga</p>
                        <p class="text-xs text-gray-500">10 órdenes pendientes</p>
                    </div>
                </div>
            </div>

            {{-- Revisión Pendiente --}}
            <div class="alert-card alert-info rounded-lg p-4">
                <div class="flex items-start">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <i class="fas fa-clipboard-check text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 mb-1">Revisión Pendiente</h3>
                        <p class="text-sm text-gray-700 mb-2">Orden TS-2025-091</p>
                        <p class="text-xs text-gray-600 mb-2">2 días sin revisar</p>
                        <p class="text-xs text-gray-500">Cliente: TechCorp</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" class="block w-full bg-blue-500 text-white text-center py-3 rounded-lg hover:bg-blue-600 transition-colors">
            <i class="fas fa-eye mr-2"></i>
            Ver todas las alertas
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Donut - Distribución de Órdenes
    const ctxDonut = document.getElementById('ordenesChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: ['Completadas', 'En Progreso', 'Pendientes', 'En Revisión'],
            datasets: [{
                data: [
                    {{ $resumenOrdenes['completadas'] ?? 0 }},
                    {{ $resumenOrdenes['en_progreso'] ?? 0 }},
                    {{ $resumenOrdenes['pendientes'] ?? 0 }},
                    {{ $resumenOrdenes['en_revision'] ?? 0 }}
                ],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    // Gráfico de Productividad Semanal
    const ctxLine = document.getElementById('productividadChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Órdenes Completadas',
                data: [12, 15, 18, 18, 20, 8, 5],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Gráfico de Carga Laboral
    const ctxBar = document.getElementById('cargaChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Carlos R.', 'María G.', 'Diego S.', 'Ana T.'],
            datasets: [{
                label: 'Carga de Trabajo %',
                data: [85, 65, 95, 45],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444', '#10b981'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush

    <!-- Resumen Estadístico -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Órdenes Totales -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 mr-4">
                    <i class="fas fa-clipboard-list text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Órdenes Totales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['total'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-600">
                <i class="fas fa-chart-line mr-2 text-blue-500"></i>
                <span>Todas las órdenes registradas</span>
            </div>
        </div>

        <!-- Órdenes Pendientes -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 mr-4">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['pendientes'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-600">
                <i class="fas fa-hourglass-half mr-2 text-yellow-500"></i>
                <span>Esperando asignación</span>
            </div>
        </div>

        <!-- Órdenes en Progreso -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 mr-4">
                    <i class="fas fa-tools text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">En Progreso</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['en_progreso'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-600">
                <i class="fas fa-cog fa-spin mr-2 text-emerald-500"></i>
                <span>En proceso de reparación</span>
            </div>
        </div>

        <!-- Órdenes Completadas -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 mr-4">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Completadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['completadas'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-600">
                <i class="fas fa-trophy mr-2 text-purple-500"></i>
                <span>Servicios finalizados</span>
            </div>
        </div>
    </div>

    <!-- Sección de Técnicos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Estado de Técnicos</h2>
                <p class="text-sm text-gray-600 mt-1">Monitoreo de actividad y carga de trabajo</p>
            </div>
            <a href="{{ route('admin.gestion-tecnicos') }}" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors duration-200">
                <i class="fas fa-users-cog mr-2"></i>Gestionar Técnicos
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($tecnicos ?? [] as $tecnico)
            @if(is_array($tecnico))
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($tecnico['nombre'] ?? 'X', 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <h3 class="font-semibold text-gray-900">{{ $tecnico['nombre'] ?? 'Sin nombre' }}</h3>
                            <p class="text-sm text-gray-600">{{ $tecnico['especialidad'] ?? 'Sin especialidad' }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ 
                        isset($tecnico['estado']) ? 
                            ($tecnico['estado'] === 'activo' ? 'bg-green-100 text-green-700 border border-green-200' : 
                             ($tecnico['estado'] === 'ocupado' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : 
                              'bg-red-100 text-red-700 border border-red-200')) : 
                            'bg-gray-100 text-gray-700 border border-gray-200' 
                    }}">
                        {{ isset($tecnico['estado']) ? ucfirst($tecnico['estado']) : 'Desconocido' }}
                    </span>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Órdenes Asignadas</span>
                        <span class="font-medium text-gray-900">{{ $tecnico['ordenes_asignadas'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Completadas</span>
                        <span class="font-medium text-gray-900">{{ $tecnico['ordenes_completadas'] ?? 0 }}</span>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Carga de trabajo</span>
                            <span class="font-medium text-gray-900">{{ $tecnico['carga_trabajo'] ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all duration-500 {{ 
                                $tecnico['carga_trabajo'] >= 90 ? 'bg-red-500' :
                                ($tecnico['carga_trabajo'] >= 70 ? 'bg-yellow-500' : 'bg-green-500')
                            }}" style="width: {{ $tecnico['carga_trabajo'] ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('admin.gestion-tecnicos') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200" title="Ver detalles">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.tecnicos.edit', $tecnico['id'] ?? 0) }}" class="text-gray-600 hover:text-green-600 transition-colors duration-200" title="Editar técnico">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="text-gray-600 hover:text-red-600 transition-colors duration-200" title="Eliminar técnico">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @endif
            @empty
            <div class="col-span-3 bg-gray-50 rounded-xl p-8 text-center border border-gray-200">
                <i class="fas fa-user-hard-hat text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-600 mb-2">No hay técnicos registrados</p>
                <a href="{{ route('admin.tecnicos.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-700 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i>Agregar nuevo técnico
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Estadísticas de Clientes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Clientes</h2>
                    <p class="text-sm text-gray-600 mt-1">Resumen de crecimiento</p>
                </div>
                <button class="text-blue-600 hover:text-blue-700 transition-colors duration-200">
                    <i class="fas fa-download"></i>
                </button>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div>
                        <p class="text-sm text-gray-600">Total Clientes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticasClientes['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                    <div>
                        <p class="text-sm text-gray-600">Nuevos este mes</p>
                        <div class="flex items-center">
                            <p class="text-2xl font-bold text-green-600">+{{ $estadisticasClientes['nuevos_mes'] ?? 0 }}</p>
                            <span class="ml-2 text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i>12%
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-user-plus text-green-600 text-xl"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div>
                        <p class="text-sm text-gray-600">Nuevos esta semana</p>
                        <div class="flex items-center">
                            <p class="text-2xl font-bold text-blue-600">+{{ $estadisticasClientes['nuevos_semana'] ?? 0 }}</p>
                            <span class="ml-2 text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i>8%
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Clientes por Mes</h2>
                    <p class="text-sm text-gray-600 mt-1">Tendencia de crecimiento mensual</p>
                </div>
                <div class="flex space-x-2">
                    <button class="text-xs px-3 py-1 rounded-lg bg-blue-50 text-blue-600 font-medium hover:bg-blue-100 transition-colors duration-200">
                        Mes
                    </button>
                    <button class="text-xs px-3 py-1 rounded-lg bg-gray-100 text-gray-600 font-medium hover:bg-gray-200 transition-colors duration-200">
                        Año
                    </button>
                </div>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="clientesChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('clientesChart').getContext('2d');
    const clientesPorMes = @json($clientesPorMes ?? []);

    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: clientesPorMes.map(item => item.mes),
            datasets: [{
                label: 'Clientes Nuevos',
                data: clientesPorMes.map(item => item.cantidad),
                borderColor: '#3b82f6',
                borderWidth: 2,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#3b82f6',
                pointHoverBorderColor: '#ffffff',
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
                    backgroundColor: '#1e293b',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} clientes nuevos`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        color: '#64748b'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        padding: 10,
                        color: '#64748b'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endpush