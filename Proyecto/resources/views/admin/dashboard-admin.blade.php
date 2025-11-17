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
                <p class="text-sm text-gray-500 mt-2">Última actualización: <span id="last-update">{{ now()->format('d/m/Y H:i') }}</span></p>
            </div>
            <button onclick="location.reload()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-sync-alt mr-2"></i>
                Actualizar
            </button>
        </div>
    </div>

    {{-- Métricas en Tiempo Real --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Órdenes --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-3xl font-bold mb-1" id="metric-total">{{ $resumenOrdenes['total'] ?? 0 }}</p>
            <p class="text-sm text-blue-100">Órdenes de Servicio</p>
        </div>

        {{-- Órdenes Pendientes --}}
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">Activas</span>
            </div>
            <p class="text-3xl font-bold mb-1" id="metric-pendientes">{{ $resumenOrdenes['pendientes'] ?? 0 }}</p>
            <p class="text-sm text-yellow-100">Pendientes</p>
        </div>

        {{-- Órdenes en Progreso --}}
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-tools text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">En Curso</span>
            </div>
            <p class="text-3xl font-bold mb-1" id="metric-progreso">{{ $resumenOrdenes['en_progreso'] ?? 0 }}</p>
            <p class="text-sm text-indigo-100">En Progreso</p>
        </div>

        {{-- Órdenes Completadas --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">Este Mes</span>
            </div>
            <p class="text-3xl font-bold mb-1" id="metric-completadas">{{ $metricas['ordenes_mes_actual'] ?? 0 }}</p>
            <p class="text-sm text-green-100">Completadas</p>
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

                {{-- Crecimiento mensual --}}
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Crecimiento mensual</p>
                    <p class="text-2xl font-bold {{ $metricas['crecimiento'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $metricas['crecimiento'] >= 0 ? '+' : '' }}{{ number_format($metricas['crecimiento'], 1) }}%
                    </p>
                    <p class="text-xs text-gray-500">
                        vs mes anterior<br>
                        {{ abs($metricas['ordenes_mes_actual'] - $metricas['ordenes_mes_anterior']) }} órdenes 
                        {{ $metricas['crecimiento'] >= 0 ? 'más' : 'menos' }}
                    </p>
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
            <a href="{{ route('admin.gestion-tecnicos') }}" class="block stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white hover:shadow-xl">
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
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">{{ $resumenOrdenes['total'] }}</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Órdenes de Servicio</h3>
                <p class="text-sm text-indigo-100 mb-4">Gestionar y supervisar órdenes activas</p>
                <div class="flex items-center text-sm">
                    <span>Administrar</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            {{-- Historial de Órdenes --}}
            <a href="{{ route('admin.ordenes.historicas') }}" class="block stat-card bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg p-6 text-white hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-history text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">HISTÓRICO</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Historial de Órdenes</h3>
                <p class="text-sm text-teal-100 mb-4">Registro detallado con precios y respaldos</p>
                <div class="flex items-center text-sm">
                    <span>Ver historial</span>
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

        </div>

        <div class="mt-4">
            {{-- Configuración del Servicio Técnico --}}
            <a href="{{ route('configuracion.index') }}" class="block stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-cog text-2xl"></i>
                    </div>
                    <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full">CONFIG</span>
                </div>
                <h3 class="text-lg font-bold mb-2">Configuración</h3>
                <p class="text-sm text-purple-100 mb-4">Configuración de mi servicio técnico</p>
                <div class="flex items-center text-sm">
                    <span>Configurar</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>
    </div>

    {{-- Ingresos y Comisiones --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Ingreso Semanal --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-calendar-week text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">Esta Semana</span>
            </div>
            <p class="text-3xl font-bold mb-1">${{ number_format($ingresoSemanal ?? 0, 0, ',', '.') }}</p>
            <p class="text-sm text-emerald-100">Ingreso Semanal</p>
            <p class="text-xs text-emerald-200 mt-2">
                <i class="fas fa-calendar mr-1"></i>
                {{ now()->startOfWeek()->format('d/m') }} - {{ now()->endOfWeek()->format('d/m/Y') }}
            </p>
        </div>

        {{-- Ingreso Mensual --}}
        <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">Este Mes</span>
            </div>
            <p class="text-3xl font-bold mb-1">${{ number_format($ingresoMensual ?? 0, 0, ',', '.') }}</p>
            <p class="text-sm text-violet-100">Ingreso Mensual</p>
            <p class="text-xs text-violet-200 mt-2">
                <i class="fas fa-calendar mr-1"></i>
                {{ now()->format('F Y') }}
            </p>
        </div>

        {{-- Comisiones Totales --}}
        @php
            $comisionesTotales = array_sum(array_column($tecnicos, 'comision_total'));
        @endphp
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
                <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full">Este Mes</span>
            </div>
            <p class="text-3xl font-bold mb-1">${{ number_format($comisionesTotales, 0, ',', '.') }}</p>
            <p class="text-sm text-amber-100">Comisiones Totales</p>
            <p class="text-xs text-amber-200 mt-2">
                <i class="fas fa-users mr-1"></i>
                {{ count($tecnicos) }} técnico(s)
            </p>
        </div>
    </div>

    {{-- Productividad Semanal y Carga Laboral --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Productividad Semanal --}}
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-blue-500 text-xl mr-3"></i>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Órdenes Creadas por Día</h2>
                        <p class="text-xs text-gray-500">
                            {{ now()->startOfWeek()->format('d/m') }} - {{ now()->endOfWeek()->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-blue-600">{{ array_sum($productividadSemanal) }}</p>
                    <p class="text-xs text-gray-500">Órdenes creadas esta semana</p>
                </div>
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
                <span class="text-sm text-gray-500">{{ count($tecnicos) }} técnicos activos</span>
            </div>

            <div class="space-y-4">
                @forelse($tecnicos as $tecnico)
                {{-- Técnico --}}
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-3
                        {{ $tecnico['carga_trabajo'] >= 90 ? 'bg-red-500' : ($tecnico['carga_trabajo'] >= 70 ? 'bg-yellow-500' : 'bg-green-500') }}">
                        {{ strtoupper(substr($tecnico['nombre'], 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $tecnico['nombre'] }}</p>
                                <p class="text-xs text-gray-500">{{ $tecnico['especialidad'] }}</p>
                            </div>
                            <span class="text-sm font-bold text-gray-700">{{ $tecnico['carga_trabajo'] }}%</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>{{ $tecnico['ordenes_asignadas'] }} asignadas • {{ $tecnico['ordenes_completadas'] }} completadas</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">
                                    {{ $tecnico['comision_por_orden'] ?? 0 }}%
                                </span>
                                <span class="font-semibold text-green-600">
                                    ${{ number_format($tecnico['comision_total'] ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full progress-bar
                                {{ $tecnico['carga_trabajo'] >= 90 ? 'bg-red-500' : ($tecnico['carga_trabajo'] >= 70 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                style="width: {{ $tecnico['carga_trabajo'] }}%"></div>
                        </div>
                        @if($tecnico['estado'] === 'sobrecargado')
                        <p class="text-xs text-red-600 mt-1 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Sobrecargado - Requiere redistribución
                        </p>
                        @elseif($tecnico['estado'] === 'disponible')
                        <p class="text-xs text-green-600 mt-1 flex items-center">
                            <i class="fas fa-check-circle mr-1"></i>
                            Disponible para nuevas asignaciones
                        </p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-user-slash text-4xl mb-2"></i>
                    <p>No hay técnicos registrados</p>
                </div>
                @endforelse

                {{-- Gráfico comparativo --}}
                @if(count($tecnicos) > 0)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Comparativa de Carga</p>
                    <div style="height: 150px;">
                        <canvas id="cargaChart"></canvas>
                    </div>
                </div>
                @endif
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
            <span class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">{{ count($alertas) }}</span>
        </div>

        @if(count($alertas) > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            @foreach($alertas as $alerta)
                @if($alerta['tipo'] === 'retraso_critico')
                {{-- Retraso Crítico --}}
                <div class="alert-card alert-critical rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="bg-red-100 rounded-full p-2 mr-3">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-1">Retraso Crítico</h3>
                            <p class="text-sm text-gray-700 mb-2">Orden {{ $alerta['orden'] }}</p>
                            <p class="text-xs text-gray-600 mb-2">{{ $alerta['dias_retraso'] }} días de retraso</p>
                            <p class="text-xs text-gray-500">Técnico: {{ $alerta['tecnico'] }}</p>
                        </div>
                    </div>
                </div>
                @elseif($alerta['tipo'] === 'sobrecarga_tecnico')
                {{-- Sobrecarga --}}
                <div class="alert-card alert-warning rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="bg-yellow-100 rounded-full p-2 mr-3">
                            <i class="fas fa-user-clock text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-1">Sobrecarga</h3>
                            <p class="text-sm text-gray-700 mb-2">{{ $alerta['tecnico'] }}</p>
                            <p class="text-xs text-gray-600 mb-2">{{ $alerta['carga'] }}% de carga</p>
                            <p class="text-xs text-gray-500">{{ $alerta['ordenes_pendientes'] }} órdenes pendientes</p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-check-circle text-4xl mb-2 text-green-500"></i>
            <p class="font-semibold">¡Todo en orden!</p>
            <p class="text-sm">No hay alertas en este momento</p>
        </div>
        @endif
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
            labels: ['Completadas', 'En Progreso', 'Pendientes'],
            datasets: [{
                data: [
                    {{ $resumenOrdenes['completadas'] ?? 0 }},
                    {{ $resumenOrdenes['en_progreso'] ?? 0 }},
                    {{ $resumenOrdenes['pendientes'] ?? 0 }}
                ],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
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
                label: 'Órdenes Creadas',
                data: [
                    @foreach($productividadSemanal as $ordenes)
                        {{ $ordenes }},
                    @endforeach
                ],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            return 'Órdenes: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 12 }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: { font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });

    // Gráfico de Carga Laboral
    @if(count($tecnicos) > 0)
    const ctxBar = document.getElementById('cargaChart').getContext('2d');
    window.cargaTecnicosChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: [
                @foreach($tecnicos as $tecnico)
                    '{{ explode(" ", $tecnico["nombre"])[0] ?? "" }}',
                @endforeach
            ],
            datasets: [{
                label: 'Órdenes Asignadas',
                data: [
                    @foreach($tecnicos as $tecnico)
                        {{ $tecnico['ordenes_asignadas'] }},
                    @endforeach
                ],
                backgroundColor: [
                    @foreach($tecnicos as $tecnico)
                        '{{ $tecnico["ordenes_asignadas"] >= 9 ? "#ef4444" : ($tecnico["ordenes_asignadas"] >= 7 ? "#f59e0b" : "#10b981") }}',
                    @endforeach
                ],
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
                    max: 10,
                    ticks: {
                        stepSize: 2
                    },
                    title: {
                        display: true,
                        text: 'Órdenes Asignadas',
                        font: {
                            size: 12
                        }
                    },
                    grid: { 
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' órdenes asignadas';
                        }
                    }
                }
            }
        }
    });
    @endif
});
</script>

<script>
// Función para actualizar el dashboard
function refreshDashboard() {
    const icon = document.getElementById('refresh-icon');
    icon.classList.add('fa-spin');
    
    fetch('{{ route("dashboard.metrics") }}')
        .then(response => response.json())
        .then(data => {
            // Actualizar métricas de órdenes
            document.getElementById('metric-total').textContent = data.resumenOrdenes.total;
            document.getElementById('metric-pendientes').textContent = data.resumenOrdenes.pendientes;
            document.getElementById('metric-progreso').textContent = data.resumenOrdenes.en_progreso;
            document.getElementById('metric-completadas').textContent = data.resumenOrdenes.completadas;
            
            // Actualizar ingresos si existen
            if (data.ingresoSemanal !== undefined) {
                const ingresoSemanalEl = document.querySelector('.text-emerald-100').previousElementSibling;
                if (ingresoSemanalEl) {
                    ingresoSemanalEl.textContent = '$' + new Intl.NumberFormat('es-CL').format(data.ingresoSemanal);
                }
            }
            if (data.ingresoMensual !== undefined) {
                const ingresoMensualEl = document.querySelector('.text-violet-100').previousElementSibling;
                if (ingresoMensualEl) {
                    ingresoMensualEl.textContent = '$' + new Intl.NumberFormat('es-CL').format(data.ingresoMensual);
                }
            }
            if (data.comisionesTotales !== undefined) {
                const comisionesEl = document.querySelector('.text-amber-100').previousElementSibling;
                if (comisionesEl) {
                    comisionesEl.textContent = '$' + new Intl.NumberFormat('es-CL').format(data.comisionesTotales);
                }
            }
            
            // Actualizar gráfico de carga laboral de técnicos si existe
            if (window.cargaTecnicosChart && data.tecnicos) {
                const labels = data.tecnicos.map(t => t.nombre.split(' ')[0]);
                const cargaData = data.tecnicos.map(t => t.carga_trabajo);
                const colores = data.tecnicos.map(t => 
                    t.carga_trabajo >= 90 ? '#ef4444' : 
                    (t.carga_trabajo >= 70 ? '#f59e0b' : '#10b981')
                );
                
                window.cargaTecnicosChart.data.labels = labels;
                window.cargaTecnicosChart.data.datasets[0].data = cargaData;
                window.cargaTecnicosChart.data.datasets[0].backgroundColor = colores;
                window.cargaTecnicosChart.update();
            }
            
            // Actualizar timestamp
            const now = new Date();
            document.getElementById('last-update').textContent = 
                now.toLocaleDateString('es-CL') + ' ' + now.toLocaleTimeString('es-CL');
            
            // Detener animación
            setTimeout(() => {
                icon.classList.remove('fa-spin');
            }, 500);
        })
        .catch(error => {
            console.error('Error al actualizar:', error);
            icon.classList.remove('fa-spin');
        });
}

// Actualización automática cada 30 segundos
setInterval(refreshDashboard, 30000);
</script>
@endpush