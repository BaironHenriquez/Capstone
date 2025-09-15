<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios de Computadoras - TechService Pro</title>
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
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Servicios de Computadoras</h1>
                <p class="text-xl md:text-2xl mb-8">Reparación y mantenimiento especializado para todos tus equipos</p>
                <a href="{{ route('servicios.crear') }}" class="bg-tech-pure-white text-tech-dark-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    Solicitar Diagnóstico Gratuito
                </a>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Nuestros Servicios</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1: Hardware Diagnostics -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.1s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Diagnóstico de Hardware</h3>
                    <p class="text-gray-600 mb-4">Identificación completa de problemas en componentes: motherboard, memoria RAM, disco duro, fuente de poder y más.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Diagnóstico gratuito (30 min)</li>
                        <li>• Reporte detallado del estado</li>
                        <li>• Presupuesto sin compromiso</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $25.000</div>
                </div>

                <!-- Service 2: Software Repair -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Reparación de Software</h3>
                    <p class="text-gray-600 mb-4">Solución de problemas del sistema operativo, eliminación de virus, optimización y reinstalación de programas.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Limpieza de virus y malware</li>
                        <li>• Optimización del sistema</li>
                        <li>• Instalación de programas</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $20.000</div>
                </div>

                <!-- Service 3: Component Replacement -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.3s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Reemplazo de Componentes</h3>
                    <p class="text-gray-600 mb-4">Instalación y reemplazo de piezas: memoria RAM, discos duros SSD, tarjetas gráficas, ventiladores y más.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Componentes originales</li>
                        <li>• Garantía de 6 meses</li>
                        <li>• Instalación profesional</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Precio según componente</div>
                </div>

                <!-- Service 4: Data Recovery -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14l-9 10L5 7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Recuperación de Datos</h3>
                    <p class="text-gray-600 mb-4">Rescate de archivos importantes de discos duros dañados, memorias USB y otros dispositivos de almacenamiento.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Evaluación sin costo</li>
                        <li>• Recuperación de documentos</li>
                        <li>• Fotos y videos personales</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Desde $50.000</div>
                </div>

                <!-- Service 5: Maintenance -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.5s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Mantenimiento Preventivo</h3>
                    <p class="text-gray-600 mb-4">Limpieza interna, actualización de drivers, optimización del sistema y revisión general del equipo.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Limpieza de polvo y suciedad</li>
                        <li>• Actualización de software</li>
                        <li>• Revisión de temperaturas</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">$35.000</div>
                </div>

                <!-- Service 6: Upgrades -->
                <div class="bg-tech-pure-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-all duration-300 animate-fade-in" style="animation-delay: 0.6s">
                    <div class="text-tech-electric-blue mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-3">Mejoras y Actualizaciones</h3>
                    <p class="text-gray-600 mb-4">Upgrade de memoria RAM, instalación de discos SSD, mejora de tarjetas gráficas para mejor rendimiento.</p>
                    <ul class="text-sm text-gray-600 space-y-1 mb-4">
                        <li>• Análisis de compatibilidad</li>
                        <li>• Recomendaciones personalizadas</li>
                        <li>• Instalación profesional</li>
                    </ul>
                    <div class="text-tech-success-green font-semibold">Cotización personalizada</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="bg-tech-pure-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Nuestro Proceso</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center animate-fade-in" style="animation-delay: 0.1s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Diagnóstico</h3>
                    <p class="text-gray-600 text-sm">Evaluación completa y gratuita de tu equipo</p>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.2s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Presupuesto</h3>
                    <p class="text-gray-600 text-sm">Cotización detallada sin compromiso</p>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.3s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Reparación</h3>
                    <p class="text-gray-600 text-sm">Trabajo especializado con componentes de calidad</p>
                </div>
                
                <div class="text-center animate-fade-in" style="animation-delay: 0.4s">
                    <div class="bg-tech-electric-blue text-tech-pure-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                    <h3 class="font-semibold text-tech-dark-blue mb-2">Entrega</h3>
                    <p class="text-gray-600 text-sm">Equipo funcionando con garantía incluida</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Table -->
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-tech-dark-blue text-center mb-12 animate-slide-up">Tarifas de Servicio</h2>
            
            <div class="bg-tech-pure-white rounded-lg shadow-lg overflow-hidden animate-fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-tech-dark-blue text-tech-pure-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Servicio</th>
                                <th class="px-6 py-4 text-left font-semibold">Tiempo Estimado</th>
                                <th class="px-6 py-4 text-left font-semibold">Precio</th>
                                <th class="px-6 py-4 text-left font-semibold">Garantía</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-tech-light-gray transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Diagnóstico Básico</td>
                                <td class="px-6 py-4 text-gray-600">30 - 60 min</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">Gratuito</td>
                                <td class="px-6 py-4 text-gray-600">-</td>
                            </tr>
                            <tr class="hover:bg-tech-light-gray transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Limpieza de Virus</td>
                                <td class="px-6 py-4 text-gray-600">2 - 4 horas</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$25.000</td>
                                <td class="px-6 py-4 text-gray-600">30 días</td>
                            </tr>
                            <tr class="hover:bg-tech-light-gray transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Formateo + Instalación SO</td>
                                <td class="px-6 py-4 text-gray-600">3 - 5 horas</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$40.000</td>
                                <td class="px-6 py-4 text-gray-600">60 días</td>
                            </tr>
                            <tr class="hover:bg-tech-light-gray transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Reemplazo RAM</td>
                                <td class="px-6 py-4 text-gray-600">30 min</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$15.000 + componente</td>
                                <td class="px-6 py-4 text-gray-600">6 meses</td>
                            </tr>
                            <tr class="hover:bg-tech-light-gray transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Instalación SSD</td>
                                <td class="px-6 py-4 text-gray-600">1 - 2 horas</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$30.000 + componente</td>
                                <td class="px-6 py-4 text-gray-600">6 meses</td>
                            </tr>
                            <tr class="hover:bg-tech-light-gray transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-tech-dark-blue">Recuperación de Datos</td>
                                <td class="px-6 py-4 text-gray-600">1 - 3 días</td>
                                <td class="px-6 py-4 text-tech-success-green font-semibold">$50.000 - $150.000</td>
                                <td class="px-6 py-4 text-gray-600">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-tech-electric-blue to-tech-dark-blue text-tech-pure-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 animate-fade-in">¿Tu computadora necesita atención?</h2>
            <p class="text-xl mb-8 animate-slide-up">No esperes más. Nuestros técnicos expertos están listos para ayudarte.</p>
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
            <p class="mt-2 text-gray-300">Servicios técnicos especializados desde 2020</p>
        </div>
    </footer>

</body>
</html>