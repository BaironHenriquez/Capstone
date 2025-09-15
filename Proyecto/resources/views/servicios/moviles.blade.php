<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios Móviles - TechService Pro</title>
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
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Servicios Móviles</h1>
                <p class="text-xl md:text-2xl mb-8">Reparación especializada para smartphones y tablets</p>
                <a href="{{ route('servicios.crear') }}" class="bg-tech-pure-white text-tech-dark-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    Diagnóstico Express
                </a>
            </div>
        </div>
    </section>

    <!-- Device Support -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Dispositivos que Reparamos</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <div class="text-center animate-fade-in" style="animation-delay: 0.1s">
                    <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="text-tech-electric-blue mb-3">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-tech-dark-blue text-sm">iPhone</h3>
                    </div>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.2s">
                    <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="text-tech-electric-blue mb-3">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-tech-dark-blue text-sm">Samsung</h3>
                    </div>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.3s">
                    <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="text-tech-electric-blue mb-3">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-tech-dark-blue text-sm">Huawei</h3>
                    </div>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.4s">
                    <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="text-tech-electric-blue mb-3">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-tech-dark-blue text-sm">Xiaomi</h3>
                    </div>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.5s">
                    <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="text-tech-electric-blue mb-3">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-tech-dark-blue text-sm">iPad</h3>
                    </div>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.6s">
                    <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="text-tech-electric-blue mb-3">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-tech-dark-blue text-sm">Tablets</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-16 bg-tech-pure-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Nuestros Servicios</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1: Screen Repair -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.1s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Cambio de Pantalla</h3>
                    <p class="text-gray-600 mb-4">Reemplazo de pantallas rotas o dañadas con repuestos originales o compatibles de alta calidad.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Pantallas originales y compatibles</li>
                        <li>• Garantía de 3 meses</li>
                        <li>• Servicio express (1-2 horas)</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $35.000</div>
                </div>

                <!-- Service 2: Battery Replacement -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Cambio de Batería</h3>
                    <p class="text-gray-600 mb-4">Reemplazo de baterías agotadas o hinchadas para recuperar la autonomía de tu dispositivo.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Baterías de alta capacidad</li>
                        <li>• Prueba de rendimiento incluida</li>
                        <li>• Instalación en 30 minutos</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $25.000</div>
                </div>

                <!-- Service 3: Charging Port -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Reparación Puerto de Carga</h3>
                    <p class="text-gray-600 mb-4">Solución de problemas de carga, puertos sueltos o dañados que impiden la carga correcta.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Limpieza de puerto</li>
                        <li>• Reemplazo si es necesario</li>
                        <li>• Prueba de funcionalidad</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $20.000</div>
                </div>

                <!-- Service 4: Water Damage -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Daño por Líquidos</h3>
                    <p class="text-gray-600 mb-4">Tratamiento especializado para dispositivos con daño por agua, refrescos u otros líquidos.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Proceso de secado profesional</li>
                        <li>• Limpieza ultrasónica</li>
                        <li>• Evaluación sin costo</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $40.000</div>
                </div>

                <!-- Service 5: Camera Repair -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.5s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Reparación de Cámara</h3>
                    <p class="text-gray-600 mb-4">Solución de problemas con cámaras frontales y traseras, lentes rayados o sensores dañados.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Cámara frontal y trasera</li>
                        <li>• Reemplazo de lentes</li>
                        <li>• Calibración incluida</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $30.000</div>
                </div>

                <!-- Service 6: Speaker/Microphone -->
                <div class="bg-tech-light-gray rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.6s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Audio y Micrófono</h3>
                    <p class="text-gray-600 mb-4">Reparación de altavoces, micrófonos y problemas de audio en llamadas o reproducción.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Altavoz principal y auricular</li>
                        <li>• Micrófono de llamadas</li>
                        <li>• Prueba de calidad de audio</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $25.000</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Express Service -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-tech-warning-orange to-tech-success-green rounded-lg p-8 text-tech-pure-white text-center animate-fade-in">
                <h2 class="text-3xl font-bold mb-4">Servicio Express</h2>
                <p class="text-xl mb-6">Reparaciones básicas en menos de 2 horas</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Cambio de Pantalla</h3>
                        <p class="text-sm">Modelos populares disponibles</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Cambio de Batería</h3>
                        <p class="text-sm">Instalación inmediata</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Limpieza de Puerto</h3>
                        <p class="text-sm">Solución rápida</p>
                    </div>
                </div>
                <a href="{{ route('servicios.crear') }}" class="bg-tech-pure-white text-tech-dark-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    Reservar Express
                </a>
            </div>
        </div>
    </section>

    <!-- Pricing Table -->
    <section class="py-16 bg-tech-pure-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Tarifas por Modelo</h2>
            
            <div class="bg-tech-light-gray rounded-lg shadow-lg overflow-hidden animate-fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-tech-dark-blue text-tech-pure-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Modelo</th>
                                <th class="px-6 py-4 text-left font-semibold">Pantalla</th>
                                <th class="px-6 py-4 text-left font-semibold">Batería</th>
                                <th class="px-6 py-4 text-left font-semibold">Puerto Carga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-tech-pure-white transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">iPhone 13/14</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$85.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$35.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$45.000</td>
                            </tr>
                            <tr class="hover:bg-tech-pure-white transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">iPhone 11/12</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$70.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$30.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$40.000</td>
                            </tr>
                            <tr class="hover:bg-tech-pure-white transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Samsung Galaxy S22/S23</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$75.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$35.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$40.000</td>
                            </tr>
                            <tr class="hover:bg-tech-pure-white transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Samsung Galaxy A50/A70</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$50.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$25.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$30.000</td>
                            </tr>
                            <tr class="hover:bg-tech-pure-white transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Xiaomi/Huawei</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$45.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$25.000</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$25.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6 text-center text-gray-600">
                <p class="text-sm">* Precios sujetos a disponibilidad de repuestos. Garantía de 3 meses en todas las reparaciones.</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Preguntas Frecuentes</h2>
            
            <div class="space-y-6">
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.1s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Cuánto tiempo toma una reparación?</h3>
                    <p class="text-gray-600">Las reparaciones básicas (pantalla, batería) toman entre 1-2 horas. Daños complejos pueden requerir 1-3 días.</p>
                </div>
                
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.2s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Ofrecen garantía?</h3>
                    <p class="text-gray-600">Sí, todas nuestras reparaciones incluyen garantía de 3 meses en mano de obra y repuestos.</p>
                </div>
                
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.3s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Qué necesito traer?</h3>
                    <p class="text-gray-600">Solo tu dispositivo y cargador. Nosotros nos encargamos de hacer una copia de seguridad si es necesario.</p>
                </div>
                
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 animate-fade-in" style="animation-delay: 0.4s">
                    <h3 class="font-semibold text-tech-dark-blue mb-2">¿Pueden recuperar mis datos?</h3>
                    <p class="text-gray-600">En la mayoría de los casos sí. Ofrecemos servicio de respaldo y recuperación de datos importantes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-tech-electric-blue to-tech-dark-blue text-tech-pure-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 animate-fade-in">¿Tu móvil necesita reparación?</h2>
            <p class="text-xl mb-8 animate-slide-up">Diagnóstico gratuito y reparación el mismo día</p>
            <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center animate-scale-in">
                <a href="{{ route('servicios.crear') }}" class="bg-tech-pure-white text-tech-dark-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 inline-block">
                    Solicitar Servicio
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
            <p class="mt-2 text-gray-300">Reparaciones móviles especializadas desde 2020</p>
        </div>
    </footer>

</body>
</html>