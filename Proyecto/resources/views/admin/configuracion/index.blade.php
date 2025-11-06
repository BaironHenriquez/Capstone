@extends('shared.layouts.admin')

@section('title', 'Configuración')

@push('styles')
<style>
    .config-card {
        transition: all 0.3s ease;
    }
    .config-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .tab-button {
        transition: all 0.3s ease;
    }
    .tab-button.active {
        border-bottom: 3px solid #3b82f6;
        color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Configuración</h1>
                <p class="text-gray-600">Administra la información de tu servicio técnico, datos personales y suscripción</p>
            </div>
            <div class="flex items-center space-x-2">
                @if($subscription)
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                        <i class="fas fa-check-circle mr-1"></i>
                        Suscripción Activa
                    </span>
                @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-medium rounded-full">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Sin Suscripción
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button onclick="showTab('servicio')" id="tab-servicio" class="tab-button active flex-1 py-4 px-6 text-center font-medium border-b-2 border-transparent">
                    <i class="fas fa-building mr-2"></i>
                    Servicio Técnico
                </button>
                <button onclick="showTab('personal')" id="tab-personal" class="tab-button flex-1 py-4 px-6 text-center font-medium border-b-2 border-transparent">
                    <i class="fas fa-user mr-2"></i>
                    Datos Personales
                </button>
                <button onclick="showTab('suscripcion')" id="tab-suscripcion" class="tab-button flex-1 py-4 px-6 text-center font-medium border-b-2 border-transparent">
                    <i class="fas fa-credit-card mr-2"></i>
                    Suscripción y Pagos
                </button>
            </nav>
        </div>

        {{-- Tab Content: Servicio Técnico --}}
        <div id="content-servicio" class="tab-content p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Información del Servicio Técnico</h2>
                <p class="text-gray-600">Esta información aparecerá en las órdenes de servicio y documentos oficiales</p>
            </div>

            <form action="{{ route('configuracion.update-servicio') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nombre del Servicio --}}
                <div>
                    <label for="nombre_servicio" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Servicio Técnico *
                    </label>
                    <input type="text" 
                           id="nombre_servicio" 
                           name="nombre_servicio" 
                           value="{{ old('nombre_servicio', $servicioTecnico->nombre_servicio ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ej: TechService Pro - Reparaciones"
                           maxlength="45"
                           required>
                    <div id="feedback-nombre_servicio" class="mt-2"></div>
                    @error('nombre_servicio')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dirección --}}
                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección *
                    </label>
                    <input type="text" 
                           id="direccion" 
                           name="direccion" 
                           value="{{ old('direccion', $servicioTecnico->direccion ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Dirección del servicio técnico"
                           maxlength="45"
                           required>
                    <div id="feedback-direccion" class="mt-2"></div>
                    @error('direccion')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono y Correo --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono *
                        </label>
                        <input type="tel" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $servicioTecnico->telefono ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="+56 9 1234 5678"
                               maxlength="45"
                               required>
                        <div id="feedback-telefono" class="mt-2"></div>
                        @error('telefono')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico *
                        </label>
                        <input type="email" 
                               id="correo" 
                               name="correo" 
                               value="{{ old('correo', $servicioTecnico->correo ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="contacto@tuservicio.com"
                               maxlength="45"
                               required>
                        <div id="feedback-correo" class="mt-2"></div>
                        @error('correo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- RUT --}}
                <div>
                    <label for="rut" class="block text-sm font-medium text-gray-700 mb-2">
                        RUT del Servicio Técnico *
                    </label>
                    <input type="text" 
                           id="rut" 
                           name="rut" 
                           value="{{ old('rut', $servicioTecnico->rut ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="12.345.678-9"
                           maxlength="45"
                           required>
                    <div id="feedback-rut" class="mt-2"></div>
                    <p class="text-sm text-gray-500 mt-1">RUT de la empresa o servicio técnico</p>
                    @error('rut')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="location.reload()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- Tab Content: Datos Personales --}}
        <div id="content-personal" class="tab-content hidden p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Datos Personales</h2>
                <p class="text-gray-600">Información de tu cuenta de usuario</p>
            </div>

            <form action="{{ route('configuracion.update-personal') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre Completo *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Correo Electrónico *
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Este correo se usa para iniciar sesión</p>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cambiar Contraseña --}}
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cambiar Contraseña</h3>
                    <p class="text-sm text-gray-600 mb-4">Deja estos campos en blanco si no deseas cambiar tu contraseña</p>

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña Actual
                            </label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('current_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Nueva Contraseña
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmar Nueva Contraseña
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="location.reload()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- Tab Content: Suscripción y Pagos --}}
        <div id="content-suscripcion" class="tab-content hidden p-6">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Suscripción y Pagos</h2>
                <p class="text-gray-600">Información sobre tu suscripción y próximos pagos</p>
            </div>

            @if($subscription)
            {{-- Estado de Suscripción --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6 border border-blue-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-600 rounded-full p-3 mr-4">
                                <i class="fas fa-crown text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    @if($subscription->plan_type === 'monthly')
                                        Plan Mensual
                                    @elseif($subscription->plan_type === 'quarterly')
                                        Plan Trimestral
                                    @else
                                        Plan Anual
                                    @endif
                                </h3>
                                <p class="text-gray-600">Servicio Técnico - Sistema de Gestión</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-600">Fecha de inicio</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $subscription->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Próxima renovación</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $subscription->ends_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Días restantes</p>
                                @php
                                    $diasRestantes = (int) now()->diffInDays($subscription->ends_at, false);
                                @endphp
                                <p class="text-lg font-semibold {{ $diasRestantes <= 7 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $diasRestantes }} días
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Estado</p>
                                <p class="text-lg font-semibold text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Activa
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-blue-600">
                            ${{ number_format($subscription->amount, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-600">CLP / 
                            @if($subscription->plan_type === 'monthly')
                                mes
                            @elseif($subscription->plan_type === 'quarterly')
                                3 meses
                            @else
                                año
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Próximos Pagos --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                    Próximos Pagos Programados
                </h3>

                <div class="space-y-3">
                    @php
                        $nextPayment = $subscription->ends_at;
                        $amount = $subscription->amount;
                    @endphp

                    {{-- Próximo pago --}}
                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-2 mr-3">
                                <i class="fas fa-exclamation-circle text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Próximo Pago</p>
                                <p class="text-sm text-gray-600">{{ $nextPayment->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-900">${{ number_format($amount, 0, ',', '.') }} CLP</p>
                            <p class="text-xs text-gray-500">{{ $nextPayment->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Pagos futuros --}}
                    @for ($i = 1; $i <= 2; $i++)
                        @php
                            if ($subscription->plan_type === 'monthly') {
                                $futureDate = $nextPayment->copy()->addMonths($i);
                            } elseif ($subscription->plan_type === 'quarterly') {
                                $futureDate = $nextPayment->copy()->addMonths($i * 3);
                            } else {
                                $futureDate = $nextPayment->copy()->addYears($i);
                            }
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-gray-400 rounded-full p-2 mr-3">
                                    <i class="fas fa-calendar text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Pago {{ $i + 1 }}</p>
                                    <p class="text-sm text-gray-600">{{ $futureDate->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">${{ number_format($amount, 0, ',', '.') }} CLP</p>
                                <p class="text-xs text-gray-500">{{ $futureDate->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Historial de Pagos --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-2"></i>
                    Historial de Pagos
                </h3>

                @if($payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Fecha</th>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Descripción</th>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Monto</th>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-900">{{ $payment->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-700">{{ $payment->description }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold text-gray-900">${{ number_format($payment->amount, 0, ',', '.') }} {{ $payment->currency }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $payment->status === 'completed' ? 'Completado' : ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-receipt text-4xl mb-2"></i>
                        <p>No hay historial de pagos</p>
                    </div>
                @endif
            </div>

            {{-- Opciones de Suscripción --}}
            <div class="mt-6 flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">¿Necesitas cambiar tu plan?</p>
                    <p class="text-xs text-gray-500">Puedes actualizar o cancelar tu suscripción en cualquier momento</p>
                </div>
                <div class="space-x-3">
                    <a href="{{ route('subscription.plans') }}" class="inline-block px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 font-medium text-sm">
                        Ver Planes
                    </a>
                </div>
            </div>
            
            @else
            {{-- Sin suscripción --}}
            <div class="text-center py-12">
                <div class="bg-yellow-50 rounded-lg p-8 border border-yellow-200 inline-block">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-5xl mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No tienes una suscripción activa</h3>
                    <p class="text-gray-600 mb-6">Necesitas una suscripción activa para ver esta información</p>
                    <a href="{{ route('subscription.plans') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Ver Planes Disponibles
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab switching
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });
        
        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');
        
        // Add active class to selected tab
        document.getElementById('tab-' + tabName).classList.add('active');
    }

    // Validación en tiempo real para servicio técnico
    document.addEventListener('DOMContentLoaded', function() {
        const fieldsToValidate = {
            'nombre_servicio': document.getElementById('nombre_servicio'),
            'correo': document.getElementById('correo'),
            'telefono': document.getElementById('telefono'),
            'direccion': document.getElementById('direccion'),
            'rut': document.getElementById('rut')
        };

        Object.keys(fieldsToValidate).forEach(fieldName => {
            const field = fieldsToValidate[fieldName];
            if (field) {
                let timeoutId;
                
                field.addEventListener('input', function() {
                    clearTimeout(timeoutId);
                    
                    timeoutId = setTimeout(async () => {
                        await checkAvailability(fieldName, this.value);
                    }, 800);
                });
            }
        });

        async function checkAvailability(fieldName, value) {
            if (!value || value.trim() === '') {
                document.getElementById('feedback-' + fieldName).innerHTML = '';
                return;
            }

            const feedback = document.getElementById('feedback-' + fieldName);
            feedback.innerHTML = `
                <div class="flex items-center text-gray-600 text-sm">
                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Verificando disponibilidad...
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

                if (data.available) {
                    feedback.innerHTML = `
                        <div class="flex items-center text-green-600 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            Disponible
                        </div>
                    `;
                    fieldsToValidate[fieldName].classList.remove('border-red-500');
                    fieldsToValidate[fieldName].classList.add('border-green-500');
                } else {
                    feedback.innerHTML = `
                        <div class="flex items-center text-red-600 text-sm">
                            <i class="fas fa-times-circle mr-2"></i>
                            ${data.message}
                        </div>
                    `;
                    fieldsToValidate[fieldName].classList.remove('border-green-500');
                    fieldsToValidate[fieldName].classList.add('border-red-500');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    });
</script>
@endpush
