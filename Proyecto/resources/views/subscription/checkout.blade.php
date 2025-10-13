<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $plan['name'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen font-inter">
    
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200">
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
                    <a href="{{ route('subscription.plans') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                        ← Volver a Planes
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Steps -->
        <div class="mb-12">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-600 rounded-full">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Seleccionar Plan</span>
                    </div>
                    <div class="w-16 h-0.5 bg-blue-600"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full">
                            <span class="text-white text-sm font-medium">2</span>
                        </div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Checkout</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-300 rounded-full">
                            <span class="text-gray-600 text-sm font-medium">3</span>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-400">Confirmación</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
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

        <div class="grid lg:grid-cols-2 gap-8">
            
            <!-- Plan Summary -->
            <div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Resumen del Pedido</h2>
                    </div>
                    
                    <div class="p-6">
                        <!-- Plan Details -->
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $plan['name'] }}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ $plan['description'] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-gray-900">
                                    ${{ $plan['price'] }}
                                </span>
                                <span class="text-gray-600">/ mes</span>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-900 mb-3">Incluye:</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">Gestión completa de órdenes</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">Control de inventario</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">Gestión de clientes</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">Reportes y analytics</span>
                                </div>
                                @if($plan['type'] === 'premium')
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700"><strong>Funcionalidades premium</strong></span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700"><strong>Soporte prioritario 24/7</strong></span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Billing Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Subtotal</span>
                                <span class="text-sm font-medium text-gray-900">${{ $plan['price'] }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Impuestos</span>
                                <span class="text-sm font-medium text-gray-900">$0.00</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-base font-medium text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-gray-900">${{ $plan['price'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">
                                <strong>Pago seguro:</strong> Todos los pagos son procesados de forma segura por PayPal. 
                                Tu información está protegida con encriptación SSL.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div>
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Información de Pago</h2>
                    </div>
                    
                    <div class="p-6">
                        <!-- Customer Info -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Cliente</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    @if($user->avatar)
                                        <img class="h-10 w-10 rounded-full mr-3" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                    @else
                                        <div class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Método de Pago</h3>
                            
                            <!-- PayPal Option -->
                            <div class="border border-gray-200 rounded-lg p-4 bg-blue-50">
                                <div class="flex items-center">
                                    <input type="radio" id="paypal" name="payment_method" value="paypal" checked 
                                           class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="paypal" class="ml-3 flex items-center cursor-pointer">
                                        <svg class="h-8 w-8 mr-2" viewBox="0 0 24 24">
                                            <path fill="#0070ba" d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.258-.93 4.778-4.005 7.201-9.138 7.201H8.817l-.542 3.437c-.07.445.263.85.712.85h2.876c.457 0 .845-.334.918-.788l.038-.207.732-4.63.047-.268c.073-.454.461-.788.918-.788h.579c3.583 0 6.389-1.457 7.205-5.671.342-1.768.166-3.24-.824-4.28z"/>
                                        </svg>
                                        <span class="font-medium text-gray-900">PayPal</span>
                                    </label>
                                </div>
                                <p class="ml-7 mt-1 text-sm text-gray-600">
                                    Paga de forma segura con tu cuenta PayPal o tarjeta de crédito
                                </p>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" id="terms" required
                                       class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">
                                    Acepto los 
                                    <a href="#" class="text-blue-600 hover:underline">términos y condiciones</a> 
                                    y la 
                                    <a href="#" class="text-blue-600 hover:underline">política de privacidad</a>. 
                                    Entiendo que mi suscripción se renovará automáticamente cada mes.
                                </span>
                            </label>
                        </div>

                        <!-- Payment Button -->
                        <form action="{{ route('paypal.create.payment') }}" method="POST" id="paymentForm">
                            @csrf
                            <input type="hidden" name="plan_type" value="{{ $plan['type'] }}">
                            
                            <button type="submit" id="payButton"
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                <span id="buttonText" class="flex items-center justify-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Pagar con PayPal - ${{ $plan['price'] }}
                                </span>
                                <span id="loadingText" class="hidden flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Procesando...
                                </span>
                            </button>
                        </form>

                        <!-- Money Back Guarantee -->
                        <div class="mt-6 text-center">
                            <div class="inline-flex items-center text-sm text-gray-600">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Garantía de reembolso de 30 días
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('paymentForm');
            const payButton = document.getElementById('payButton');
            const buttonText = document.getElementById('buttonText');
            const loadingText = document.getElementById('loadingText');
            const termsCheckbox = document.getElementById('terms');
            
            // Enable/disable button based on terms acceptance
            termsCheckbox.addEventListener('change', function() {
                payButton.disabled = !this.checked;
            });
            
            // Initially disable button
            payButton.disabled = true;
            
            // Handle form submission
            form.addEventListener('submit', function(e) {
                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    alert('Por favor acepta los términos y condiciones para continuar.');
                    return false;
                }
                
                // Show loading state
                payButton.disabled = true;
                buttonText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            });
        });
    </script>
</body>
</html>