<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Servicio Técnico - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            <div class="mb-8 bg-green-50 border-l-4 border-green-400 p-4 rounded-md animate-fade-in">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded-md animate-fade-in">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="ml-3 text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4 rounded-md animate-fade-in">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-700">Por favor, corrige los siguientes errores:</p>
                        <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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

            <form method="POST" action="{{ route('setup.technical-service.save') }}" class="px-8 py-6" id="technicalServiceForm">
                @csrf
                
                <!-- Mensaje de éxito temporal (oculto por defecto) -->
                <div id="successMessage" class="hidden mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-md animate-fade-in">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-3 text-sm text-green-700 font-medium">✓ Servicio técnico guardado correctamente. Redirigiendo...</p>
                    </div>
                </div>
                
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
                            id="submitBtn"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="btnText" class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Completar Configuración
                        </span>
                        <span id="btnLoading" class="hidden flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Guardando...
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

    <!-- JavaScript para manejar el estado del formulario y validación en tiempo real -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('technicalServiceForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const successMessage = document.getElementById('successMessage');
            
            // Campos a validar en tiempo real
            const fieldsToValidate = {
                'nombre_servicio': document.getElementById('nombre_servicio'),
                'correo': document.getElementById('correo'),
                'telefono': document.getElementById('telefono'),
                'direccion': document.getElementById('direccion'),
                'rut': document.getElementById('rut')
            };
            
            // Objeto para almacenar el estado de disponibilidad de cada campo
            const availabilityStatus = {};
            
            // Función para crear mensaje de feedback
            function createFeedbackElement(fieldName) {
                const field = fieldsToValidate[fieldName];
                if (!field) return null;
                
                // Eliminar feedback previo si existe
                const existingFeedback = field.parentElement.querySelector('.availability-feedback');
                if (existingFeedback) {
                    existingFeedback.remove();
                }
                
                // Crear nuevo elemento de feedback
                const feedback = document.createElement('div');
                feedback.className = 'availability-feedback mt-2 text-sm';
                field.parentElement.appendChild(feedback);
                
                return feedback;
            }
            
            // Función para verificar disponibilidad de un campo
            async function checkAvailability(fieldName, value) {
                if (!value || value.trim() === '') {
                    availabilityStatus[fieldName] = true;
                    const feedback = createFeedbackElement(fieldName);
                    if (feedback) feedback.innerHTML = '';
                    updateSubmitButton();
                    return;
                }
                
                const feedback = createFeedbackElement(fieldName);
                if (!feedback) return;
                
                // Mostrar "Consultando disponibilidad..."
                feedback.innerHTML = `
                    <div class="flex items-center text-gray-600">
                        <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Consultando disponibilidad...
                    </div>
                `;
                
                try {
                    const response = await fetch('{{ route("setup.check-availability") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            field: fieldName,
                            value: value
                        })
                    });
                    
                    const data = await response.json();
                    availabilityStatus[fieldName] = data.available;
                    
                    if (data.available) {
                        feedback.innerHTML = `
                            <div class="flex items-center text-green-600">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                ✓ Disponible
                            </div>
                        `;
                        fieldsToValidate[fieldName].classList.remove('border-red-500');
                        fieldsToValidate[fieldName].classList.add('border-green-500');
                    } else {
                        feedback.innerHTML = `
                            <div class="flex items-center text-red-600">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                ✗ ${data.message}
                            </div>
                        `;
                        fieldsToValidate[fieldName].classList.remove('border-green-500');
                        fieldsToValidate[fieldName].classList.add('border-red-500');
                    }
                } catch (error) {
                    console.error('Error al verificar disponibilidad:', error);
                    feedback.innerHTML = `
                        <div class="text-gray-500 text-xs">
                            Error al verificar disponibilidad
                        </div>
                    `;
                    availabilityStatus[fieldName] = true; // Permitir continuar si hay error de red
                }
                
                updateSubmitButton();
            }
            
            // Función para actualizar el estado del botón de envío
            function updateSubmitButton() {
                const allAvailable = Object.values(availabilityStatus).every(status => status === true);
                
                if (submitBtn) {
                    submitBtn.disabled = !allAvailable;
                    if (!allAvailable) {
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        submitBtn.title = 'Corrige los campos duplicados antes de continuar';
                    } else {
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitBtn.title = '';
                    }
                }
            }
            
            // Agregar listeners a cada campo
            Object.keys(fieldsToValidate).forEach(fieldName => {
                const field = fieldsToValidate[fieldName];
                if (field) {
                    let timeoutId;
                    
                    field.addEventListener('input', function() {
                        // Limpiar timeout anterior
                        clearTimeout(timeoutId);
                        
                        // Esperar 800ms después de que el usuario deja de escribir
                        timeoutId = setTimeout(() => {
                            checkAvailability(fieldName, this.value);
                        }, 800);
                    });
                    
                    // Verificar al cargar si hay valor (para edición)
                    if (field.value) {
                        checkAvailability(fieldName, field.value);
                    } else {
                        availabilityStatus[fieldName] = true;
                    }
                }
            });
            
            // Función para resetear el botón
            function resetButton() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    btnText.classList.remove('hidden');
                    btnLoading.classList.add('hidden');
                }
                if (successMessage) {
                    successMessage.classList.add('hidden');
                }
            }
            
            // Función para mostrar estado de carga
            function showLoading() {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');
                }
            }
            
            // Función para mostrar éxito
            function showSuccess() {
                if (successMessage) {
                    successMessage.classList.remove('hidden');
                    successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            
            if (form && submitBtn) {
                let formSubmitted = false;
                
                form.addEventListener('submit', function(e) {
                    // Verificar que todos los campos estén disponibles
                    const allAvailable = Object.values(availabilityStatus).every(status => status === true);
                    
                    if (!allAvailable) {
                        e.preventDefault();
                        alert('Por favor, corrige los campos duplicados antes de continuar.');
                        return false;
                    }
                    
                    // Evitar múltiples envíos
                    if (formSubmitted) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Validar que todos los campos requeridos estén completos
                    const requiredFields = form.querySelectorAll('[required]');
                    let allValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            allValid = false;
                        }
                    });
                    
                    if (!allValid) {
                        console.log('Campos requeridos faltantes');
                        return;
                    }
                    
                    // Marcar como enviado y mostrar estado de carga
                    formSubmitted = true;
                    showLoading();
                    
                    console.log('Formulario enviado correctamente');
                    
                    // Mostrar mensaje de éxito después de 1 segundo
                    setTimeout(function() {
                        if (formSubmitted) {
                            showSuccess();
                            console.log('Mostrando mensaje de éxito');
                        }
                    }, 1000);
                    
                    // Timeout de seguridad: si después de 15 segundos no se redirige, resetear
                    setTimeout(function() {
                        if (formSubmitted) {
                            console.warn('Timeout: Reseteando botón después de 15 segundos');
                            alert('El guardado está tomando más tiempo del esperado. Por favor, verifica tu conexión.');
                            resetButton();
                            formSubmitted = false;
                        }
                    }, 15000);
                });
                
                // Resetear si la página se carga con errores
                @if($errors->any() || session('error'))
                    resetButton();
                @endif
            }
        });
    </script>
</body>
</html>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>