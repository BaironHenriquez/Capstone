<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Servicio Técnico - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/technical-service-validation.css') }}" rel="stylesheet">
    <script src="{{ asset('js/technical-service-validation.js') }}" defer></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen font-inter">
    
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">TechService Pro</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ $user->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="text-center mb-12">
            <div class="flex justify-center mb-6">
                <div class="h-20 w-20 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                ¡Suscripción Activada!
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ahora necesitamos configurar tu servicio técnico para completar la instalación. 
                Esta información será utilizada en todas las órdenes de servicio y documentos.
            </p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Configuración del Servicio Técnico</h2>
                <p class="text-gray-600 mt-2">Completa la información de tu servicio técnico</p>
            </div>

            <form method="POST" action="{{ route('setup.technical-service.save') }}" class="px-8 py-6">
                @csrf
                
                <!-- Nombre del Servicio -->
                <div class="mb-6">
                    <label for="nombre_servicio" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Servicio Técnico *
                    </label>
                    <input type="text" 
                           id="nombre_servicio" 
                           name="nombre_servicio" 
                           value="{{ old('nombre_servicio', $servicioTecnico->nombre_servicio ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Ej: TechService Pro - Reparaciones"
                           maxlength="45"
                           required>
                </div>

                <!-- Dirección -->
                <div class="mb-6">
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección *
                    </label>
                    <input type="text" 
                           id="direccion" 
                           name="direccion" 
                           value="{{ old('direccion', $servicioTecnico->direccion ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Dirección del servicio técnico"
                           maxlength="45"
                           required>
                </div>

                <!-- Teléfono y Correo -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono *
                        </label>
                        <input type="tel" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $servicioTecnico->telefono ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="+56 9 1234 5678"
                               maxlength="45"
                               required>
                    </div>
                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico *
                        </label>
                        <input type="email" 
                               id="correo" 
                               name="correo" 
                               value="{{ old('correo', $servicioTecnico->correo ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="contacto@tuservicio.com"
                               maxlength="45"
                               required>
                    </div>
                </div>

                <!-- RUT del Servicio -->
                <div class="mb-6">
                    <label for="rut" class="block text-sm font-medium text-gray-700 mb-2">
                        RUT del Servicio Técnico *
                    </label>
                    <input type="text" 
                           id="rut" 
                           name="rut" 
                           value="{{ old('rut', $servicioTecnico->rut ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="12.345.678-9"
                           maxlength="45"
                           required>
                    <p class="text-sm text-gray-500 mt-1">RUT de la empresa o servicio técnico (sin puntos, con guión)</p>
                </div>



                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Completar Configuración
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
            <div class="flex">
                <svg class="h-6 w-6 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-blue-900">¿Por qué necesitamos esta información?</h3>
                    <p class="mt-2 text-blue-700">
                        Esta información se utilizará en todas las órdenes de servicio, cotizaciones, y documentos oficiales. 
                        Todos los campos son obligatorios y están limitados a 45 caracteres para mantener la compatibilidad con el sistema.
                    </p>
                    <div class="mt-3">
                        <h4 class="font-medium text-blue-900">Campos requeridos:</h4>
                        <ul class="mt-1 text-sm text-blue-700 list-disc list-inside">
                            <li><strong>Nombre del Servicio:</strong> Identificación de tu negocio (máx. 45 caracteres)</li>
                            <li><strong>Dirección:</strong> Ubicación física del servicio (máx. 45 caracteres)</li>
                            <li><strong>Teléfono:</strong> Número de contacto principal (máx. 45 caracteres)</li>
                            <li><strong>Correo:</strong> Email de contacto profesional (máx. 45 caracteres)</li>
                            <li><strong>RUT:</strong> Identificación tributaria del servicio (máx. 45 caracteres)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>