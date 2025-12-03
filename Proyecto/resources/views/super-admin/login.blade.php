<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-teal-500 via-sky-500 to-teal-600 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-teal-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Super Admin</h1>
                <p class="text-sm text-gray-600 mt-2">Panel de administración global</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="text-sm font-medium">{{ $errors->first() }}</p>
            </div>
            @endif

            @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('super-admin.login.submit') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           autofocus
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Contraseña
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                </div>

                <button type="submit" 
                        class="w-full bg-teal-600 text-white font-semibold py-3 rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-teal-600 transition">
                    ← Volver al inicio
                </a>
            </div>
        </div>

        <p class="text-center text-white text-xs mt-6 opacity-75">
            Acceso restringido solo para Super Administradores
        </p>
    </div>
</body>
</html>
