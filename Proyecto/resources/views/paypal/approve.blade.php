<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pago - PayPal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen font-inter">
    
    <!-- PayPal-like Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-8 w-8 mr-3" viewBox="0 0 24 24">
                        <path fill="#0070ba" d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.258-.93 4.778-4.005 7.201-9.138 7.201H8.817l-.542 3.437c-.07.445.263.85.712.85h2.876c.457 0 .845-.334.918-.788l.038-.207.732-4.63.047-.268c.073-.454.461-.788.918-.788h.579c3.583 0 6.389-1.457 7.205-5.671.342-1.768.166-3.24-.824-4.28z"/>
                    </svg>
                    <span class="text-2xl font-bold text-blue-600">PayPal</span>
                </div>
                <div class="text-sm text-gray-600">
                    Pago seguro
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Payment Review Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6 text-white">
                <div class="flex items-center">
                    <svg class="h-8 w-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h1 class="text-xl font-bold">Revisar y Confirmar Pago</h1>
                        <p class="text-blue-100">Verifica los detalles antes de completar tu compra</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                
                <!-- Merchant Info -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">TechService Pro</h2>
                            <p class="text-gray-600">Sistema de Gestión de Servicio Técnico</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles del Pago</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Artículo:</span>
                            <span class="font-medium text-gray-900">{{ $payment->description }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Monto:</span>
                            <span class="text-xl font-bold text-gray-900">
                                ${{ number_format($payment->amount, 2) }} {{ $payment->currency }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">ID de Pago:</span>
                            <span class="text-sm font-mono text-gray-700">{{ $payment->paypal_payment_id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Simulated Account Selection -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Método de Pago</h3>
                    
                    <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                        <div class="flex items-center">
                            <input type="radio" id="paypal_balance" name="payment_source" value="balance" checked
                                   class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-3">
                                <label for="paypal_balance" class="font-medium text-gray-900 cursor-pointer">
                                    Saldo de PayPal
                                </label>
                                <p class="text-sm text-gray-600">$1,234.56 disponible</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <input type="radio" id="credit_card" name="payment_source" value="card"
                                   class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-3">
                                <label for="credit_card" class="font-medium text-gray-900 cursor-pointer">
                                    Tarjeta de crédito terminada en 4567
                                </label>
                                <p class="text-sm text-gray-600">Visa •••• 4567</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <form action="{{ route('paypal.execute') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="payment_id" value="{{ $payment->paypal_payment_id }}">
                        <input type="hidden" name="payer_id" value="PAYER{{ rand(10000, 99999) }}">
                        
                        <button type="submit" id="confirmBtn"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                            <span id="confirmText" class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Confirmar y Pagar
                            </span>
                            <span id="confirmLoading" class="hidden flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Procesando pago...
                            </span>
                        </button>
                    </form>
                    
                    <a href="{{ route('paypal.cancel', ['payment_id' => $payment->paypal_payment_id]) }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-4 px-6 rounded-xl text-center transition-colors">
                        Cancelar
                    </a>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 bg-green-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-green-800">
                                <strong>Transacción segura:</strong> Este pago está protegido por la garantía de comprador de PayPal. 
                                Tu información financiera nunca se comparte con el comerciante.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Al completar este pago, aceptas los términos de servicio de PayPal y TechService Pro.</p>
            <p class="mt-1">¿Necesitas ayuda? <a href="#" class="text-blue-600 hover:underline">Contacta soporte</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmBtn = document.getElementById('confirmBtn');
            const confirmText = document.getElementById('confirmText');
            const confirmLoading = document.getElementById('confirmLoading');
            
            // Handle confirm button click - solo cuando el usuario haga clic manualmente
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Validar que se haya seleccionado un método de pago
                    const selectedPaymentMethod = document.querySelector('input[name="payment_source"]:checked');
                    if (!selectedPaymentMethod) {
                        alert('Por favor selecciona un método de pago.');
                        return;
                    }
                    
                    // Confirmar el pago
                    const confirmed = confirm(`¿Confirmas el pago de ${{ number_format($payment->amount, 2) }} {{ $payment->currency }} usando ${selectedPaymentMethod.value === 'balance' ? 'Saldo de PayPal' : 'Tarjeta de crédito'}?`);
                    
                    if (!confirmed) {
                        return;
                    }
                    
                    // Show loading state
                    if (confirmText) confirmText.classList.add('hidden');
                    if (confirmLoading) confirmLoading.classList.remove('hidden');
                    confirmBtn.disabled = true;
                    
                    // Submit the form after showing loading state
                    setTimeout(function() {
                        confirmBtn.closest('form').submit();
                    }, 1500);
                });
            }
            
            // Prevenir cualquier auto-submit accidental
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Solo permitir submit si el botón está deshabilitado (procesando) o si es un submit manual
                    if (!confirmBtn.disabled && !e.isTrusted) {
                        e.preventDefault();
                        console.log('Auto-submit prevented');
                    }
                });
            });
        });
    </script>
</body>
</html>