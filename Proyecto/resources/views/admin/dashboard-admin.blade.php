@extends('shared.layouts.admin')

@section('title', 'Dashboard Administrativo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header del Dashboard -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel de Control</h1>
        <p class="text-gray-600">Bienvenido al panel administrativo de Baieco</p>
    </div>

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