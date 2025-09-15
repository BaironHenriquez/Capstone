<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Servicio - TechService Pro</title>
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
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        ← Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-tech-pure-white rounded-lg shadow-lg p-8 animate-fade-in">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-tech-dark-blue mb-4">Solicitar Servicio Técnico</h1>
                <p class="text-lg text-gray-600">Complete el formulario para solicitar nuestro servicio especializado</p>
            </div>

            <form action="{{ route('servicios.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Información del Cliente -->
                <div class="bg-tech-light-gray rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-tech-dark-blue mb-4">Información del Cliente</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="animate-slide-up">
                            <label for="nombre" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Nombre Completo *
                            </label>
                            <input type="text" id="nombre" name="nombre" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 0.1s;">
                            <label for="telefono" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Teléfono *
                            </label>
                            <input type="tel" id="telefono" name="telefono" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 0.2s;">
                            <label for="email" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Email *
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 0.3s;">
                            <label for="direccion" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Dirección
                            </label>
                            <input type="text" id="direccion" name="direccion"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                    </div>
                </div>

                <!-- Información del Equipo -->
                <div class="bg-tech-light-gray rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-tech-dark-blue mb-4">Información del Equipo</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="animate-slide-up" style="animation-delay: 0.4s;">
                            <label for="tipo_equipo" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Tipo de Equipo *
                            </label>
                            <select id="tipo_equipo" name="tipo_equipo" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                                <option value="">Seleccionar tipo</option>
                                <option value="computadora_escritorio">Computadora de Escritorio</option>
                                <option value="laptop">Laptop</option>
                                <option value="smartphone">Smartphone</option>
                                <option value="tablet">Tablet</option>
                                <option value="impresora">Impresora</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 0.5s;">
                            <label for="marca" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Marca
                            </label>
                            <input type="text" id="marca" name="marca"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 0.6s;">
                            <label for="modelo" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Modelo
                            </label>
                            <input type="text" id="modelo" name="modelo"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                        
                        <div class="animate-slide-up" style="animation-delay: 0.7s;">
                            <label for="numero_serie" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Número de Serie
                            </label>
                            <input type="text" id="numero_serie" name="numero_serie"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                        </div>
                    </div>
                </div>

                <!-- Descripción del Problema -->
                <div class="bg-tech-light-gray rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-tech-dark-blue mb-4">Descripción del Problema</h2>
                    <div class="animate-slide-up" style="animation-delay: 0.8s;">
                        <label for="problema" class="block text-sm font-medium text-tech-dark-blue mb-2">
                            Describe el problema en detalle *
                        </label>
                        <textarea id="problema" name="problema" rows="5" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300"
                                  placeholder="Explica qué problema presenta tu equipo, cuándo comenzó, si hay mensajes de error, etc."></textarea>
                    </div>
                    
                    <div class="mt-4 animate-slide-up" style="animation-delay: 0.9s;">
                        <label for="urgencia" class="block text-sm font-medium text-tech-dark-blue mb-2">
                            Nivel de Urgencia
                        </label>
                        <select id="urgencia" name="urgencia"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300">
                            <option value="baja">Baja - No es urgente</option>
                            <option value="media" selected>Media - Necesito una solución pronto</option>
                            <option value="alta">Alta - Es urgente</option>
                            <option value="critica">Crítica - Es una emergencia</option>
                        </select>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up" style="animation-delay: 1s;">
                    <button type="submit" 
                            class="bg-tech-success-green hover:bg-green-600 text-tech-pure-white px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Enviar Solicitud
                    </button>
                    <a href="{{ route('home') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-tech-pure-white px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-alert" class="fixed top-20 right-4 bg-tech-success-green text-tech-pure-white px-6 py-3 rounded-lg shadow-lg animate-slide-down z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 5000);
        </script>
    @endif
</body>
</html>