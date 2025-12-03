<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin') - Baieco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-teal-500 to-sky-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-white text-xl font-bold">Baieco - Dashboard Global</span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center gap-6 ml-auto">
                    <a href="{{ route('super-admin.dashboard') }}" class="text-white hover:bg-teal-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('super-admin.dashboard') ? 'bg-teal-600' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('super-admin.servicios-tecnicos') }}" class="text-white hover:bg-teal-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('super-admin.servicios-tecnicos') ? 'bg-teal-600' : '' }}">
                        Servicios Técnicos
                    </a>
                    <a href="{{ route('super-admin.reporte-financiero') }}" class="text-white hover:bg-teal-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('super-admin.reporte-financiero') ? 'bg-teal-600' : '' }}">
                        Reportes Financieros
                    </a>
                    <a href="{{ route('super-admin.alertas') }}" class="text-white hover:bg-teal-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('super-admin.alertas') ? 'bg-teal-600' : '' }}">
                        Alertas y Notificaciones
                    </a>
                    
                    <div class="flex items-center gap-4 border-l border-teal-300 pl-6">
                        <span class="text-white text-sm">{{ auth()->user()->nombre ?? auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('super-admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:bg-teal-600 px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
