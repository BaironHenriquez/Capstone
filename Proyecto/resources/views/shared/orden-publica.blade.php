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

                <!-- Galería de Fotos -->
                <div class="info-card bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Fotos del Equipo</h2>
                    </div>
                    
                    <!-- Galería de fotos existentes -->
                    @if($orden->fotos_ingreso && is_array($orden->fotos_ingreso) && count($orden->fotos_ingreso) > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($orden->fotos_ingreso as $foto)
                                <div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                                    <img src="{{ $foto }}" alt="Foto del equipo" class="w-full h-40 object-cover cursor-pointer" onclick="abrirVisorFoto(this.src)">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                                        <button onclick="abrirVisorFoto(this.parentElement.querySelector('img').src)" 
                                                class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                                            Ver Grande
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-500 text-sm">No hay fotos aún</p>
                        </div>
                    @endif
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

                <!-- Botón de Calificación -->
                @if($orden->estado === 'completada' && $orden->tecnico && !$orden->calificacion)
                <div class="info-card bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl shadow-lg p-6 animate-pulse">
                    <h3 class="text-lg font-bold text-white mb-2 flex items-center">
                        <span class="w-10 h-10 bg-white bg-opacity-20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </span>
                        ¡Califica Nuestro Servicio!
                    </h3>
                    <p class="text-white text-opacity-90 mb-4 text-sm">Tu opinión nos ayuda a mejorar</p>
                    <button onclick="abrirModalCalificacion()" 
                            class="block w-full bg-white hover:bg-gray-100 text-orange-600 font-bold py-3 px-6 rounded-lg text-center transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Calificar Servicio
                    </button>
                </div>
                @elseif($orden->calificacion)
                <div class="info-card bg-green-50 rounded-xl shadow-lg p-6 border-2 border-green-200">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-green-800 mb-2">¡Gracias por tu Calificación!</h3>
                        <p class="text-green-700 text-sm">Ya has evaluado este servicio</p>
                        <div class="flex justify-center mt-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $orden->calificacion->calificacion ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
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

    <!-- Visor de Fotos -->
    <div id="visorFoto" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4" onclick="cerrarVisorFoto()">
        <div class="max-w-4xl max-h-full" onclick="event.stopPropagation()">
            <button onclick="cerrarVisorFoto()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <img id="fotoAmpliada" class="max-w-full max-h-screen object-contain" alt="Foto ampliada">
        </div>
    </div>

    <!-- Modal de Calificación -->
    <div id="modalCalificacion" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fondo oscuro -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="cerrarModalCalificacion()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenido del Modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gradient-to-br from-purple-600 to-pink-600 px-4 py-5 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-white bg-opacity-20 backdrop-blur rounded-lg p-2">
                                <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-xl font-bold text-white" id="modal-title">
                                Calificar Servicio
                            </h3>
                        </div>
                        <button onclick="cerrarModalCalificacion()" class="bg-white bg-opacity-20 backdrop-blur rounded-lg p-2 text-white hover:bg-opacity-30 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="formCalificacion" onsubmit="enviarCalificacion(event)">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="space-y-4">
                            <!-- Info de la Orden -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Orden de Servicio</p>
                                <p class="text-lg font-bold text-gray-900">{{ $orden->numero_orden }}</p>
                                @if($orden->tecnico)
                                <p class="text-sm text-gray-600 mt-2">Técnico</p>
                                <p class="text-base font-semibold text-gray-900">{{ $orden->tecnico->name }}</p>
                                @endif
                            </div>

                            <!-- Estrellas de Calificación -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">
                                    ¿Cómo calificarías el servicio? <span class="text-red-500">*</span>
                                </label>
                                <div class="flex justify-center space-x-2" id="estrellas">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            onclick="seleccionarEstrellas({{ $i }})"
                                            class="estrella focus:outline-none transform transition-all duration-200 hover:scale-110"
                                            data-valor="{{ $i }}">
                                        <svg class="w-12 h-12 text-gray-300 hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="calificacion" id="calificacionInput" required>
                                <p class="text-center text-sm text-gray-500 mt-2" id="textoCalificacion">Selecciona una calificación</p>
                            </div>

                            <!-- Comentario -->
                            <div>
                                <label for="comentario" class="block text-sm font-bold text-gray-700 mb-2">
                                    Comentarios (opcional)
                                </label>
                                <textarea 
                                    name="comentario" 
                                    id="comentario"
                                    rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                                    placeholder="Cuéntanos sobre tu experiencia..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-base font-bold text-white hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto transition-all duration-200">
                            Enviar Calificación
                        </button>
                        <button type="button" 
                                onclick="cerrarModalCalificacion()"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let calificacionSeleccionada = 0;

        // ==================== CALIFICACIÓN ====================
        function abrirModalCalificacion() {
            document.getElementById('modalCalificacion').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModalCalificacion() {
            document.getElementById('modalCalificacion').classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            document.getElementById('formCalificacion').reset();
            calificacionSeleccionada = 0;
            document.getElementById('calificacionInput').value = '';
            
            const estrellas = document.querySelectorAll('.estrella svg');
            estrellas.forEach(estrella => {
                estrella.classList.remove('text-yellow-400');
                estrella.classList.add('text-gray-300');
            });
            
            document.getElementById('textoCalificacion').textContent = 'Selecciona una calificación';
        }

        function seleccionarEstrellas(rating) {
            calificacionSeleccionada = rating;
            document.getElementById('calificacionInput').value = rating;
            
            const estrellas = document.querySelectorAll('.estrella svg');
            const textos = ['Muy Malo', 'Malo', 'Regular', 'Bueno', 'Excelente'];
            
            estrellas.forEach((estrella, index) => {
                if (index < rating) {
                    estrella.classList.remove('text-gray-300');
                    estrella.classList.add('text-yellow-400');
                } else {
                    estrella.classList.remove('text-yellow-400');
                    estrella.classList.add('text-gray-300');
                }
            });
            
            document.getElementById('textoCalificacion').textContent = textos[rating - 1];
        }

        async function enviarCalificacion(event) {
            event.preventDefault();
            
            const calificacion = document.getElementById('calificacionInput').value;
            if (!calificacion) {
                alert('Por favor selecciona una calificación');
                return;
            }

            const comentario = document.getElementById('comentario').value;
            
            try {
                const response = await fetch('{{ route("calificacion.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        orden_servicio_id: {{ $orden->id }},
                        tecnico_id: {{ $orden->tecnico_id ?? 'null' }},
                        calificacion: parseInt(calificacion),
                        comentario: comentario
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert('¡Gracias por tu calificación!');
                    cerrarModalCalificacion();
                    location.reload();
                } else {
                    alert(data.message || 'Error al enviar la calificación');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al enviar la calificación. Por favor intenta de nuevo.');
            }
        }

        // ==================== VISOR DE FOTOS ====================
        function abrirVisorFoto(src) {
            document.getElementById('visorFoto').classList.remove('hidden');
            document.getElementById('fotoAmpliada').src = src;
            document.body.style.overflow = 'hidden';
        }

        function cerrarVisorFoto() {
            document.getElementById('visorFoto').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar visor con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                cerrarVisorFoto();
            }
        });
    </script>

</body>
</html>
