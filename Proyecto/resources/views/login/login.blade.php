<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Baieco</title>
    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
    <meta name="description" content="Accede al sistema de gestión de órdenes de servicio de Baieco">
</head>
<body class="auth-gradient font-sans min-h-screen">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo y título -->
            <div class="text-center mb-10">
                <div class="logo-container">
                    <div class="mx-auto w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Baieco</h1>
                <h2 class="text-2xl font-semibold text-white opacity-90 mb-2">
                    Iniciar Sesión
                </h2>
                <p class="text-white opacity-75 text-lg">
                    Sistema de Gestión de Órdenes de Servicio
                </p>
            </div>
            
            <!-- Formulario de login -->
            <div class="glass-form rounded-2xl p-8 shadow-2xl">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="remember" value="true">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="email-address" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico
                            </label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required 
                                   class="input-float w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-gray-900" 
                                   placeholder="tu@email.com">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña
                            </label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                   class="input-float w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-gray-900" 
                                   placeholder="Tu contraseña">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Recordarme
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="btn-primary group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-white group-hover:text-blue-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Iniciar Sesión
                        </button>
                    </div>
                </form>
                
                <!-- Información de ayuda -->
                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <h3 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        ℹ️ Información de Acceso
                    </h3>
                    <p class="text-xs text-blue-700">
                        Si no tienes una cuenta, contacta al administrador del sistema para que te cree un usuario con acceso.
                    </p>
                </div>
            </div>
            
            <!-- Enlaces adicionales -->
            <div class="text-center mt-6">
                <p class="text-white opacity-80 text-sm">
                    ¿Necesitas una cuenta? 
                    <a href="#" class="font-medium text-white hover:text-blue-200 transition-colors underline">
                        Contacta con Baieco
                    </a>
                </p>
                <p class="text-white opacity-60 text-xs mt-2">
                    © 2025 Baieco. Sistema de Gestión de Órdenes de Servicio.
                </p>
            </div>
        </div>
    </div>

    <!-- Mensajes de estado -->
    @if(session('success'))
        <div id="success-alert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div id="error-alert" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

</body>
</html>