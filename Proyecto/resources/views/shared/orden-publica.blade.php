<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Orden {{ $orden->numero_orden }} - Baieco</title>
    @vite(['resources/css/app.css', 'resources/css/baieco.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                opacity: 1; 
                box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
            }
            50% { 
                opacity: 0.85; 
                box-shadow: 0 0 40px rgba(139, 92, 246, 0.8);
            }
        }
        
        @keyframes slide-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .status-badge {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        .info-card {
            animation: slide-in-up 0.6s ease-out;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .info-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .float-icon {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 300% 300%;
            animation: gradient-shift 6s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Animaciones de entrada escalonadas */
        .info-card:nth-child(1) { animation-delay: 0.1s; }
        .info-card:nth-child(2) { animation-delay: 0.2s; }
        .info-card:nth-child(3) { animation-delay: 0.3s; }
        .info-card:nth-child(4) { animation-delay: 0.4s; }
        .info-card:nth-child(5) { animation-delay: 0.5s; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 relative overflow-x-hidden">
    
    <!-- Elementos decorativos de fondo -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .animate-blob { animation: blob 10s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
    
    <!-- Navigation Header -->
    <nav class="relative z-10 bg-white bg-opacity-80 backdrop-blur-lg shadow-lg border-b border-purple-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-75 float-icon"></div>
                        <div class="relative w-14 h-14 bg-gradient-to-br from-purple-600 via-pink-500 to-red-500 rounded-2xl flex items-center justify-center shadow-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-3xl font-black bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 bg-clip-text text-transparent">Baieco</span>
                        <p class="text-xs text-gray-500 font-medium">Servicio Técnico Profesional</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="group flex items-center space-x-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        <!-- Header Card con gradiente mejorado -->
        <div class="mb-8 md:mb-12 animate-scale-in" style="animation: scale-in 0.8s ease-out;">
            <div class="relative bg-gradient-to-r from-purple-600 via-pink-600 to-red-500 rounded-3xl shadow-2xl overflow-hidden">
                <!-- Patrón de fondo -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
                </div>
                
                <!-- Elementos decorativos -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-10 rounded-full -ml-48 -mb-48 blur-3xl"></div>
                
                <div class="relative z-10 p-6 md:p-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-start md:items-center mb-4">
                                <div class="flex-shrink-0 w-16 h-16 md:w-20 md:h-20 bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl flex items-center justify-center mr-4 md:mr-6 shadow-2xl border-2 border-white border-opacity-30">
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-5xl font-black text-white mb-2">Orden #{{ $orden->numero_orden }}</h1>
                                    <p class="text-white text-opacity-90 text-base md:text-lg font-medium">Estado actual de tu orden de servicio</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            @php
                                $estadoConfig = [
                                    'pendiente' => ['bg' => 'bg-yellow-400', 'texto' => '⏳ Pendiente', 'border' => 'border-yellow-300'],
                                    'asignado' => ['bg' => 'bg-blue-400', 'texto' => '👤 Asignado', 'border' => 'border-blue-300'],
                                    'en_progreso' => ['bg' => 'bg-indigo-500', 'texto' => '⚙️ En Progreso', 'border' => 'border-indigo-400'],
                                    'completada' => ['bg' => 'bg-green-500', 'texto' => '✓ Completada', 'border' => 'border-green-400'],
                                    'entregada' => ['bg' => 'bg-emerald-500', 'texto' => '📦 Entregada', 'border' => 'border-emerald-400'],
                                    'cancelada' => ['bg' => 'bg-red-500', 'texto' => '✕ Cancelada', 'border' => 'border-red-400'],
                                ];
                                $config = $estadoConfig[$orden->estado] ?? ['bg' => 'bg-gray-400', 'texto' => '● Desconocido', 'border' => 'border-gray-300'];
                            @endphp
                            <div class="status-badge inline-flex items-center justify-center px-6 md:px-8 py-4 md:py-5 rounded-2xl text-lg md:text-xl font-black {{ $config['bg'] }} text-white shadow-2xl border-4 {{ $config['border'] }} backdrop-blur-sm">
                                {{ $config['texto'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Layout Responsivo -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 md:gap-6">
            
            <!-- Columna Principal (2/3) -->
            <div class="xl:col-span-2 space-y-4 md:space-y-6">
                
                <!-- Descripción del Problema -->
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative">
                    <!-- Decoración de fondo -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mr-3 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl md:text-2xl font-black text-gray-800">Descripción del Problema</h2>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-4 md:p-5 border-2 border-blue-100">
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed font-medium">{{ $orden->descripcion_problema ?? 'No especificada' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dictamen Técnico -->
                @if($orden->dictamen_tecnico)
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mr-3 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl md:text-2xl font-black text-gray-800">Dictamen Técnico</h2>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-4 md:p-5 border-2 border-purple-100">
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed font-medium">{{ $orden->dictamen_tecnico }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Información del Equipo -->
                @if($orden->equipo)
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center mr-3 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl md:text-2xl font-black text-gray-800">Información del Equipo</h2>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-3 md:p-4 border-2 border-indigo-100 hover:border-indigo-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-indigo-600 mb-1">💻 Tipo</p>
                                <p class="font-bold text-base text-gray-800">{{ $orden->equipo->tipo ?? 'No especificado' }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-3 md:p-4 border-2 border-indigo-100 hover:border-indigo-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-indigo-600 mb-1">🏷️ Marca</p>
                                <p class="font-bold text-base text-gray-800">{{ $orden->equipo->marca->nombre ?? 'No especificada' }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-3 md:p-4 border-2 border-indigo-100 hover:border-indigo-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-indigo-600 mb-1">📱 Modelo</p>
                                <p class="font-bold text-base text-gray-800">{{ $orden->equipo->modelo ?? 'No especificado' }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-3 md:p-4 border-2 border-indigo-100 hover:border-indigo-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-indigo-600 mb-1">🔢 Número de Serie</p>
                                <p class="font-bold text-base text-gray-800">{{ $orden->equipo->numero_serie ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Historial de Estado -->
                @if(isset($orden->historial) && $orden->historial && $orden->historial->count() > 0)
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-6 md:p-8 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-black text-gray-800">Historial de Cambios</h2>
                        </div>
                        <div class="space-y-4">
                            @foreach($orden->historial->sortByDesc('created_at') as $cambio)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-4 h-4 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full mt-2 mr-4 shadow-lg ring-4 ring-green-100"></div>
                                <div class="flex-1">
                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-5 border-2 border-green-100 hover:border-green-300 transition-colors duration-300">
                                        <p class="text-sm font-semibold text-green-600 mb-2">📅 {{ $cambio->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="font-bold text-base text-gray-800">{{ $cambio->descripcion }}</p>
                                        @if($cambio->usuario)
                                        <p class="text-sm text-gray-600 mt-2">👤 Por: {{ $cambio->usuario->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Columna Lateral (1/3) -->
            <div class="space-y-4 md:space-y-6">
                
                <!-- Información General -->
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative sticky top-4">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl md:text-2xl font-black text-gray-800 mb-4 flex items-center">
                            <span class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mr-2 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            Información General
                        </h3>
                        <div class="space-y-3">
                        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-3 md:p-4 border-2 border-cyan-100 hover:border-cyan-300 transition-colors duration-300">
                            <p class="text-xs font-semibold text-cyan-600 mb-1">📅 Fecha de Ingreso</p>
                            <p class="font-bold text-base text-gray-800">{{ $orden->fecha_ingreso ? $orden->fecha_ingreso->format('d/m/Y') : 'No especificada' }}</p>
                        </div>
                        
                        @if($orden->fecha_programada)
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-3 md:p-4 border-2 border-purple-100 hover:border-purple-300 transition-colors duration-300">
                            <p class="text-xs font-semibold text-purple-600 mb-1">🗓️ Fecha Programada</p>
                            <p class="font-bold text-base text-gray-800">{{ $orden->fecha_programada->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        
                        @if($orden->fecha_aprox_entrega)
                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-3 md:p-4 border-2 border-orange-200 hover:border-orange-400 transition-colors duration-300 ring-2 ring-orange-100">
                            <p class="text-xs font-semibold text-orange-600 mb-1">🎯 Fecha Estimada de Entrega</p>
                            <p class="font-black text-xl text-orange-700">{{ $orden->fecha_aprox_entrega->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        
                        @if($orden->fecha_completada)
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-3 md:p-4 border-2 border-green-100 hover:border-green-300 transition-colors duration-300">
                            <p class="text-xs font-semibold text-green-600 mb-1">✅ Fecha de Finalización</p>
                            <p class="font-bold text-base text-gray-800">{{ $orden->fecha_completada->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif

                        <div class="bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl p-3 md:p-4 border-2 border-violet-100 hover:border-violet-300 transition-colors duration-300">
                            <p class="text-xs font-semibold text-violet-600 mb-2">⚡ Prioridad</p>
                            @php
                                $prioridadConfig = [
                                    'baja' => ['bg' => 'bg-gradient-to-r from-gray-400 to-gray-500', 'texto' => 'Baja', 'emoji' => '🔵'],
                                    'media' => ['bg' => 'bg-gradient-to-r from-blue-400 to-blue-500', 'texto' => 'Media', 'emoji' => '🟡'],
                                    'alta' => ['bg' => 'bg-gradient-to-r from-orange-400 to-orange-500', 'texto' => 'Alta', 'emoji' => '🟠'],
                                    'urgente' => ['bg' => 'bg-gradient-to-r from-red-500 to-red-600', 'texto' => 'Urgente', 'emoji' => '🔴'],
                                ];
                                $prioridad = $prioridadConfig[$orden->prioridad] ?? ['bg' => 'bg-gradient-to-r from-gray-400 to-gray-500', 'texto' => 'No especificada', 'emoji' => '⚪'];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-black {{ $prioridad['bg'] }} text-white shadow-lg">
                                <span class="text-xl mr-2">{{ $prioridad['emoji'] }}</span> {{ $prioridad['texto'] }}
                            </span>
                        </div>

                        @if($orden->tipo_servicio)
                        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-3 md:p-4 border-2 border-teal-100 hover:border-teal-300 transition-colors duration-300">
                            <p class="text-xs font-semibold text-teal-600 mb-1">🔧 Tipo de Servicio</p>
                            <p class="font-bold text-base text-gray-800 capitalize">{{ str_replace('_', ' ', $orden->tipo_servicio) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Cliente -->
                @if($orden->cliente)
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl md:text-2xl font-black text-gray-800 mb-4 flex items-center">
                            <span class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mr-2 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            Datos del Cliente
                        </h3>
                        <div class="space-y-3">
                            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl p-3 md:p-4 border-2 border-pink-100 hover:border-pink-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-pink-600 mb-1">👤 Nombre</p>
                                <p class="font-bold text-base text-gray-800">{{ $orden->cliente->nombre }} {{ $orden->cliente->apellido }}</p>
                            </div>
                            @if($orden->cliente->email)
                            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl p-3 md:p-4 border-2 border-pink-100 hover:border-pink-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-pink-600 mb-1">📧 Email</p>
                                <p class="font-medium text-sm text-gray-700 break-all">{{ $orden->cliente->email }}</p>
                            </div>
                            @endif
                            @if($orden->cliente->telefono)
                            <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl p-3 md:p-4 border-2 border-pink-100 hover:border-pink-300 transition-colors duration-300">
                                <p class="text-xs font-semibold text-pink-600 mb-1">📱 Teléfono</p>
                                <p class="font-bold text-lg text-gray-800">{{ $orden->cliente->telefono }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Técnico Asignado -->
                @if($orden->tecnico)
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-violet-100 to-purple-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl md:text-2xl font-black text-gray-800 mb-4 flex items-center">
                            <span class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mr-2 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                            </span>
                            Técnico Asignado
                        </h3>
                        <div class="flex items-center bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl p-4 border-2 border-violet-100 hover:border-violet-300 transition-colors duration-300">
                            <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mr-3 shadow-xl ring-4 ring-violet-100">
                                <span class="text-white font-black text-xl md:text-2xl">{{ substr($orden->tecnico->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-black text-lg md:text-xl text-gray-800">{{ $orden->tecnico->name }}</p>
                                @if($orden->tecnico->email)
                                <p class="text-xs md:text-sm text-gray-600 mt-1 break-all">{{ $orden->tecnico->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Información de Costos -->
                @if($orden->precio_presupuestado || $orden->abono)
                <div class="info-card group bg-white rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full -mr-20 -mt-20 opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl md:text-2xl font-black text-gray-800 mb-4 flex items-center">
                            <span class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-2 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            Información de Costos
                        </h3>
                        <div class="space-y-3">
                            @if($orden->precio_presupuestado)
                            <div class="flex justify-between items-center bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border-2 border-amber-100 hover:border-amber-300 transition-colors duration-300">
                                <span class="font-semibold text-amber-600 text-sm md:text-base">💰 Presupuesto:</span>
                                <span class="font-black text-xl md:text-2xl text-gray-800">${{ number_format($orden->precio_presupuestado, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($orden->abono)
                            <div class="flex justify-between items-center bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-100 hover:border-green-300 transition-colors duration-300">
                                <span class="font-semibold text-green-600 text-sm md:text-base">✅ Abono:</span>
                                <span class="font-black text-lg md:text-xl text-green-600">${{ number_format($orden->abono, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($orden->precio_presupuestado && $orden->abono)
                            <div class="flex justify-between items-center bg-gradient-to-r from-red-500 to-pink-500 rounded-xl p-4 md:p-5 border-4 border-red-200 shadow-xl ring-2 ring-red-100">
                                <span class="font-black text-white text-sm md:text-base">💳 Saldo Pendiente:</span>
                                <span class="font-black text-2xl md:text-3xl text-white">${{ number_format($orden->precio_presupuestado - $orden->abono, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Botón Consultar Nueva Orden -->
                <div class="info-card group bg-gradient-to-br from-teal-500 via-cyan-500 to-blue-500 rounded-3xl shadow-xl hover:shadow-2xl p-5 md:p-6 border-4 border-white overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-teal-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl md:text-2xl font-black text-white mb-2 flex items-center">
                            <span class="w-10 h-10 bg-white bg-opacity-20 backdrop-blur rounded-xl flex items-center justify-center mr-2 shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            ¿Otra Consulta?
                        </h3>
                        <p class="text-white text-opacity-90 mb-4 text-sm md:text-base">Busca el estado de otra orden de servicio</p>
                        <a href="{{ route('home') }}#consultar" class="block w-full bg-white hover:bg-opacity-90 text-teal-600 font-black py-3 md:py-4 px-6 rounded-xl text-center text-base md:text-lg transition-all duration-300 transform hover:scale-105 shadow-2xl">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Nueva Búsqueda
                    </a>
                </div>

            </div>
        </div>

    </div>

    <!-- Footer Moderno -->
    <footer class="relative z-10 bg-gradient-to-r from-gray-900 via-purple-900 to-indigo-900 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-2xl blur opacity-75"></div>
                        <div class="relative w-14 h-14 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <span class="ml-4 text-4xl font-black bg-gradient-to-r from-white via-purple-200 to-pink-200 bg-clip-text text-transparent">Baieco</span>
                </div>
                <p class="text-xl font-semibold text-white text-opacity-90 mb-2">&copy; 2025 Baieco. Todos los derechos reservados.</p>
                <p class="text-base text-white text-opacity-60">Sistema de Gestión de Órdenes de Servicio Técnico Profesional</p>
                <div class="mt-6 flex justify-center space-x-6">
                    <a href="#" class="text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
