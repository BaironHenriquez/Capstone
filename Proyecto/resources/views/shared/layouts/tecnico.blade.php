<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Técnico') - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- CSS personalizado para técnicos -->
    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .tech-card {
            animation: fadeInScale 0.6s ease-out;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .tech-metric {
            animation: slideInUp 0.5s ease-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Colores específicos para técnicos */
        .tech-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .tech-accent { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navigation Header -->
    <nav class="bg-gradient-to-r from-purple-800 to-indigo-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo y navegación principal -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-white text-2xl font-bold">TechService Pro</span>
                    </div>
                    
                    <!-- Botón hamburguesa para móvil -->
                    <button id="mobile-menu-toggle" class="md:hidden ml-4 text-white hover:text-gray-300 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Navegación desktop -->
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('tecnico.dashboard') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('tecnico.dashboard*') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('tecnico.ordenes.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('tecnico.ordenes*') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-clipboard-list mr-1"></i> Mis Órdenes
                        </a>
                        <a href="{{ route('tecnico.clientes') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('tecnico.clientes') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-users mr-1"></i> Clientes
                        </a>
                        <a href="{{ route('tecnico.equipos') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('tecnico.equipos') ? 'bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-laptop mr-1"></i> Equipos
                        </a>
                    </div>
                </div>

                <!-- Usuario y acciones -->
                <div class="flex items-center space-x-4">
                    <!-- Notificaciones técnicas -->
                    <div class="relative">
                        <button class="text-white hover:text-gray-200 p-2 rounded-full transition-colors duration-300">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                        </button>
                    </div>
                    
                    <!-- Usuario -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden sm:block text-white text-sm">
                            <div class="font-semibold">{{ auth()->guard('tecnico')->user()->nombre ?? 'Técnico' }}</div>
                            <div class="text-xs text-gray-200">Panel Técnico</div>
                        </div>
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-cog text-white text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- Botón volver -->
                    <a href="{{ route('home') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-1"></i> <span class="hidden sm:inline">Inicio</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
        <div id="mobile-menu" class="md:hidden bg-purple-900 border-t border-purple-700 hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('tecnico.dashboard') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tecnico.dashboard*') ? 'bg-white bg-opacity-20' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('tecnico.ordenes.index') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tecnico.ordenes*') ? 'bg-white bg-opacity-20' : '' }}">
                    <i class="fas fa-clipboard-list mr-2"></i> Mis Órdenes
                </a>
                <a href="{{ route('tecnico.clientes') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tecnico.clientes') ? 'bg-white bg-opacity-20' : '' }}">
                    <i class="fas fa-users mr-2"></i> Clientes
                </a>
                <a href="{{ route('tecnico.equipos') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tecnico.equipos') ? 'bg-white bg-opacity-20' : '' }}">
                    <i class="fas fa-laptop mr-2"></i> Equipos
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        @if(!request()->routeIs('dashboard'))
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-purple-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right mx-2"></i></li>
                <li class="text-gray-900 font-medium">@yield('breadcrumb', 'Página')</li>
            </ol>
        </nav>
        @endif

        <!-- Alertas -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-check-circle text-green-400 mt-0.5 mr-3"></i>
                <div class="text-green-700">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-exclamation-circle text-red-400 mt-0.5 mr-3"></i>
                <div class="text-red-700">{{ session('error') }}</div>
            </div>
        </div>
        @endif

        <!-- Contenido de la página -->
        @yield('content')
        
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; 2025 TechService Pro - Panel Técnico</p>
                <p class="mt-1">Última actualización: {{ date('d/m/Y H:i') }}</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript base -->
    <script>
        // Menú móvil
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Auto-ocultar alertas
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Función para mostrar notificaciones técnicas
        function showTechNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 'bg-purple-500'
            } text-white`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${
                        type === 'success' ? 'fa-check' : 
                        type === 'error' ? 'fa-times' : 
                        type === 'warning' ? 'fa-exclamation' : 'fa-info'
                    } mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }
    </script>

    @stack('scripts')

</body>
</html>