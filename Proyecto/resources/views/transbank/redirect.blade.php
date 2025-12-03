<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo a Transbank</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-red-50 via-white to-orange-50 min-h-screen font-inter">
    
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="h-10 w-10 mr-3" viewBox="0 0 50 50" fill="none">
                        <rect width="50" height="50" rx="8" fill="#ED1C24"/>
                        <path d="M15 25h20M25 15v20" stroke="white" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                    <span class="text-2xl font-bold text-red-600">Transbank</span>
                </div>
                <div class="text-sm text-gray-600">
                    Webpay Plus
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            
            <div class="bg-gradient-to-r from-red-600 to-orange-600 px-6 py-6 text-white">
                <div class="flex items-center">
                    <svg class="h-8 w-8 mr-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <div>
                        <h1 class="text-xl font-bold">Redirigiendo a Transbank</h1>
                        <p class="text-red-100">Serás redirigido al portal seguro de pago</p>
                    </div>
                </div>
            </div>

            <div class="p-8 text-center">
                
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 mb-4">
                        <svg class="h-10 w-10 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Preparando tu pago</h2>
                    <p class="text-gray-600">
                        Estás siendo redirigido a Transbank para completar tu compra de forma segura.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Transacción protegida por Transbank</span>
                    </div>
                </div>

                <div class="space-y-3 text-sm text-gray-600 text-left bg-blue-50 rounded-lg p-4">
                    <p class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>No cierres esta ventana durante el proceso de pago</span>
                    </p>
                    <p class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Serás redirigido automáticamente en unos segundos</span>
                    </p>
                </div>

                <form id="transbankForm" action="{{ $url }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="token_ws" value="{{ $token }}">
                </form>

                <div class="mt-6">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="w-2 h-2 bg-red-600 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-red-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-red-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('subscription.plans') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Volver a planes de suscripción
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('transbankForm').submit();
            }, 2000);
        });
    </script>
</body>
</html>
