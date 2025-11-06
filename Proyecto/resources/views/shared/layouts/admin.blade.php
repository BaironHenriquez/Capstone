<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Administrativo') - Baieco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
<body class="min-h-screen bg-gradient-to-br from-sky-50 via-teal-50 to-emerald-50 text-gray-800">

    <!-- Header -->
    <header class="bg-gradient-to-r from-teal-500 to-sky-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="w-9 h-9 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold">Baieco - @yield('title', 'Panel Administrativo')</h1>
            </div>

            <!-- Navigation -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-sm text-teal-100 hover:text-white transition {{ request()->routeIs('dashboard*') ? 'text-white font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('admin.clientes.index') }}" class="text-sm text-teal-100 hover:text-white transition {{ request()->routeIs('admin.clientes*') ? 'text-white font-semibold' : '' }}">Clientes</a>
                <a href="{{ route('admin.gestion-tecnicos') }}" class="text-sm text-teal-100 hover:text-white transition {{ request()->routeIs('admin.gestion-tecnicos*') ? 'text-white font-semibold' : '' }}">Técnicos</a>
                <a href="{{ route('ordenes.index') }}" class="text-sm text-teal-100 hover:text-white transition {{ request()->routeIs('ordenes*') ? 'text-white font-semibold' : '' }}">Órdenes</a>
                <a href="{{ route('configuracion.index') }}" class="text-sm text-teal-100 hover:text-white transition {{ request()->routeIs('configuracion*') ? 'text-white font-semibold' : '' }}">Configuración</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="p-2 rounded-md hover:bg-white hover:bg-opacity-20 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
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