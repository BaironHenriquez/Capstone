<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baieco - Sistema de Gestión de Órdenes de Servicio</title>
    <meta name="description" content="Sistema profesional para gestionar órdenes de servicio en talleres técnicos.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .animate-blob {
            animation: blob 10s infinite;
        }
        .delay-2 {
            animation-delay: 2s;
        }
        .delay-4 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">Baieco</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#inicio" class="text-gray-700 hover:text-purple-600 transition font-medium">Inicio</a>
                    <a href="#caracteristicas" class="text-gray-700 hover:text-purple-600 transition font-medium">Características</a>
                    <a href="#consultar" class="text-gray-700 hover:text-purple-600 transition font-medium">Consultar</a>
                    <a href="#contacto" class="text-gray-700 hover:text-purple-600 transition font-medium">Contacto</a>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition transform hover:scale-105">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="text-gray-700 hover:text-purple-600 transition font-medium">Ingresar</a>
                        <a href="{{ route('register.form') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-lg font-semibold transition transform hover:scale-105">
                            Crear Cuenta
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="pt-24 pb-20 gradient-primary relative overflow-hidden min-h-screen flex items-center">
        <!-- Animated background blobs -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob delay-2"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob delay-4"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                    Sistema de Gestión de
                    <span class="block bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-orange-400">
                        Órdenes de Servicio
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Plataforma profesional diseñada para talleres técnicos. Gestiona órdenes, 
                    clientes y equipos con facilidad y eficiencia.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#consultar" class="bg-white text-purple-700 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-2xl inline-flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Consultar Orden
                    </a>
                    @guest
                        <a href="{{ route('register.form') }}" class="bg-gradient-to-r from-orange-500 to-pink-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-pink-700 transition transform hover:scale-105 shadow-2xl inline-flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Crear Cuenta Gratis
                        </a>
                    @endguest
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto mt-16">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">100+</div>
                        <div class="text-white/80">Órdenes Gestionadas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">24/7</div>
                        <div class="text-white/80">Disponibilidad</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">99%</div>
                        <div class="text-white/80">Satisfacción</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="caracteristicas" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    Características Principales
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Todo lo que necesitas para gestionar tu taller técnico de manera profesional
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Gestión de Órdenes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Crea y administra órdenes de servicio con seguimiento completo del estado en tiempo real.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Gestión de Clientes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Administra tu base de clientes y sus equipos de manera organizada y eficiente.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Reportes y Estadísticas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Visualiza el rendimiento de tu taller con reportes detallados y gráficos intuitivos.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Seguimiento en Tiempo Real</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Mantén a tus clientes informados con actualizaciones automáticas del estado de sus equipos.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Sistema Seguro</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Protección de datos con autenticación robusta y roles de usuario bien definidos.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Diseño Responsivo</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Accede desde cualquier dispositivo: computadora, tablet o smartphone con la misma experiencia.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Lookup Section -->
    <section id="consultar" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    Consulta tu Orden de Servicio
                </h2>
                <p class="text-xl text-gray-600">
                    Ingresa el código de tu orden para ver su estado actual y detalles
                </p>
            </div>

            <div class="max-w-3xl mx-auto">
                <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-3xl shadow-2xl p-8 md:p-12">
                    <form id="order-lookup-form" class="space-y-6">
                        <div>
                            <label for="order-code" class="block text-sm font-bold text-gray-700 mb-3">
                                Código de Orden de Servicio
                            </label>
                            <input type="text" 
                                   id="order-code" 
                                   name="order_code" 
                                   class="w-full px-6 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition"
                                   placeholder="Ejemplo: BA-2025-001"
                                   maxlength="11"
                                   required>
                            <p class="text-sm text-gray-500 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Formato esperado: BA-YYYY-NNN
                            </p>
                        </div>
<<<<<<< HEAD
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-8 py-5 rounded-xl font-bold text-lg transition transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar Orden
                        </button>
                    </form>
                    
                    <!-- Resultado de búsqueda -->
                    <div id="order-result" class="mt-8 hidden"></div>
=======
                        
                        <form id="order-lookup-form" action="{{ route('ordenes.buscar') }}" method="GET" class="space-y-6">
                            <div>
                                <label for="order-code" class="block text-sm font-semibold text-baieco-primary mb-3">
                                    Código de Orden de Servicio
                                </label>
                                <input type="text" id="order-code" name="order_code" 
                                       class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-baieco-secondary focus:ring-opacity-20 focus:border-baieco-secondary transition-all duration-300 text-lg focus-ring"
                                       placeholder="Ej: BA-2025-001"
                                       maxlength="20"
                                       required>
                                <p class="text-sm text-gray-500 mt-2">Formato: BA-YYYY-NNN o TS-YYYY-NNNN</p>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-baieco-secondary to-baieco-primary hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Buscar Orden
                            </button>
                            
                            @if(session('error'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4" role="alert">
                                    <p class="font-bold">❌ Error</p>
                                    <p>{{ session('error') }}</p>
                                    <p class="text-sm mt-2">💡 Intenta con uno de estos formatos:</p>
                                    <ul class="text-sm list-disc list-inside">
                                        <li>TS-2025-3956</li>
                                        <li>BA-2025-001</li>
                                    </ul>
                                </div>
                            @endif
                            
                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mt-4" role="alert">
                                    <p class="font-bold">✅ Éxito</p>
                                    <p>{{ session('success') }}</p>
                                </div>
                            @endif
                        </form>
                    </div>
>>>>>>> cdba2a43de060147d6b7a088e24e66938740b949
                </div>

                <!-- Estados Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                    <div class="flex items-start space-x-4 p-6 bg-yellow-50 rounded-xl border-l-4 border-yellow-500">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Recibido</h4>
                            <p class="text-sm text-gray-600">Orden ingresada al sistema y en espera de diagnóstico</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">En Diagnóstico</h4>
                            <p class="text-sm text-gray-600">Técnico evaluando el problema del equipo</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-orange-50 rounded-xl border-l-4 border-orange-500">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">En Reparación</h4>
                            <p class="text-sm text-gray-600">Técnico trabajando activamente en la reparación</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 p-6 bg-green-50 rounded-xl border-l-4 border-green-500">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Completado</h4>
                            <p class="text-sm text-gray-600">Equipo reparado y listo para retiro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    ¿Tienes Preguntas?
                </h2>
                <p class="text-xl text-gray-600">
                    Estamos aquí para ayudarte. Contáctanos por cualquiera de estos medios
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Email</h3>
                    <p class="text-gray-600">contacto@baieco.cl</p>
                </div>

                <div class="text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Teléfono</h3>
                    <p class="text-gray-600">+56 9 1234 5678</p>
                </div>

                <div class="text-center p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Ubicación</h3>
                    <p class="text-gray-600">Santiago, Chile</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">Baieco</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed mb-4">
                        Sistema profesional de gestión de órdenes de servicio diseñado 
                        específicamente para talleres técnicos modernos.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-purple-600 rounded-lg flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#inicio" class="text-gray-400 hover:text-white transition">Inicio</a></li>
                        <li><a href="#caracteristicas" class="text-gray-400 hover:text-white transition">Características</a></li>
                        <li><a href="#consultar" class="text-gray-400 hover:text-white transition">Consultar Orden</a></li>
                        <li><a href="#contacto" class="text-gray-400 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Términos de Servicio</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Política de Privacidad</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Cookies</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2025 <span class="text-white font-semibold">Baieco</span>. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Success Alert -->
    @if(session('success'))
        <div id="success-alert" class="fixed top-20 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl z-50 animate-slide-in max-w-md">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        </script>
    @endif

    <script>
        // Smooth scroll para navegación
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 64; // altura del navbar
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Formulario de búsqueda de órdenes
        document.getElementById('order-lookup-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const orderCode = document.getElementById('order-code').value.trim();
            const resultDiv = document.getElementById('order-result');
            
            if (!orderCode) {
                resultDiv.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg animate-fade-in">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-800 font-semibold">Por favor ingresa un código de orden válido.</p>
                        </div>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg animate-fade-in">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-700 mb-2">
                                    <strong>Código de orden:</strong> <span class="font-mono">${orderCode}</span>
                                </p>
                                <p class="text-blue-800">
                                    Para consultar el estado detallado de tu orden, por favor 
                                    <a href="{{ route('login.form') }}" class="font-bold underline hover:text-blue-900">inicia sesión</a> 
                                    en tu cuenta o contáctanos directamente.
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            resultDiv.classList.remove('hidden');
            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });

        // Añadir clase de animación al resultado
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }
            @keyframes slide-in {
                from { opacity: 0; transform: translateX(100%); }
                to { opacity: 1; transform: translateX(0); }
            }
            .animate-slide-in {
                animation: slide-in 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>