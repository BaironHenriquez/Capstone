<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Suscripción Activada! - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-green-50 via-blue-50 to-indigo-50 min-h-screen font-inter">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            
            <!-- Success Animation -->
            <div class="text-center mb-12">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                    <svg class="h-12 w-12 text-green-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    ¡Suscripción Activada!
                </h1>
                <p class="text-xl text-gray-600">
                    Tu pago se ha procesado exitosamente. Bienvenido a TechService Pro.
                </p>
            </div>

            <!-- Success Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-blue-600 px-6 py-6 text-white">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h2 class="text-xl font-bold">Pago Completado</h2>
                            <p class="text-green-100">{{ now()->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    
                    <!-- Subscription Details -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles de tu Suscripción</h3>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Plan</p>
                                <p class="font-semibold text-gray-900">{{ ucfirst($subscription->plan_type) }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Precio</p>
                                <p class="font-semibold text-gray-900">${{ $subscription->amount }} {{ $subscription->currency }}/mes</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Fecha de Inicio</p>
                                <p class="font-semibold text-gray-900">{{ $subscription->starts_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 mb-1">Próximo Pago</p>
                                <p class="font-semibold text-gray-900">{{ $subscription->ends_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- What's Next -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">¿Qué sigue?</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600 font-semibold text-sm">
                                        1
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-base font-medium text-gray-900">Accede al Dashboard</h4>
                                    <p class="text-sm text-gray-600">Comienza a gestionar tus órdenes de servicio técnico</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600 font-semibold text-sm">
                                        2
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-base font-medium text-gray-900">Configura tu Perfil</h4>
                                    <p class="text-sm text-gray-600">Personaliza tu información y preferencias</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600 font-semibold text-sm">
                                        3
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-base font-medium text-gray-900">Crea tu Primera Orden</h4>
                                    <p class="text-sm text-gray-600">Empieza a usar todas las funcionalidades del sistema</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <a href="/dashboard" 
                           class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl text-center transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Ir al Dashboard
                            </span>
                        </a>
                        
                        <a href="{{ route('subscription.show') }}" 
                           class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-medium py-4 px-6 rounded-xl text-center transition-colors">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Ver Suscripción
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 grid md:grid-cols-3 gap-4">
                
                <!-- Support -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 110 19.5 9.75 9.75 0 010-19.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Soporte 24/7</h3>
                    <p class="text-sm text-gray-600">Estamos aquí para ayudarte cuando lo necesites</p>
                </div>

                <!-- Documentation -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Documentación</h3>
                    <p class="text-sm text-gray-600">Guías completas para aprovechar al máximo el sistema</p>
                </div>

                <!-- Community -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 mb-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Comunidad</h3>
                    <p class="text-sm text-gray-600">Conecta con otros profesionales del servicio técnico</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    ¿Tienes preguntas? 
                    <a href="mailto:soporte@techservicepro.com" class="text-blue-600 hover:underline">
                        Contacta nuestro equipo de soporte
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Confetti Animation -->
    <div class="fixed inset-0 pointer-events-none z-10">
        <div class="confetti-container">
            <!-- Confetti pieces will be generated by JavaScript -->
        </div>
    </div>

    <script>
        // Simple confetti animation
        document.addEventListener('DOMContentLoaded', function() {
            createConfetti();
            
            // Auto redirect to dashboard after 10 seconds
            setTimeout(function() {
                const dashboardLink = document.querySelector('[href="/dashboard"]');
                if (dashboardLink) {
                    window.location.href = '/dashboard';
                }
            }, 10000);
        });

        function createConfetti() {
            const container = document.querySelector('.confetti-container');
            const colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: absolute;
                    width: 10px;
                    height: 10px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    left: ${Math.random() * 100}vw;
                    animation: fall ${Math.random() * 3 + 2}s linear infinite;
                    animation-delay: ${Math.random() * 2}s;
                    opacity: 0.8;
                    border-radius: 50%;
                `;
                container.appendChild(confetti);
            }
            
            // Add CSS animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fall {
                    0% {
                        transform: translateY(-100vh) rotate(0deg);
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(100vh) rotate(360deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            // Remove confetti after animation
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }
    </script>
</body>
</html>