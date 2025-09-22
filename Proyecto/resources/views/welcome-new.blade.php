<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechService Pro - Servicio Técnico Especializado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-tech-light-gray font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-tech-dark-blue shadow-lg fixed w-full z-50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 animate-scale-in">
                        <span class="text-tech-pure-white text-2xl font-bold">TechService Pro</span>
                    </div>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="#inicio" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">Inicio</a>
                        <a href="#servicios" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">Servicios</a>
                        <a href="#ordenes" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">Órdenes</a>
                        <a href="#contacto" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">Contacto</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard-admin') }}" class="bg-tech-electric-blue hover:bg-blue-600 text-tech-pure-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 transform hover:scale-105">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-tech-electric-blue hover:bg-blue-600 text-tech-pure-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 transform hover:scale-105">
                                Iniciar Sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-tech-warning-orange hover:bg-orange-600 text-tech-pure-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 transform hover:scale-105">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="pt-16 bg-gradient-to-br from-tech-dark-blue to-tech-electric-blue">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-tech-pure-white mb-6 animate-fade-in">
                    Servicio Técnico
                    <span class="text-tech-warning-orange animate-pulse-slow">Profesional</span>
                </h1>
                <p class="text-xl text-tech-pure-white mb-8 max-w-3xl mx-auto animate-slide-up">
                    Soluciones expertas para todos tus equipos electrónicos. Reparaciones rápidas, garantizadas y con la mejor atención al cliente.
                </p>
                <div class="space-x-4 animate-slide-up">
                    <a href="{{ route('servicios.crear') }}" class="bg-tech-success-green hover:bg-green-600 text-tech-pure-white px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 inline-block">
                        Solicitar Servicio
                    </a>
                    <a href="{{ route('ordenes.index') }}" class="bg-transparent border-2 border-tech-pure-white text-tech-pure-white hover:bg-tech-pure-white hover:text-tech-dark-blue px-8 py-3 rounded-lg text-lg font-semibold transition-all duration-300 transform hover:scale-105 inline-block">
                        Ver Órdenes
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-20 bg-tech-pure-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-tech-dark-blue mb-4 animate-fade-in">
                    Nuestros Servicios
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto animate-slide-up">
                    Ofrecemos una amplia gama de servicios técnicos especializados para mantener tus equipos funcionando perfectamente.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-tech-light-gray rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 animate-scale-in">
                    <div class="w-16 h-16 bg-tech-electric-blue rounded-lg flex items-center justify-center mb-4 animate-float">
                        <svg class="w-8 h-8 text-tech-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-2">Reparación de Computadoras</h3>
                    <p class="text-gray-600 mb-4">Diagnóstico y reparación de hardware y software para equipos de escritorio y portátiles.</p>
                    <a href="{{ route('servicios.computadoras') }}" class="text-tech-electric-blue hover:text-tech-dark-blue font-medium transition-colors duration-300">
                        Más información →
                    </a>
                </div>

                <!-- Service Card 2 -->
                <div class="bg-tech-light-gray rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 animate-scale-in" style="animation-delay: 0.1s;">
                    <div class="w-16 h-16 bg-tech-success-green rounded-lg flex items-center justify-center mb-4 animate-float" style="animation-delay: 0.5s;">
                        <svg class="w-8 h-8 text-tech-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-2">Reparación de Móviles</h3>
                    <p class="text-gray-600 mb-4">Servicio especializado en smartphones y tablets. Cambio de pantallas, baterías y más.</p>
                    <a href="{{ route('servicios.moviles') }}" class="text-tech-electric-blue hover:text-tech-dark-blue font-medium transition-colors duration-300">
                        Más información →
                    </a>
                </div>

                <!-- Service Card 3 -->
                <div class="bg-tech-light-gray rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 animate-scale-in" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 bg-tech-warning-orange rounded-lg flex items-center justify-center mb-4 animate-float" style="animation-delay: 1s;">
                        <svg class="w-8 h-8 text-tech-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-dark-blue mb-2">Soporte Técnico</h3>
                    <p class="text-gray-600 mb-4">Asistencia remota y presencial para resolver problemas técnicos de software y sistemas.</p>
                    <a href="{{ route('servicios.soporte') }}" class="text-tech-electric-blue hover:text-tech-dark-blue font-medium transition-colors duration-300">
                        Más información →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Section -->
    <section class="py-20 bg-tech-light-gray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-tech-dark-blue mb-4 animate-fade-in">
                    Estado de Órdenes
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto animate-slide-up">
                    Consulta el estado de tu orden de servicio en tiempo real.
                </p>
            </div>

            <div class="max-w-md mx-auto">
                <div class="bg-tech-pure-white rounded-lg p-6 shadow-lg animate-scale-in">
                    <form action="{{ route('ordenes.buscar') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="numero_orden" class="block text-sm font-medium text-tech-dark-blue mb-2">
                                Número de Orden
                            </label>
                            <input type="text" id="numero_orden" name="numero_orden" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-tech-electric-blue focus:border-transparent transition-all duration-300"
                                   placeholder="Ej: TS-2025-001">
                        </div>
                        <button type="submit" 
                                class="w-full bg-tech-electric-blue hover:bg-blue-600 text-tech-pure-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                            Consultar Estado
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-20 bg-tech-dark-blue">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-tech-pure-white mb-4 animate-fade-in">
                    Contáctanos
                </h2>
                <p class="text-lg text-tech-pure-white max-w-2xl mx-auto animate-slide-up">
                    ¿Tienes preguntas? Estamos aquí para ayudarte.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center animate-scale-in">
                    <div class="w-16 h-16 bg-tech-electric-blue rounded-lg flex items-center justify-center mx-auto mb-4 animate-bounce-slow">
                        <svg class="w-8 h-8 text-tech-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-pure-white mb-2">Teléfono</h3>
                    <p class="text-tech-pure-white">+56 9 1234 5678</p>
                </div>

                <div class="text-center animate-scale-in" style="animation-delay: 0.1s;">
                    <div class="w-16 h-16 bg-tech-success-green rounded-lg flex items-center justify-center mx-auto mb-4 animate-bounce-slow" style="animation-delay: 0.5s;">
                        <svg class="w-8 h-8 text-tech-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-pure-white mb-2">Email</h3>
                    <p class="text-tech-pure-white">contacto@techservicepro.cl</p>
                </div>

                <div class="text-center animate-scale-in" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 bg-tech-warning-orange rounded-lg flex items-center justify-center mx-auto mb-4 animate-bounce-slow" style="animation-delay: 1s;">
                        <svg class="w-8 h-8 text-tech-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-tech-pure-white mb-2">Dirección</h3>
                    <p class="text-tech-pure-white">Av. Providencia 1234, Santiago</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-tech-pure-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2025 TechService Pro. Todos los derechos reservados.</p>
                <div class="mt-4 space-x-4">
                    <a href="#" class="text-tech-electric-blue hover:text-tech-warning-orange transition-colors duration-300">Términos de Servicio</a>
                    <a href="#" class="text-tech-electric-blue hover:text-tech-warning-orange transition-colors duration-300">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Success Messages Animation -->
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

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>