<!DOCTYPE html>
<html lang="es" class="smooth-scroll">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baieco - Sistema de Gestión de Órdenes de Servicio para Talleres Técnicos</title>
    <meta name="description" content="Baieco ofrece el software más completo para gestionar órdenes de servicio en talleres de reparación electrónica. Automatiza tu negocio con nuestro sistema integral.">
    <meta name="keywords" content="software talleres, gestión órdenes servicio, sistema reparaciones, software técnico, Baieco">
    
    @vite(['resources/css/app.css', 'resources/css/baieco.css', 'resources/js/app.js', 'resources/js/baieco.js'])
</head>
<body class="bg-baieco-light font-sans overflow-x-hidden">
    
    <!-- Navigation Header -->
    <nav class="bg-baieco-primary shadow-xl fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 animate-slide-in-left">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-baieco-accent rounded-xl flex items-center justify-center animate-pulse-glow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span class="text-white text-2xl font-bold tracking-wide">Baieco</span>
                        </div>
                    </div>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="#inicio" class="text-white hover:text-baieco-accent px-3 py-2 rounded-md text-sm font-medium transition-all duration-300 transform hover:scale-105">Inicio</a>
                        <a href="#caracteristicas" class="text-white hover:text-baieco-accent px-3 py-2 rounded-md text-sm font-medium transition-all duration-300 transform hover:scale-105">Características</a>
                        <a href="#consultar" class="text-white hover:text-baieco-accent px-3 py-2 rounded-md text-sm font-medium transition-all duration-300 transform hover:scale-105">Consultar Orden</a>
                        <a href="#contacto" class="text-white hover:text-baieco-accent px-3 py-2 rounded-md text-sm font-medium transition-all duration-300 transform hover:scale-105">Contacto</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard-admin') }}" class="bg-baieco-secondary hover:bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Panel Admin
                            </a>
                        @else
                            <a href="{{ route('register.form') }}" class="bg-baieco-secondary hover:bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Ingresar
                            </a>
                            <button data-action="open-demo" class="bg-baieco-accent hover:bg-orange-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Demo Gratis
                            </button>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="pt-16 gradient-hero relative overflow-hidden min-h-screen flex items-center">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-10 right-10 w-72 h-72 bg-orange-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-green-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-left animate-fade-in-up">
                    <h1 class="hero-title text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                        <span class="typing-text">Sistema de Gestión</span>
                        <span class="block text-baieco-accent animate-bounce-gentle">para Talleres</span>
                        <span class="block text-3xl md:text-4xl font-light mt-2">Técnicos Electrónicos</span>
                    </h1>
                    <p class="text-xl text-white mb-8 max-w-2xl leading-relaxed opacity-90">
                        <strong>Baieco</strong> es el software que revoluciona la gestión de órdenes de servicio. 
                        Automatiza procesos, mejora la comunicación con clientes y optimiza la productividad de tu taller.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 animate-slide-in-left">
                        <a href="{{ route('register.form') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-full text-lg font-bold transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center shadow-lg hover:shadow-xl border-2 border-transparent">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Crear cuenta de servicio técnico
                        </a>
                        <button data-action="open-demo" class="bg-baieco-success hover:bg-green-600 text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Solicitar Demo
                        </button>
                        <a href="#consultar" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-baieco-primary px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Consultar Orden
                        </a>
                    </div>
                </div>
                
                <div class="relative animate-slide-in-right">
                    <div class="relative z-10">
                        <div class="glass-effect rounded-3xl p-8 shadow-large">
                            <div id="estadisticas" class="grid grid-cols-2 gap-6">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-white counter" data-target="500" data-suffix="+">0</div>
                                    <div class="text-white opacity-80">Talleres Activos</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-white counter" data-target="50000" data-suffix="+">0</div>
                                    <div class="text-white opacity-80">Órdenes Gestionadas</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-white counter" data-target="99" data-suffix="%">0</div>
                                    <div class="text-white opacity-80">Satisfacción</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-white counter" data-target="24" data-suffix="/7">0</div>
                                    <div class="text-white opacity-80">Soporte</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-orange-400 rounded-3xl blur-xl opacity-30 animate-pulse-glow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="caracteristicas" class="py-24 bg-white relative">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-orange-50 opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-baieco-primary mb-6 animate-on-scroll">
                    Características del Sistema
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed animate-on-scroll">
                    Baieco incluye todas las herramientas que necesitas para gestionar eficientemente tu taller de reparaciones electrónicas.
                </p>
                <div class="w-24 h-1 bg-baieco-accent mx-auto mt-6 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card gradient-card rounded-2xl p-8 shadow-medium hover:shadow-large border border-gray-100 animate-on-scroll">
                    <div class="w-20 h-20 bg-gradient-to-br from-baieco-secondary to-baieco-primary rounded-2xl flex items-center justify-center mb-6 animate-float mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-baieco-primary mb-4 text-center">Panel de Administración</h3>
                    <p class="text-gray-600 mb-6 text-center leading-relaxed">Dashboard completo para monitorear todas las órdenes, técnicos, inventario y métricas de rendimiento en tiempo real.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Vista global de órdenes
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Reportes y analíticas
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Gestión de inventario
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card gradient-card rounded-2xl p-8 shadow-medium hover:shadow-large border border-gray-100 animate-on-scroll animation-delay-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-baieco-success to-green-600 rounded-2xl flex items-center justify-center mb-6 animate-float animation-delay-500 mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-baieco-primary mb-4 text-center">Portal del Cliente</h3>
                    <p class="text-gray-600 mb-6 text-center leading-relaxed">Interfaz intuitiva para que tus clientes consulten el estado de sus equipos, reciban notificaciones y gestionen su historial.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Seguimiento en tiempo real
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Notificaciones automáticas
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Historial completo
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card gradient-card rounded-2xl p-8 shadow-medium hover:shadow-large border border-gray-100 animate-on-scroll animation-delay-200">
                    <div class="w-20 h-20 bg-gradient-to-br from-baieco-accent to-red-600 rounded-2xl flex items-center justify-center mb-6 animate-float animation-delay-1000 mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-baieco-primary mb-4 text-center">Reportes Avanzados</h3>
                    <p class="text-gray-600 mb-6 text-center leading-relaxed">Analítica completa con métricas de rendimiento, tiempos de reparación y análisis financiero para optimizar tu negocio.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Métricas de rendimiento
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Análisis financiero
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Exportación de datos
                        </li>
                    </ul>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card gradient-card rounded-2xl p-8 shadow-medium hover:shadow-large border border-gray-100 animate-on-scroll animation-delay-300">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center mb-6 animate-float animation-delay-500 mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-baieco-primary mb-4 text-center">Personalización Total</h3>
                    <p class="text-gray-600 mb-6 text-center leading-relaxed">Adapta el sistema a las necesidades específicas de tu taller con configuraciones personalizables y workflows flexibles.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Flujos de trabajo custom
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Campos personalizados
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Branding personalizado
                        </li>
                    </ul>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card gradient-card rounded-2xl p-8 shadow-medium hover:shadow-large border border-gray-100 animate-on-scroll animation-delay-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center mb-6 animate-float animation-delay-1000 mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-baieco-primary mb-4 text-center">Gestión de Inventario</h3>
                    <p class="text-gray-600 mb-6 text-center leading-relaxed">Control completo de repuestos, herramientas y equipos con alertas automáticas de stock bajo y gestión de proveedores.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Control de stock
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Alertas automáticas
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Gestión proveedores
                        </li>
                    </ul>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card gradient-card rounded-2xl p-8 shadow-medium hover:shadow-large border border-gray-100 animate-on-scroll animation-delay-200">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-2xl flex items-center justify-center mb-6 animate-float animation-delay-500 mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-baieco-primary mb-4 text-center">App Móvil</h3>
                    <p class="text-gray-600 mb-6 text-center leading-relaxed">Aplicación móvil para técnicos y clientes que permite gestionar órdenes, comunicarse y recibir notificaciones desde cualquier lugar.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            iOS y Android
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Sincronización en tiempo real
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-baieco-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Notificaciones push
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Lookup Section -->
    <section id="consultar" class="py-24 bg-gradient-to-br from-gray-50 to-blue-50 relative">
        <div class="absolute inset-0 bg-white bg-opacity-70"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-baieco-primary mb-6 animate-on-scroll">
                    Consulta tu Orden de Servicio
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed animate-on-scroll">
                    Si eres cliente de un taller que usa Baieco, ingresa tu código de orden para ver el estado de reparación de tu equipo en tiempo real.
                </p>
                <div class="w-24 h-1 bg-baieco-accent mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="bg-white rounded-3xl p-8 shadow-large border border-gray-100 animate-on-scroll">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-baieco-secondary to-baieco-primary rounded-2xl flex items-center justify-center mx-auto mb-4 animate-pulse-glow">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-baieco-primary mb-2">Buscar Orden</h3>
                            <p class="text-gray-600">Ingresa el código de tu orden de servicio para consultar su estado</p>
                        </div>
                        
                        <form id="order-lookup-form" class="space-y-6">
                            <div>
                                <label for="order-code" class="block text-sm font-semibold text-baieco-primary mb-3">
                                    Código de Orden de Servicio
                                </label>
                                <input type="text" id="order-code" name="order_code" 
                                       class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-baieco-secondary focus:ring-opacity-20 focus:border-baieco-secondary transition-all duration-300 text-lg focus-ring"
                                       placeholder="Ej: BA-2025-001"
                                       maxlength="11">
                                <p class="text-sm text-gray-500 mt-2">Formato: BA-YYYY-NNN</p>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-baieco-secondary to-baieco-primary hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Buscar Orden
                            </button>
                        </form>
                        
                        <!-- Resultado de búsqueda -->
                        <div id="order-result" class="mt-8 hidden"></div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2 animate-on-scroll">
                    <div class="space-y-6">
                        <h3 class="text-3xl font-bold text-baieco-primary mb-8">Estados de las Órdenes</h3>
                        
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-xl shadow-medium border-l-4 border-yellow-400">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Recibido</h4>
                                <p class="text-sm text-gray-600">Tu equipo ha sido recibido y registrado en el sistema</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-xl shadow-medium border-l-4 border-blue-400">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">En Diagnóstico</h4>
                                <p class="text-sm text-gray-600">Los técnicos están evaluando el problema de tu equipo</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-xl shadow-medium border-l-4 border-orange-400">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">En Reparación</h4>
                                <p class="text-sm text-gray-600">Tu equipo está siendo reparado por nuestros especialistas</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-xl shadow-medium border-l-4 border-green-400">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Completado</h4>
                                <p class="text-sm text-gray-600">Reparación finalizada, listo para entrega</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-24 bg-baieco-primary relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-on-scroll">
                    ¿Listo para Revolucionar tu Taller?
                </h2>
                <p class="text-xl text-white opacity-90 max-w-3xl mx-auto leading-relaxed animate-on-scroll">
                    Únete a los cientos de talleres que ya confían en Baieco para gestionar sus órdenes de servicio. 
                    Solicita una demostración personalizada y descubre cómo podemos ayudarte.
                </p>
                <div class="w-24 h-1 bg-baieco-accent mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="text-center animate-on-scroll">
                    <div class="w-20 h-20 bg-gradient-to-br from-baieco-secondary to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 animate-bounce-gentle">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Teléfono</h3>
                    <p class="text-xl text-white opacity-90">+56 9 1234 5678</p>
                    <p class="text-white opacity-70 mt-2">Lunes a Viernes: 9:00 - 18:00</p>
                </div>

                <div class="text-center animate-on-scroll animation-delay-100">
                    <div class="w-20 h-20 bg-gradient-to-br from-baieco-success to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 animate-bounce-gentle animation-delay-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Email</h3>
                    <p class="text-xl text-white opacity-90">ventas@baieco.cl</p>
                    <p class="text-white opacity-70 mt-2">Respuesta en 24 horas</p>
                </div>

                <div class="text-center animate-on-scroll animation-delay-200">
                    <div class="w-20 h-20 bg-gradient-to-br from-baieco-accent to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6 animate-bounce-gentle animation-delay-1000">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Oficinas</h3>
                    <p class="text-xl text-white opacity-90">Santiago, Chile</p>
                    <p class="text-white opacity-70 mt-2">Atención presencial con cita</p>
                </div>
            </div>
            
            <div class="max-w-2xl mx-auto">
                <div class="glass-effect rounded-3xl p-8 shadow-large animate-on-scroll">
                    <h3 class="text-2xl font-bold text-white mb-6 text-center">Solicita una Demostración</h3>
                    <p class="text-white opacity-80 text-center mb-6">
                        Completa el formulario y un especialista te contactará para mostrarte cómo Baieco puede transformar tu taller.
                    </p>
                    <div class="text-center">
                        <button data-action="open-demo" class="bg-baieco-accent hover:bg-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Solicitar Demo Gratuita
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-baieco-dark text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-baieco-accent rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold">Baieco</span>
                    </div>
                    <p class="text-gray-300 mb-6 max-w-md leading-relaxed">
                        Software líder en gestión de órdenes de servicio para talleres de reparación electrónica. 
                        Automatiza tu negocio y mejora la experiencia de tus clientes.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-baieco-secondary rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-baieco-secondary rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-baieco-secondary rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-6">Producto</h4>
                    <ul class="space-y-3">
                        <li><a href="#caracteristicas" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Características</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Precios</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Integraciones</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-6">Soporte</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Centro de Ayuda</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Documentación</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Capacitación</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300">Contacto</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-300 mb-4 md:mb-0">&copy; 2025 Baieco. Todos los derechos reservados.</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300 text-sm">Términos de Servicio</a>
                        <a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300 text-sm">Política de Privacidad</a>
                        <a href="#" class="text-gray-300 hover:text-baieco-accent transition-colors duration-300 text-sm">Política de Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Demo Modal -->
    <div id="demo-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-large animate-scale-in">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-baieco-secondary to-baieco-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-baieco-primary mb-2">Solicitar Demostración</h3>
                <p class="text-gray-600">Completa tus datos y te contactaremos para agendar una demo personalizada</p>
            </div>
            
            <form id="demo-form" class="space-y-4">
                <div>
                    <input type="text" name="name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-baieco-secondary focus:border-transparent transition-all duration-300" 
                           placeholder="Nombre completo">
                </div>
                <div>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-baieco-secondary focus:border-transparent transition-all duration-300" 
                           placeholder="Email">
                </div>
                <div>
                    <input type="tel" name="phone" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-baieco-secondary focus:border-transparent transition-all duration-300" 
                           placeholder="Teléfono">
                </div>
                <div>
                    <input type="text" name="company" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-baieco-secondary focus:border-transparent transition-all duration-300" 
                           placeholder="Nombre del taller">
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" id="close-demo" 
                            class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:bg-gray-300">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-baieco-primary hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Solicitar Demo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div id="success-alert" class="fixed top-20 right-4 bg-baieco-success text-white px-6 py-4 rounded-xl shadow-large z-50 animate-slide-in-right">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</body>
</html>
