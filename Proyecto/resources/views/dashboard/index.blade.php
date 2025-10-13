<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Baieco</title>
    @vite(['resources/css/app.css', 'resources/css/baieco.css'])
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
                <h1 class="text-xl font-bold">Baieco Dashboard</h1>
            </div>

            <!-- User Info -->
            <div class="flex items-center space-x-4">
                <div class="text-sm">
                    <p class="font-semibold">{{ $user['name'] ?? 'Usuario' }}</p>
                    <p class="text-xs text-teal-100">{{ ucfirst($user['role'] ?? 'user') }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
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

        <!-- Bienvenida -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-sky-800 mb-2">
                ¡Bienvenido, {{ $user['name'] ?? 'Usuario' }}!
            </h2>
            <p class="text-gray-700">Gestiona tus órdenes, clientes y reportes desde un solo lugar.</p>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-gradient-to-br from-sky-100 to-sky-200 rounded-xl p-6 shadow-md">
                <h3 class="text-sm font-semibold text-sky-700 mb-1">Órdenes Totales</h3>
                <p class="text-3xl font-bold text-sky-900">156</p>
            </div>
            <div class="bg-gradient-to-br from-amber-100 to-yellow-200 rounded-xl p-6 shadow-md">
                <h3 class="text-sm font-semibold text-amber-700 mb-1">Pendientes</h3>
                <p class="text-3xl font-bold text-amber-900">23</p>
            </div>
            <div class="bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl p-6 shadow-md">
                <h3 class="text-sm font-semibold text-orange-700 mb-1">En Progreso</h3>
                <p class="text-3xl font-bold text-orange-900">45</p>
            </div>
            <div class="bg-gradient-to-br from-green-100 to-emerald-200 rounded-xl p-6 shadow-md">
                <h3 class="text-sm font-semibold text-green-700 mb-1">Completadas</h3>
                <p class="text-3xl font-bold text-green-900">88</p>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 mb-10">
            <h3 class="text-lg font-semibold text-teal-700 mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-sky-400 to-blue-500 text-white hover:opacity-90 transition">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div class="text-left">
                        <h4 class="font-medium">Nueva Orden</h4>
                        <p class="text-sm text-blue-50">Crear nueva orden de servicio</p>
                    </div>
                </button>

                <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-green-400 to-emerald-500 text-white hover:opacity-90 transition">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div class="text-left">
                        <h4 class="font-medium">Nuevo Cliente</h4>
                        <p class="text-sm text-green-50">Registrar nuevo cliente</p>
                    </div>
                </button>

                <button class="flex items-center p-4 rounded-lg bg-gradient-to-r from-purple-400 to-fuchsia-500 text-white hover:opacity-90 transition">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <div class="text-left">
                        <h4 class="font-medium">Reportes</h4>
                        <p class="text-sm text-purple-50">Ver estadísticas y reportes</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Órdenes Recientes -->
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="text-lg font-semibold text-teal-700 mb-4">Órdenes Recientes</h3>
            <div class="space-y-4">
                @for($i = 1; $i <= 5; $i++)
                <div class="flex items-center justify-between p-4 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-sky-200 to-sky-300 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-sm font-semibold text-sky-800">#{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Orden #OS-2025-{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</h4>
                            <p class="text-sm text-gray-600">Cliente: Juan Pérez - iPhone 12 Pro</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $i % 2 == 0 ? 'bg-amber-200 text-amber-800' : 'bg-emerald-200 text-emerald-800' }}">
                            {{ $i % 2 == 0 ? 'En Progreso' : 'Completado' }}
                        </span>
                        <button class="text-sky-600 hover:text-sky-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </main>

</body>
</html>
