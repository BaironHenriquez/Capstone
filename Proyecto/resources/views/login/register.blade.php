<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-auto text-center">
                    <span class="text-tech-dark-blue text-3xl font-bold">TechService Pro</span>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Crear Cuenta
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Regístrate para acceder al sistema
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Ingresa tu nombre completo">
                    </div>
                    <div>
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Ingresa tu correo electrónico">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Crea una contraseña segura">
                    </div>
                    <div>
                        <label for="password-confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input id="password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Confirma tu contraseña">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-tech-electric-blue focus:ring-tech-electric-blue border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        Acepto los <a href="#" class="text-tech-electric-blue hover:text-blue-500">términos y condiciones</a> y la <a href="#" class="text-tech-electric-blue hover:text-blue-500">política de privacidad</a>
                    </label>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-tech-electric-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tech-electric-blue transition-colors duration-300">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                            </svg>
                        </span>
                        Crear Cuenta
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="font-medium text-tech-electric-blue hover:text-blue-500">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>

                <!-- Demo Access Info -->
                <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                    <h3 class="text-sm font-medium text-green-800 mb-2">✨ Sistema Demo</h3>
                    <p class="text-xs text-green-700 mb-2">Este es un sistema de demostración. Puedes:</p>
                    <ul class="text-xs text-green-600 list-disc list-inside space-y-1">
                        <li>Crear una cuenta demo</li>
                        <li>Usar credenciales de prueba</li>
                        <li>Explorar todas las funcionalidades</li>
                    </ul>
                    <p class="text-xs text-green-600 mt-2">
                        <a href="{{ route('login') }}" class="underline hover:text-green-800">
                            ← Volver al Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>