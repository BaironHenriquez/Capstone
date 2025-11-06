@extends('shared.layouts.admin')

@section('title', 'Dashboard Técnico')
@section('breadcrumb', 'Panel del Técnico')

@push('styles')
<style>
    .dashboard-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }

    .orden-card {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-left: 4px solid transparent;
        transition: all 0.2s;
    }

    .orden-card:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .orden-card.pendiente { border-left-color: #f59e0b; }
    .orden-card.en-progreso { border-left-color: #3b82f6; }
    .orden-card.completada { border-left-color: #10b981; }
</style>
@endpush

@section('content')
<!-- Header del Dashboard -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Técnico</h1>
        <p class="text-gray-600">Bienvenido, {{ $user->name ?? 'Técnico' }}</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <button onclick="location.reload()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
            <i class="fas fa-sync-alt mr-2"></i>Actualizar
        </button>
        <a href="{{ route('ordenes.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
            <i class="fas fa-clipboard-list mr-2"></i>Ver Órdenes
        </a>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Órdenes Asignadas -->
    <div class="stat-card">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Asignadas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_asignadas'] }}</p>
                <p class="text-xs text-blue-600">{{ $stats['nuevas_hoy'] }} nuevas hoy</p>
            </div>
        </div>
    </div>

    <!-- Órdenes en Progreso -->
    <div class="stat-card">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-tools text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">En Progreso</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['en_progreso'] }}</p>
                <p class="text-xs text-yellow-600">{{ $stats['urgentes'] }} urgentes</p>
            </div>
        </div>
    </div>

    <!-- Órdenes Completadas -->
    <div class="stat-card">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Completadas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['completadas'] }}</p>
                <p class="text-xs text-green-600">{{ $stats['completadas_semana'] }} esta semana</p>
            </div>
        </div>
    </div>

    <!-- Carga Laboral -->
    <div class="stat-card">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-chart-line text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Carga Laboral</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['carga_laboral'] }}%</p>
                <p class="text-xs text-purple-600">
                    @if($stats['carga_laboral'] < 50)
                        Baja
                    @elseif($stats['carga_laboral'] < 80)
                        Óptima
                    @else
                        Alta
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Grid Principal -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Mis Órdenes Activas -->
    <div class="lg:col-span-2 dashboard-card p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Mis Órdenes Activas</h2>
                <p class="text-sm text-gray-600 mt-1">Últimas órdenes asignadas a ti</p>
            </div>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">{{ $stats['total_asignadas'] }} Total</span>
        </div>

        <div class="space-y-4">
            @forelse($ordenesActivas as $orden)
            <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-200 hover:border-blue-300">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-lg font-bold text-gray-900">{{ $orden->numero_orden }}</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $orden->estado == 'en_proceso' || $orden->estado == 'en_progreso' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $orden->estado == 'pendiente' || $orden->estado == 'asignada' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $orden->estado == 'en_revision' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $orden->estado == 'completado' || $orden->estado == 'completada' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($orden->descripcion_problema ?? 'Mantenimiento periódico', 60) }}</p>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="far fa-user w-4 mr-2 text-gray-400"></i>
                                <span>{{ $orden->cliente->nombre ?? 'Sin cliente' }} {{ $orden->cliente->apellido ?? '' }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="far fa-calendar w-4 mr-2 text-gray-400"></i>
                                <span>{{ $orden->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center font-medium
                                {{ $orden->prioridad == 'alta' ? 'text-red-600' : '' }}
                                {{ $orden->prioridad == 'media' ? 'text-yellow-600' : '' }}
                                {{ $orden->prioridad == 'baja' ? 'text-green-600' : '' }}">
                                <i class="fas fa-flag w-4 mr-2"></i>
                                <span>{{ ucfirst($orden->prioridad ?? 'Media') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('ordenes.show', $orden->id) }}" 
                       class="ml-4 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                        Ver <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium">No tienes órdenes activas asignadas</p>
                <p class="text-gray-400 text-sm mt-2">Las nuevas órdenes aparecerán aquí</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('ordenes.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                Ver todas las órdenes <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Columna Derecha -->
    <div class="space-y-6">
        <!-- Gráfico de Distribución -->
        <div class="dashboard-card p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Distribución de Órdenes</h3>
            <div class="flex justify-center">
                <canvas id="ordenesChart" style="max-height: 250px;"></canvas>
            </div>
        </div>

        <!-- Progreso Semanal -->
        <div class="dashboard-card p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Progreso Semanal</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Completadas</span>
                        <span class="font-semibold text-gray-900">{{ $stats['completadas_semana'] }}/{{ $totalSemana }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progresoSemana }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">En Progreso</span>
                        <span class="font-semibold text-gray-900">{{ $stats['en_progreso'] }}/{{ $stats['total_asignadas'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $porcentajeProgreso = $stats['total_asignadas'] > 0 ? round(($stats['en_progreso'] / $stats['total_asignadas']) * 100) : 0;
                        @endphp
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $porcentajeProgreso }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="dashboard-card p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Estadísticas</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Tiempo Promedio</span>
                    <span class="font-semibold text-gray-900">2.5 días</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Satisfacción</span>
                    <span class="font-semibold text-green-600">98%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Calificación</span>
                    <span class="font-semibold text-yellow-600">
                        <i class="fas fa-star"></i> 4.8/5
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de distribución de órdenes con datos reales
const ctx = document.getElementById('ordenesChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pendientes', 'En Progreso', 'Completadas'],
        datasets: [{
            data: [{{ $stats['pendientes'] }}, {{ $stats['en_progreso'] }}, {{ $stats['completadas'] }}],
            backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: { size: 12 }
                }
            }
        }
    }
});
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
