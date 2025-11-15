<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Orden {{ $orden->numero_orden }} - Baieco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { 
                opacity: 1;
            }
            50% { 
                opacity: 0.8;
            }
        }
        
        .info-card {
            animation: fade-in 0.5s ease-out;
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.15);
        }

        .status-badge {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Animaciones de entrada escalonadas */
        .info-card:nth-child(1) { animation-delay: 0.05s; }
        .info-card:nth-child(2) { animation-delay: 0.1s; }
        .info-card:nth-child(3) { animation-delay: 0.15s; }
        .info-card:nth-child(4) { animation-delay: 0.2s; }
        .info-card:nth-child(5) { animation-delay: 0.25s; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 relative overflow-x-hidden">
    
    <!-- Navigation Header -->
    <nav class="relative z-10 bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-gray-900">Baieco</span>
                        <p class="text-xs text-gray-500 font-medium">Servicio Técnico Profesional</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="group flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 px-5 py-2.5 rounded-lg font-semibold transition-all duration-200">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Volver al Inicio</span>
                        <span class="sm:hidden">Inicio</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Card -->
        <div class="mb-8" style="animation: fade-in 0.6s ease-out;">
            <div class="relative bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="relative z-10 p-6 md:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="flex-shrink-0 w-14 h-14 bg-white bg-opacity-20 backdrop-blur rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-bold text-white">Orden #{{ $orden->numero_orden }}</h1>
                                    <p class="text-white text-opacity-90 text-sm md:text-base font-medium mt-1">Estado actual de tu orden de servicio</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            @php
                                $estadoConfig = [
                                    'pendiente' => ['bg' => 'bg-yellow-500', 'texto' => '⏳ Pendiente'],
                                    'asignado' => ['bg' => 'bg-blue-500', 'texto' => '👤 Asignado'],
                                    'en_progreso' => ['bg' => 'bg-indigo-500', 'texto' => '⚙️ En Progreso'],
                                    'completada' => ['bg' => 'bg-teal-500', 'texto' => '✓ Completada'],
                                    'entregada' => ['bg' => 'bg-green-500', 'texto' => '📦 Entregada'],
                                    'cancelada' => ['bg' => 'bg-red-500', 'texto' => '✕ Cancelada'],
                                ];
                                $config = $estadoConfig[$orden->estado] ?? ['bg' => 'bg-gray-500', 'texto' => '● Desconocido'];
                            @endphp
                            <div class="status-badge inline-flex items-center justify-center px-6 py-3 rounded-xl text-base font-bold {{ $config['bg'] }} text-white shadow-lg">
                                {{ $config['texto'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Layout Responsivo -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- Columna Principal (2/3) -->
            <div class="xl:col-span-2 space-y-6">
                
                <!-- Descripción del Problema -->
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Descripción del Problema</h2>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700 text-base leading-relaxed">{{ $orden->descripcion_problema ?? 'No especificada' }}</p>
                    </div>
                </div>

                <!-- Dictamen Técnico -->
                @if($orden->dictamen_tecnico)
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Dictamen Técnico</h2>
                    </div>
                    <div class="bg-teal-50 rounded-lg p-4 border border-teal-200">
                        <p class="text-gray-700 text-base leading-relaxed">{{ $orden->dictamen_tecnico }}</p>
                    </div>
                </div>
                @endif

                <!-- Información del Equipo -->
                @if($orden->equipo)
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Información del Equipo</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Tipo</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->equipo->tipo_equipo ?? 'No especificado' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Marca</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->equipo->marca->nombre_marca ?? 'No especificada' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Modelo</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->equipo->modelo ?? 'No especificado' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Número de Serie</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->equipo->numero_serie ?? 'No especificado' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Información de Costos -->
                @if($orden->precio_presupuestado || $orden->abono)
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Información de Costos</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @if($orden->precio_presupuestado)
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-2">Presupuesto</p>
                            <p class="font-bold text-2xl text-gray-900">${{ number_format($orden->precio_presupuestado, 0, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($orden->abono)
                        <div class="bg-teal-50 rounded-lg p-5 border border-teal-200">
                            <p class="text-xs font-semibold text-teal-600 mb-2">Abono Realizado</p>
                            <p class="font-bold text-2xl text-teal-700">${{ number_format($orden->abono, 0, ',', '.') }}</p>
                        </div>
                        @endif
                        @if($orden->precio_presupuestado && $orden->abono)
                        <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg p-5 shadow-lg">
                            <p class="text-xs font-semibold text-white mb-2">Saldo Pendiente</p>
                            <p class="font-bold text-2xl text-white">${{ number_format($orden->precio_presupuestado - $orden->abono, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Técnico Asignado -->
                @if($orden->tecnico)
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            </svg>
                        </span>
                        Técnico Asignado
                    </h3>
                    <div class="flex items-center bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                            <span class="text-white font-bold text-lg">{{ substr($orden->tecnico->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-bold text-base text-gray-900">{{ $orden->tecnico->name }}</p>
                            @if($orden->tecnico->email)
                            <p class="text-xs text-gray-600 mt-1 break-all">{{ $orden->tecnico->email }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Botón Consultar Nueva Orden -->
                <div class="info-card bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-white mb-2 flex items-center">
                        <span class="w-10 h-10 bg-white bg-opacity-20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        ¿Otra Consulta?
                    </h3>
                    <p class="text-white text-opacity-90 mb-4 text-sm">Busca el estado de otra orden de servicio</p>
                    <a href="{{ route('home') }}#consultar" class="block w-full bg-white hover:bg-gray-100 text-purple-600 font-bold py-3 px-6 rounded-lg text-center transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Nueva Búsqueda
                    </a>
                </div>

                <!-- Historial de Estado -->
                @if(isset($orden->historial) && $orden->historial && $orden->historial->count() > 0)
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Historial de Cambios</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach($orden->historial->sortByDesc('created_at') as $cambio)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-500 mb-1">{{ $cambio->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="font-semibold text-gray-900">{{ $cambio->descripcion }}</p>
                                    @if($cambio->usuario)
                                    <p class="text-sm text-gray-600 mt-1">Por: {{ $cambio->usuario->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <!-- Columna Lateral (1/3) -->
            <div class="space-y-6">
                
                <!-- Cliente -->
                @if($orden->cliente)
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        Datos del Cliente
                    </h3>
                    <div class="space-y-3">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Nombre</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->cliente->nombre }} {{ $orden->cliente->apellido }}</p>
                        </div>
                        @if($orden->cliente->email)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Email</p>
                            <p class="font-medium text-sm text-gray-700 break-all">{{ $orden->cliente->email }}</p>
                        </div>
                        @endif
                        @if($orden->cliente->telefono)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Teléfono</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->cliente->telefono }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Información General -->
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        Información General
                    </h3>
                    <div class="space-y-3">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Fecha de Ingreso</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->fecha_ingreso ? $orden->fecha_ingreso->format('d/m/Y') : 'No especificada' }}</p>
                        </div>
                        
                        @if($orden->fecha_programada)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Fecha Programada</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->fecha_programada->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        
                        @if($orden->fecha_aprox_entrega)
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <p class="text-xs font-semibold text-purple-600 mb-1">🎯 Fecha Estimada de Entrega</p>
                            <p class="font-bold text-xl text-purple-700">{{ $orden->fecha_aprox_entrega->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        
                        @if($orden->fecha_completada)
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-200">
                            <p class="text-xs font-semibold text-teal-600 mb-1">✅ Fecha de Finalización</p>
                            <p class="font-bold text-base text-gray-900">{{ $orden->fecha_completada->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-2">Prioridad</p>
                            @php
                                $prioridadConfig = [
                                    'baja' => ['bg' => 'bg-gray-500', 'texto' => 'Baja'],
                                    'media' => ['bg' => 'bg-blue-500', 'texto' => 'Media'],
                                    'alta' => ['bg' => 'bg-orange-500', 'texto' => 'Alta'],
                                    'urgente' => ['bg' => 'bg-red-500', 'texto' => 'Urgente'],
                                ];
                                $prioridad = $prioridadConfig[$orden->prioridad] ?? ['bg' => 'bg-gray-500', 'texto' => 'No especificada'];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold {{ $prioridad['bg'] }} text-white">
                                {{ $prioridad['texto'] }}
                            </span>
                        </div>

                        @if($orden->tipo_servicio)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Tipo de Servicio</p>
                            <p class="font-bold text-base text-gray-900 capitalize">{{ str_replace('_', ' ', $orden->tipo_servicio) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="relative z-10 bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-2xl font-bold">Baieco</span>
                </div>
                <p class="text-lg font-semibold text-white mb-2">&copy; 2025 Baieco. Todos los derechos reservados.</p>
                <p class="text-sm text-gray-400">Sistema de Gestión de Órdenes de Servicio Técnico</p>
            </div>
        </div>
    </footer>

</body>
</html>
