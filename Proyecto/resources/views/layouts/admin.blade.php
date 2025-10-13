<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Administrativo') - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- CSS personalizado -->
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
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .dashboard-card {
            animation: fadeInScale 0.6s ease-out;
        }
        
        .dashboard-metric {
            animation: slideInUp 0.5s ease-out;
        }
        
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .animate-slide-down {
            animation: slideDown 0.6s ease-out;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Sidebar responsive */
        @media (max-width: 768px) {
            .sidebar-open {
                transform: translateX(0);
            }
            .sidebar-closed {
                transform: translateX(-100%);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navigation Header -->
    <nav class="bg-tech-dark-blue shadow-lg sticky top-0 z-50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo y navegación principal -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 animate-scale-in">
                        <span class="text-tech-pure-white text-2xl font-bold">TechService Pro</span>
                    </div>
                    
                    <!-- Botón hamburguesa para móvil -->
                    <button id="mobile-menu-toggle" class="md:hidden ml-4 text-white hover:text-gray-300 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Navegación desktop -->
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('dashboard') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('dashboard*') ? 'text-tech-electric-blue bg-blue-600' : '' }}">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('clientes.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('clientes*') ? 'text-tech-electric-blue bg-blue-600' : '' }}">
                            <i class="fas fa-users mr-1"></i> Clientes
                        </a>
                        <a href="{{ route('tecnicos.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('tecnicos*') ? 'text-tech-electric-blue bg-blue-600' : '' }}">
                            <i class="fas fa-tools mr-1"></i> Técnicos
                        </a>
                        <a href="{{ route('equipos-marcas.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('equipos-marcas*') ? 'text-tech-electric-blue bg-blue-600' : '' }}">
                            <i class="fas fa-laptop mr-1"></i> Equipos
                        </a>
                        <a href="{{ route('ordenes.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300 {{ request()->routeIs('ordenes*') ? 'text-tech-electric-blue bg-blue-600' : '' }}">
                            <i class="fas fa-clipboard-list mr-1"></i> Órdenes
                        </a>
                    </div>
                </div>

                <!-- Usuario y acciones -->
                <div class="flex items-center space-x-4">
                    <!-- Notificaciones -->
                    <div class="relative">
                        <button class="text-tech-pure-white hover:text-tech-electric-blue p-2 rounded-full transition-colors duration-300">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                    
                    <!-- Usuario -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden sm:block text-tech-pure-white text-sm">
                            <div class="font-semibold">{{ auth()->user()->name ?? 'Administrador' }}</div>
                            <div class="text-xs text-gray-300">Panel Técnico Administrador</div>
                        </div>
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- Botón volver -->
                    <a href="{{ route('home') }}" class="text-tech-pure-white hover:text-tech-electric-blue px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-1"></i> <span class="hidden sm:inline">Volver al Inicio</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
        <div id="mobile-menu" class="md:hidden bg-tech-dark-blue border-t border-gray-700 hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="text-tech-pure-white hover:text-tech-electric-blue block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('clientes.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('clientes*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-users mr-2"></i> Clientes
                </a>
                <a href="{{ route('tecnicos.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tecnicos*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-tools mr-2"></i> Técnicos
                </a>
                <a href="{{ route('equipos-marcas.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('equipos-marcas*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-laptop mr-2"></i> Equipos
                </a>
                <a href="{{ route('ordenes.index') }}" class="text-tech-pure-white hover:text-tech-electric-blue block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('ordenes*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-clipboard-list mr-2"></i> Órdenes
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
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
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
                <p>&copy; 2025 TechService Pro - Panel Técnico Administrador</p>
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

        // Auto-ocultar alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Función global para mostrar notificaciones
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
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