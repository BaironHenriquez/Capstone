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
    {{-- Header Simplificado --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col gap-6">
            {{-- Título --}}
            <div class="flex items-start gap-4">
                <div class="bg-gray-100 rounded-xl p-3">
                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Panel de Control Técnico</h1>
                    <p class="text-gray-600">Resumen general del estado del servicio técnico</p>
                    <p class="text-xs text-gray-500 mt-2">Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            {{-- Filtros Centrados --}}
            <div class="flex flex-col items-center gap-4 w-full">
                {{-- Selectores de Fecha - Responsivos --}}
                <div class="w-full max-w-6xl bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-center gap-3">
                        {{-- Mes --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <i class="fas fa-calendar-alt text-gray-600 hidden sm:block"></i>
                            <select id="filtro-mes" onchange="actualizarRangoSemana()" class="w-full sm:w-auto bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer shadow-sm">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == ($mes ?? now()->month) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        
                        {{-- Año --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <select id="filtro-anio" onchange="actualizarRangoSemana()" class="w-full sm:w-auto bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer shadow-sm">
                                @for($y = now()->year; $y >= now()->year - 5; $y--)
                                    <option value="{{ $y }}" {{ $y == ($anio ?? now()->year) ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        {{-- Semana --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <i class="fas fa-calendar-week text-gray-600 hidden sm:block"></i>
                            <select id="filtro-semana" class="w-full sm:w-auto bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer shadow-sm">
                                <option value="0" {{ ($semana ?? 0) == 0 ? 'selected' : '' }}>Todo el mes</option>
                                <option value="1" {{ ($semana ?? 0) == 1 ? 'selected' : '' }}>Semana 1</option>
                                <option value="2" {{ ($semana ?? 0) == 2 ? 'selected' : '' }}>Semana 2</option>
                                <option value="3" {{ ($semana ?? 0) == 3 ? 'selected' : '' }}>Semana 3</option>
                                <option value="4" {{ ($semana ?? 0) == 4 ? 'selected' : '' }}>Semana 4</option>
                                <option value="5" {{ ($semana ?? 0) == 5 ? 'selected' : '' }}>Semana 5</option>
                            </select>
                        </div>
                        
                        {{-- Botones --}}
                        <div class="flex gap-2 flex-shrink-0">
                            <button onclick="filtrarDashboard()" class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2.5 rounded-lg font-semibold flex items-center justify-center gap-2 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-filter"></i>
                                <span class="hidden sm:inline">Filtrar</span>
                            </button>
                            
                            <button onclick="location.reload()" class="flex-1 sm:flex-none bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-lg font-medium flex items-center justify-center gap-2 transition-all border-2 border-gray-300 hover:border-gray-400 shadow-sm">
                                <i class="fas fa-sync-alt"></i>
                                <span class="hidden sm:inline">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Indicador de rango seleccionado --}}
                <div id="rango-semana" class="bg-blue-50 px-4 py-2.5 rounded-lg border-2 border-blue-200 flex items-center gap-2 max-w-full">
                    <i class="fas fa-info-circle text-blue-600 flex-shrink-0"></i>
                    <span id="texto-rango" class="text-sm font-semibold text-blue-700 text-center break-words">{{ $rangoSemana ?? 'Todo el mes seleccionado' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid para Empleado del Mes y otras métricas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- 🏆 Empleado del Mes --}}
        @if($empleadoDelMes)
        <div class="lg:col-span-2 relative bg-gradient-to-br from-yellow-400 via-amber-500 to-orange-600 rounded-2xl shadow-2xl overflow-hidden">
        {{-- Patrón de fondo decorativo --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 transform translate-x-16 -translate-y-16">
                <svg fill="currentColor" viewBox="0 0 20 20" class="text-white">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div class="absolute bottom-0 left-0 w-48 h-48 transform -translate-x-12 translate-y-12">
                <svg fill="currentColor" viewBox="0 0 20 20" class="text-white">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>

        <div class="relative z-10 p-6">
            {{-- Header con Trofeo y Calificación --}}
            {{-- Mostrar período filtrado --}}
            <div class="mb-2 text-xs text-white/90 bg-black/20 px-3 py-1 rounded-lg inline-block font-semibold">
                📅 Período: {{ $rangoSemana ?? 'Todo el mes' }}
            </div>
            
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-yellow-300 rounded-2xl blur-xl opacity-50 animate-pulse"></div>
                        <div class="relative bg-gradient-to-br from-yellow-200 to-yellow-300 rounded-2xl p-4 shadow-2xl">
                            <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="inline-flex items-center bg-white bg-opacity-25 backdrop-blur-sm rounded-full px-3 py-1 mb-2">
                            <span class="text-xs font-bold text-white uppercase tracking-wider">
                                {{ \Carbon\Carbon::create($anio ?? now()->year, $mes ?? now()->month)->translatedFormat('F Y') }}
                            </span>
                        </div>
                        <h2 class="text-2xl font-black text-white tracking-tight drop-shadow-lg">
                            Empleado del Mes
                        </h2>
                    </div>
                </div>

                {{-- Tarjeta de Calificación Mejorada --}}
                <div class="bg-white rounded-2xl shadow-2xl p-5 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-center space-x-1 mb-2">
                        @php
                            $calificacion = $empleadoDelMes['calificacion'];
                            $calificacionEntera = floor($calificacion);
                            $tieneMedia = ($calificacion - $calificacionEntera) >= 0.5;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $calificacionEntera)
                                <svg class="w-6 h-6 text-yellow-400 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @elseif($i == $calificacionEntera + 1 && $tieneMedia)
                                <div class="relative w-6 h-6">
                                    <svg class="absolute inset-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <svg class="absolute inset-0 text-yellow-400 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20" style="clip-path: inset(0 50% 0 0);">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            @else
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-black bg-gradient-to-r from-yellow-500 to-orange-500 bg-clip-text text-transparent mb-1">
                            {{ number_format($empleadoDelMes['calificacion'], 1) }}<span class="text-xl text-gray-400">/5</span>
                        </p>
                        <p class="text-xs font-semibold text-gray-600">
                            {{ $empleadoDelMes['total_calificaciones'] }} {{ $empleadoDelMes['total_calificaciones'] == 1 ? 'calificación' : 'calificaciones' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Contenido Principal --}}
            <div class="bg-gradient-to-br from-white/20 to-white/10 backdrop-blur-xl rounded-xl p-5 border border-white/30 shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-white/70 uppercase tracking-wider mb-1">Técnico Destacado</p>
                        <h3 class="text-2xl font-black text-white drop-shadow-lg mb-2">{{ $empleadoDelMes['nombre'] }}</h3>
                        <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-3 py-1.5">
                            <svg class="w-4 h-4 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-bold text-white">{{ $empleadoDelMes['especialidad'] }}</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.tecnicos.resumen', $empleadoDelMes['id']) }}" 
                       class="group bg-white hover:bg-yellow-50 text-orange-600 font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span>Ver Perfil</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                {{-- Estadísticas --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-green-400/30 to-emerald-500/30 backdrop-blur-sm rounded-xl p-4 border border-white/20 hover:border-white/40 transition-all duration-300 hover:shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-white/80 uppercase tracking-wider mb-1">Órdenes</p>
                                <p class="text-3xl font-black text-white drop-shadow-lg">{{ $empleadoDelMes['ordenes_completadas'] }}</p>
                                <p class="text-xs text-white/70 mt-1">Completadas</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-400/30 to-amber-500/30 backdrop-blur-sm rounded-xl p-4 border border-white/20 hover:border-white/40 transition-all duration-300 hover:shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-white/80 uppercase tracking-wider mb-1">Desempeño</p>
                                <p class="text-3xl font-black text-white drop-shadow-lg">{{ \Carbon\Carbon::create($anio ?? now()->year, $mes ?? now()->month)->translatedFormat('M') }}</p>
                                <p class="text-xs text-white/70 mt-1">{{ $semana > 0 ? 'Semana ' . $semana : 'Mes Completo' }}</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @else
        {{-- Mensaje cuando no hay empleado del mes --}}
        <div class="lg:col-span-2 relative bg-gradient-to-br from-gray-400 via-gray-500 to-gray-600 rounded-2xl shadow-2xl overflow-hidden">
            <div class="relative z-10 p-6">
                <div class="mb-2 text-xs text-white/90 bg-black/20 px-3 py-1 rounded-lg inline-block font-semibold">
                    📅 Período: {{ $rangoSemana ?? 'Todo el mes' }}
                </div>
                
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-6 mb-4">
                        <svg class="w-16 h-16 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Sin Empleado del Mes</h3>
                    <p class="text-white/80 text-sm max-w-md">
                        No hay órdenes completadas en el período seleccionado. 
                        Selecciona otro mes o semana para ver los resultados.
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- Espacio para widget adicional (opcional) --}}
        <div class="hidden lg:block">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 h-full">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-lg p-3 mr-3">
                        <i class="fas fa-chart-line text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Rendimiento</h3>
                        <p class="text-sm text-gray-600">Este Mes</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4">
                        <p class="text-xs font-semibold text-gray-600 mb-1">Órdenes Procesadas</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $resumenOrdenes['total'] ?? 0 }}</p>
                    </div>
                    
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4">
                        <p class="text-xs font-semibold text-gray-600 mb-1">Tasa de Éxito</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $resumenOrdenes['total'] > 0 ? number_format(($resumenOrdenes['completadas'] / $resumenOrdenes['total']) * 100, 0) : 0 }}%
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-4">
                        <p class="text-xs font-semibold text-gray-600 mb-1">Técnicos Activos</p>
                        <p class="text-2xl font-bold text-purple-600">{{ count($tecnicos) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ingresos y Comisiones --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                {{ \Carbon\Carbon::create($anio ?? now()->year, $mes ?? now()->month)->translatedFormat('F Y') }}
            </p>
        </div>

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
                {{ $rangoSemanalTexto ?? (now()->startOfWeek()->format('d/m') . ' - ' . now()->endOfWeek()->format('d/m/Y')) }}
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

    {{-- Métricas en Tiempo Real --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Órdenes --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gray-100 rounded-lg p-3">
                    <i class="fas fa-clipboard-list text-gray-700 text-xl"></i>
                </div>
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1" id="metric-total">{{ $resumenOrdenes['total'] ?? 0 }}</p>
            <p class="text-sm text-gray-600">Órdenes de Servicio</p>
        </div>

        {{-- Órdenes Pendientes --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-amber-50 rounded-lg p-3">
                    <i class="fas fa-clock text-amber-600 text-xl"></i>
                </div>
                <span class="text-xs bg-amber-50 text-amber-600 px-2 py-1 rounded-full font-medium">Activas</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1" id="metric-pendientes">{{ $resumenOrdenes['pendientes'] ?? 0 }}</p>
            <p class="text-sm text-gray-600">Pendientes</p>
        </div>

        {{-- Órdenes en Progreso --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-blue-50 rounded-lg p-3">
                    <i class="fas fa-tools text-blue-600 text-xl"></i>
                </div>
                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full font-medium">En Curso</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1" id="metric-progreso">{{ $resumenOrdenes['en_progreso'] ?? 0 }}</p>
            <p class="text-sm text-gray-600">En Progreso</p>
        </div>

        {{-- Órdenes Completadas --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-green-50 rounded-lg p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded-full font-medium">Este Mes</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1" id="metric-completadas">{{ $metricas['ordenes_mes_actual'] ?? 0 }}</p>
            <p class="text-sm text-gray-600">Completadas</p>
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
                <div class="bg-white rounded-lg p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-green-50 rounded-lg p-3">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Completadas</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $resumenOrdenes['completadas'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $resumenOrdenes['total'] > 0 ? number_format(($resumenOrdenes['completadas'] / $resumenOrdenes['total']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                {{-- En Progreso --}}
                <div class="bg-white rounded-lg p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-50 rounded-lg p-3">
                                <i class="fas fa-tools text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">En Progreso</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $resumenOrdenes['en_progreso'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $resumenOrdenes['total'] > 0 ? number_format(($resumenOrdenes['en_progreso'] / $resumenOrdenes['total']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Pendientes --}}
                <div class="bg-white rounded-lg p-5 border border-gray-200 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-amber-50 rounded-lg p-3">
                                <i class="fas fa-clock text-amber-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pendientes</p>
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
                <div class="bg-white rounded-lg p-5 border border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-gray-100 rounded-lg p-2">
                            <i class="fas fa-chart-line text-gray-700 text-lg"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Crecimiento mensual</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">
                        {{ $metricas['crecimiento'] >= 0 ? '+' : '' }}{{ number_format($metricas['crecimiento'], 1) }}%
                    </p>
                    <p class="text-xs text-gray-500">
                        vs mes anterior • {{ abs($metricas['ordenes_mes_actual'] - $metricas['ordenes_mes_anterior']) }} órdenes 
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
                            {{ $fechaInicioGrafico ?? now()->startOfWeek()->format('d/m') }} - {{ $fechaFinGrafico ?? now()->endOfWeek()->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-blue-600">{{ array_sum($productividadSemanal) }}</p>
                    <p class="text-xs text-gray-500">Órdenes creadas en este período</p>
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
// Función para filtrar el dashboard por mes y año
function filtrarDashboard() {
    const mes = document.getElementById('filtro-mes').value;
    const anio = document.getElementById('filtro-anio').value;
    const semana = document.getElementById('filtro-semana').value;
    
    // Mostrar indicador de carga
    const btnFiltrar = event.target;
    const textoOriginal = btnFiltrar.innerHTML;
    btnFiltrar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Cargando...';
    btnFiltrar.disabled = true;
    
    // Agregar timestamp para evitar caché del navegador
    const timestamp = new Date().getTime();
    
    // Redirigir con parámetros de fecha
    window.location.href = `{{ route('dashboard') }}?mes=${mes}&anio=${anio}&semana=${semana}&_t=${timestamp}`;
}

function actualizarRangoSemana() {
    const mes = parseInt(document.getElementById('filtro-mes').value);
    const anio = parseInt(document.getElementById('filtro-anio').value);
    const semana = parseInt(document.getElementById('filtro-semana').value);
    const textoRango = document.getElementById('texto-rango');
    
    if (semana === 0) {
        const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                             'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        textoRango.textContent = `Todo el mes: ${nombresMeses[mes - 1]} ${anio}`;
        return;
    }
    
    // Calcular el rango de la semana
    const inicioMes = new Date(anio, mes - 1, 1);
    const diasDesplazamiento = (semana - 1) * 7;
    const inicioSemana = new Date(inicioMes);
    inicioSemana.setDate(inicioMes.getDate() + diasDesplazamiento);
    
    const finSemana = new Date(inicioSemana);
    finSemana.setDate(inicioSemana.getDate() + 6);
    
    // Ajustar si excede el mes
    const ultimoDiaMes = new Date(anio, mes, 0).getDate();
    if (finSemana.getDate() > ultimoDiaMes || finSemana.getMonth() !== mes - 1) {
        finSemana.setDate(ultimoDiaMes);
        finSemana.setMonth(mes - 1);
    }
    
    const formatoFecha = (fecha) => {
        const dia = String(fecha.getDate()).padStart(2, '0');
        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
        const anio = fecha.getFullYear();
        return `${dia}/${mes}/${anio}`;
    };
    
    textoRango.textContent = `${formatoFecha(inicioSemana)} - ${formatoFecha(finSemana)}`;
}

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
            labels: [
                @foreach($etiquetasDias as $etiqueta)
                    '{{ $etiqueta }}',
                @endforeach
            ],
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