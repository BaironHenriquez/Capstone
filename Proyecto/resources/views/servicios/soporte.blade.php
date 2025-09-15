<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Técnico - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-tech-light-gray font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-tech-dark-blue shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        <span class="text-tech-pure-white text-2xl font-bold">TechService Pro</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        Inicio
                    </a>
                    <a href="{{ route('servicios.crear') }}" class="bg-tech-electric-blue hover:bg-blue-600 text-tech-pure-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        Solicitar Servicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-tech-dark-blue to-tech-electric-blue text-tech-pure-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Soporte Técnico</h1>
                <p class="text-xl md:text-2xl mb-8">Asistencia remota y consultoría especializada</p>
                <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
                    <a href="{{ route('servicios.crear') }}" class="bg-tech-pure-white text-tech-dark-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 inline-block">
                        Solicitar Consultoría
                    </a>
                    <a href="tel:+56912345678" class="border-2 border-tech-pure-white text-tech-pure-white px-8 py-3 rounded-lg font-semibold hover:bg-tech-pure-white hover:text-tech-dark-blue transition-all duration-300 inline-block">
                        Soporte Inmediato
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Types -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Tipos de Soporte</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Remote Support -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-8 text-center transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.1s">
                    <div class="text-tech-electric-blue mb-6">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-tech-dark-blue mb-4">Soporte Remoto</h3>
                    <p class="text-gray-600 mb-6">Conexión directa a tu equipo para resolver problemas sin salir de casa</p>
                    <ul class="text-left text-gray-600 space-y-2 mb-6">
                        <li>• Solución inmediata de problemas</li>
                        <li>• Instalación de software</li>
                        <li>• Configuración de sistemas</li>
                        <li>• Eliminación de virus</li>
                    </ul>
                    <div class="text-tech-success-green text-xl font-bold">$15.000/hora</div>
                </div>

                <!-- Phone Support -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-8 text-center transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-tech-electric-blue mb-6">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-tech-dark-blue mb-4">Soporte Telefónico</h3>
                    <p class="text-gray-600 mb-6">Asistencia telefónica para resolver dudas y problemas básicos</p>
                    <ul class="text-left text-gray-600 space-y-2 mb-6">
                        <li>• Guía paso a paso</li>
                        <li>• Diagnóstico telefónico</li>
                        <li>• Configuración básica</li>
                        <li>• Consultas técnicas</li>
                    </ul>
                    <div class="text-tech-success-green text-xl font-bold">$8.000/consulta</div>
                </div>

                <!-- On-site Support -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-8 text-center transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="text-tech-electric-blue mb-6">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-tech-dark-blue mb-4">Soporte a Domicilio</h3>
                    <p class="text-gray-600 mb-6">Técnico especializado se traslada a tu ubicación</p>
                    <ul class="text-left text-gray-600 space-y-2 mb-6">
                        <li>• Instalación de equipos</li>
                        <li>• Configuración de redes</li>
                        <li>• Mantenimiento preventivo</li>
                        <li>• Capacitación de usuarios</li>
                    </ul>
                    <div class="text-tech-success-green text-xl font-bold">$25.000 + traslado</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-16 bg-tech-pure-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Servicios Especializados</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Network Setup -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.1s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Configuración de Redes</h3>
                    <p class="text-gray-600 mb-4">Instalación y configuración de redes WiFi, cableado estructurado y sistemas de seguridad.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Instalación de routers y access points</li>
                        <li>• Configuración de seguridad WPA3</li>
                        <li>• Optimización de señal WiFi</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $40.000</div>
                </div>

                <!-- Software Installation -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Instalación de Software</h3>
                    <p class="text-gray-600 mb-4">Instalación y configuración de programas especializados, sistemas operativos y aplicaciones.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Software de oficina y diseño</li>
                        <li>• Sistemas operativos</li>
                        <li>• Programas especializados</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $20.000</div>
                </div>

                <!-- Data Backup -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Respaldo de Datos</h3>
                    <p class="text-gray-600 mb-4">Configuración de sistemas de respaldo automático y migración de datos importantes.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Respaldo automático en la nube</li>
                        <li>• Migración de datos</li>
                        <li>• Sincronización entre dispositivos</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $25.000</div>
                </div>

                <!-- Security -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Seguridad Informática</h3>
                    <p class="text-gray-600 mb-4">Implementación de medidas de seguridad, antivirus empresarial y protección de datos.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Instalación de antivirus profesional</li>
                        <li>• Configuración de firewall</li>
                        <li>• Auditoría de seguridad</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $35.000</div>
                </div>

                <!-- Training -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.5s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Capacitación de Usuarios</h3>
                    <p class="text-gray-600 mb-4">Entrenamiento personalizado en el uso de software, sistemas y buenas prácticas informáticas.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Capacitación en Office</li>
                        <li>• Uso seguro de internet</li>
                        <li>• Manejo de software específico</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">$30.000/sesión</div>
                </div>

                <!-- Maintenance -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.6s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Mantenimiento Preventivo</h3>
                    <p class="text-gray-600 mb-4">Planes de mantenimiento regular para empresas y usuarios con múltiples equipos.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Visitas programadas mensuales</li>
                        <li>• Limpieza y optimización</li>
                        <li>• Reportes de estado</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Planes desde $50.000/mes</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Remote Support Process -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Cómo Funciona el Soporte Remoto</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center animate-fade-in" style="animation-delay: 0.1s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Contacta</h3>
                    <p class="text-gray-600 text-sm">Llama o solicita soporte online</p>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.2s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Autoriza</h3>
                    <p class="text-gray-600 text-sm">Permite acceso remoto seguro</p>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.3s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Observa</h3>
                    <p class="text-gray-600 text-sm">Ve cómo resolvemos el problema</p>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.4s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Listo</h3>
                    <p class="text-gray-600 text-sm">Problema resuelto sin salir de casa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Support Plans -->
    <section class="py-16 bg-tech-pure-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Planes de Soporte</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Basic Plan -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-8 animate-fade-in" style="animation-delay: 0.1s">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-tech-dark-blue mb-2">Plan Básico</h3>
                        <div class="text-3xl font-bold text-tech-success-green">$20.000<span class="text-lg font-normal text-gray-600">/mes</span></div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            2 horas de soporte remoto
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Soporte telefónico ilimitado
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Respaldo básico de datos
                        </li>
                    </ul>
                    <button class="w-full bg-tech-electric-blue text-tech-pure-white py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors duration-300">
                        Contratar Plan
                    </button>
                </div>

                <!-- Professional Plan -->
                <div class="bg-tech-electric-blue rounded-lg shadow-lg p-8 transform scale-105 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-center mb-6">
                        <div class="bg-tech-warning-orange text-tech-pure-white px-3 py-1 rounded-full text-sm font-semibold mb-2">Más Popular</div>
                        <h3 class="text-2xl font-bold text-tech-pure-white mb-2">Plan Profesional</h3>
                        <div class="text-3xl font-bold text-tech-pure-white">$45.000<span class="text-lg font-normal text-gray-200">/mes</span></div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-tech-pure-white">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            5 horas de soporte remoto
                        </li>
                        <li class="flex items-center text-tech-pure-white">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Soporte 24/7 prioritario
                        </li>
                        <li class="flex items-center text-tech-pure-white">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mantenimiento preventivo
                        </li>
                        <li class="flex items-center text-tech-pure-white">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Respaldo automático en la nube
                        </li>
                    </ul>
                    <button class="w-full bg-tech-pure-white text-tech-electric-blue py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300">
                        Contratar Plan
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-8 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-tech-dark-blue mb-2">Plan Empresarial</h3>
                        <div class="text-3xl font-bold text-tech-success-green">$100.000<span class="text-lg font-normal text-gray-600">/mes</span></div>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Soporte ilimitado
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Técnico dedicado
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Visitas a domicilio incluidas
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-tech-success-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Consultoría estratégica
                        </li>
                    </ul>
                    <button class="w-full bg-tech-electric-blue text-tech-pure-white py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors duration-300">
                        Contratar Plan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Preguntas Frecuentes</h2>
            
            <div class="space-y-6">
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.1s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Es seguro el acceso remoto?</h3>
                    <p class="text-gray-600">Sí, utilizamos conexiones encriptadas de extremo a extremo. Solo accedemos con tu autorización y puedes ver todo lo que hacemos.</p>
                </div>
                
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.2s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Qué horarios de soporte manejan?</h3>
                    <p class="text-gray-600">Soporte básico de lunes a viernes 9:00-18:00. Planes profesionales y empresariales incluyen soporte 24/7.</p>
                </div>
                
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.3s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Puedo cancelar mi plan en cualquier momento?</h3>
                    <p class="text-gray-600">Sí, todos nuestros planes son sin permanencia. Puedes cancelar con 30 días de anticipación.</p>
                </div>
                
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.4s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Qué tipo de problemas pueden resolver remotamente?</h3>
                    <p class="text-gray-600">Problemas de software, configuración de sistemas, instalación de programas, eliminación de virus, optimización de rendimiento y más.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-tech-electric-blue to-tech-dark-blue text-tech-pure-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 animate-fade-in">¿Necesitas soporte técnico ahora?</h2>
            <p class="text-xl mb-8 animate-slide-up">Nuestros expertos están listos para ayudarte remotamente</p>
            <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center animate-scale-in">
                <a href="{{ route('servicios.crear') }}" class="bg-tech-pure-white text-tech-dark-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 inline-block">
                    Solicitar Soporte
                </a>
                <a href="tel:+56912345678" class="border-2 border-tech-pure-white text-tech-pure-white px-8 py-3 rounded-lg font-semibold hover:bg-tech-pure-white hover:text-tech-dark-blue transition-all duration-300 inline-block">
                    Llamar Ahora
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-tech-dark-blue text-tech-pure-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 TechService Pro. Todos los derechos reservados.</p>
            <p class="mt-2 text-gray-300">Soporte técnico especializado 24/7</p>
        </div>
    </footer>

</body>
</html>