<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripción Requerida - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-orange-50 via-red-50 to-pink-50 min-h-screen font-inter">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            
            <!-- Warning Icon -->
            <div class="text-center mb-12">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-orange-100 mb-6">
                    <svg class="h-12 w-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Suscripción Requerida
                </h1>
                <p class="text-xl text-gray-600">
                    Tu período de prueba ha expirado. Selecciona un plan para continuar usando TechService Pro.
                </p>
            </div>

            <!-- Subscription Required Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-6 text-white">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <h2 class="text-xl font-bold">Acceso Restringido</h2>
                            <p class="text-orange-100">Suscripción necesaria para continuar</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    
                    <!-- Trial Status -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Estado de tu Cuenta</h3>
                        
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-orange-800">Período de Prueba Expirado</h4>
                                    <p class="text-sm text-orange-700 mt-1">
                                        Tu período de prueba gratuito de 7 días ha llegado a su fin. 
                                        Para seguir disfrutando de todas las funcionalidades de TechService Pro, 
                                        necesitas activar una suscripción.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- What You're Missing -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Lo que te estás perdiendo:</h3>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Gestión de Órdenes</h4>
                                    <p class="text-sm text-gray-600">Crear y administrar órdenes de servicio</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Gestión de Clientes</h4>
                                    <p class="text-sm text-gray-600">Base de datos completa de clientes</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Reportes Avanzados</h4>
                                    <p class="text-sm text-gray-600">Analytics y métricas de rendimiento</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 110 19.5 9.75 9.75 0 010-19.5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Soporte Prioritario</h4>
                                    <p class="text-sm text-gray-600">Atención 24/7 y actualizaciones</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <a href="{{ route('subscription.plans') }}" 
                           class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-bold py-4 px-6 rounded-xl text-center transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Ver Planes
                            </span>
                        </a>
                        
                        <a href="{{ route('home') }}" 
                           class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-medium py-4 px-6 rounded-xl text-center transition-colors">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Volver al Inicio
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pricing Preview -->
            <div class="mt-8 grid md:grid-cols-2 gap-4">
                
                <!-- Básico -->
                <div class="bg-white rounded-lg p-6 shadow-md border border-gray-200">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Plan Básico</h3>
                        <div class="text-3xl font-bold text-gray-900 mb-1">$29</div>
                        <p class="text-sm text-gray-600 mb-4">USD/mes</p>
                        <p class="text-sm text-gray-600">
                            Perfecto para talleres pequeños con hasta 50 órdenes mensuales
                        </p>
                    </div>
                </div>

                <!-- Profesional -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 shadow-md border border-blue-200">
                    <div class="text-center">
                        <div class="inline-block bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded-full mb-2">
                            MÁS POPULAR
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Plan Profesional</h3>
                        <div class="text-3xl font-bold text-blue-600 mb-1">$59</div>
                        <p class="text-sm text-gray-600 mb-4">USD/mes</p>
                        <p class="text-sm text-gray-600">
                            Para talleres en crecimiento con órdenes ilimitadas y reportes avanzados
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    ¿Tienes preguntas sobre los planes? 
                    <a href="mailto:soporte@techservicepro.com" class="text-orange-600 hover:underline">
                        Contacta nuestro equipo de ventas
                    </a>
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Garantía de devolución de dinero de 30 días • Cancela cuando quieras
                </p>
            </div>
        </div>
    </div>
</body>
</html>