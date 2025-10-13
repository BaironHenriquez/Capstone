<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes de Suscripción - Servicio Técnico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen font-inter">
    
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">TechService Pro</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if($user->avatar)
                        <img class="h-8 w-8 rounded-full" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                    @endif
                    <span class="text-gray-700 font-medium">{{ $user->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Elige tu Plan
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Selecciona el plan que mejor se adapte a las necesidades de tu negocio. 
                Todos los planes incluyen todas las funcionalidades principales.
            </p>
            
            @if($user->onTrial())
                <div class="mt-6 inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">
                        Período de prueba activo hasta {{ $user->trial_ends_at->format('d/m/Y') }}
                    </span>
                </div>
            @endif
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

        @if(session('error'))
            <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-blue-700">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        <!-- Current Subscription Alert -->
        @if($currentSubscription && $currentSubscription->isActive())
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-900">
                            Suscripción Activa: {{ ucfirst($currentSubscription->plan_type) }}
                        </h3>
                        <p class="text-blue-700">
                            Tu suscripción está activa hasta {{ $currentSubscription->ends_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('subscription.show') }}" 
                           class="inline-flex items-center px-4 py-2 border border-blue-300 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Plans Grid -->
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            
            @foreach($plans as $planType => $plan)
                <div class="relative bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden transform transition-all duration-200 hover:scale-[1.02] hover:shadow-2xl
                            {{ $planType === 'premium' ? 'ring-2 ring-blue-600' : '' }}">
                    
                    @if($planType === 'premium')
                        <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center py-2 text-sm font-medium">
                            ⭐ Más Popular
                        </div>
                    @endif
                    
                    <div class="p-8 {{ $planType === 'premium' ? 'pt-12' : '' }}">
                        <!-- Plan Header -->
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ $plan['name'] }}
                            </h3>
                            <div class="flex items-center justify-center mb-4">
                                <span class="text-4xl font-bold text-gray-900">
                                    ${{ $plan['price'] }}
                                </span>
                                <span class="text-gray-600 ml-2">/ mes</span>
                            </div>
                            <p class="text-gray-600">
                                {{ $plan['description'] }}
                            </p>
                        </div>

                        <!-- Features -->
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Gestión completa de órdenes de servicio</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Control de inventario y equipos</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Gestión de clientes</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Reportes básicos</span>
                            </div>
                            
                            @if($planType === 'premium')
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Analytics avanzados</strong></span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Integraciones API</strong></span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Soporte prioritario 24/7</strong></span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700"><strong>Usuarios ilimitados</strong></span>
                                </div>
                            @endif
                        </div>

                        <!-- CTA Button -->
                        @if($currentSubscription && $currentSubscription->plan_type === $planType && $currentSubscription->isActive())
                            <button class="w-full py-3 px-6 bg-gray-100 text-gray-500 font-medium rounded-xl cursor-not-allowed" disabled>
                                Plan Actual
                            </button>
                        @else
                            <a href="{{ route('subscription.checkout', $planType) }}" 
                               class="block w-full py-3 px-6 bg-gradient-to-r 
                                      {{ $planType === 'premium' ? 'from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700' : 'from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black' }} 
                                      text-white font-semibold rounded-xl text-center transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                @if($user->canAccessSystem())
                                    Cambiar a {{ $plan['name'] }}
                                @else
                                    Comenzar con {{ $plan['name'] }}
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Money Back Guarantee -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center px-6 py-3 bg-green-50 border border-green-200 rounded-full">
                <svg class="h-6 w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span class="text-green-800 font-medium">Garantía de reembolso de 30 días</span>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Preguntas Frecuentes</h2>
            <div class="space-y-6">
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">¿Puedo cambiar de plan en cualquier momento?</h3>
                    <p class="text-gray-600">Sí, puedes actualizar o cambiar tu plan en cualquier momento. Los cambios se aplicarán en tu próximo ciclo de facturación.</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">¿Qué incluye el período de prueba gratuito?</h3>
                    <p class="text-gray-600">El período de prueba de 7 días incluye acceso completo a todas las funcionalidades del sistema sin limitaciones.</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">¿Cómo funciona la garantía de reembolso?</h3>
                    <p class="text-gray-600">Si no estás completamente satisfecho, puedes solicitar un reembolso completo dentro de los primeros 30 días de tu suscripción.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>