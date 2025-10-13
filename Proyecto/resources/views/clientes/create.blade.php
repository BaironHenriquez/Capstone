@extends('layouts.admin')

@section('title', 'Crear Nuevo Cliente')

@section('header')
<div class="flex items-center space-x-4">
    <a href="{{ route('admin.clientes.index') }}" 
       class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
        <i class="fas fa-arrow-left text-xl"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Crear Nuevo Cliente</h1>
        <p class="mt-2 text-gray-600">Registra un nuevo cliente en el sistema</p>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.clientes.store') }}" class="space-y-8">
        @csrf
        
        <!-- Información Personal -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-capstone-500 to-capstone-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Información Personal
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('nombre') border-red-500 @enderror"
                               placeholder="Ingrese el nombre">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">
                            Apellido <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="apellido" 
                               name="apellido" 
                               value="{{ old('apellido') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('apellido') border-red-500 @enderror"
                               placeholder="Ingrese el apellido">
                        @error('apellido')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- RUT -->
                    <div>
                        <label for="rut" class="block text-sm font-medium text-gray-700 mb-2">
                            RUT <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="rut" 
                               name="rut" 
                               value="{{ old('rut') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('rut') border-red-500 @enderror"
                               placeholder="12.345.678-9"
                               maxlength="12">
                        @error('rut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('email') border-red-500 @enderror"
                               placeholder="cliente@ejemplo.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('telefono') border-red-500 @enderror"
                               placeholder="+56 9 1234 5678">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Empresa -->
                    <div>
                        <label for="empresa" class="block text-sm font-medium text-gray-700 mb-2">
                            Empresa
                        </label>
                        <input type="text" 
                               id="empresa" 
                               name="empresa" 
                               value="{{ old('empresa') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('empresa') border-red-500 @enderror"
                               placeholder="Nombre de la empresa (opcional)">
                        @error('empresa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección <span class="text-red-500">*</span>
                        </label>
                        <textarea id="direccion" 
                                  name="direccion" 
                                  rows="3"
                                  required
                                  class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('direccion') border-red-500 @enderror"
                                  placeholder="Ingrese la dirección completa">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuración del Cliente -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-capstone-500 to-capstone-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    Configuración del Cliente
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tipo de Cliente -->
                    <div>
                        <label for="tipo_cliente" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Cliente <span class="text-red-500">*</span>
                        </label>
                        <select id="tipo_cliente" 
                                name="tipo_cliente" 
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('tipo_cliente') border-red-500 @enderror">
                            <option value="">Seleccionar tipo</option>
                            <option value="regular" {{ old('tipo_cliente') == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="vip" {{ old('tipo_cliente') == 'vip' ? 'selected' : '' }}>VIP</option>
                            <option value="corporativo" {{ old('tipo_cliente') == 'corporativo' ? 'selected' : '' }}>Corporativo</option>
                        </select>
                        @error('tipo_cliente')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select id="estado" 
                                name="estado" 
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('estado') border-red-500 @enderror">
                            <option value="">Seleccionar estado</option>
                            <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }} selected>Activo</option>
                            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Servicio Técnico -->
                    <div>
                        <label for="servicio_tecnico_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Servicio Técnico <span class="text-red-500">*</span>
                        </label>
                        <select id="servicio_tecnico_id" 
                                name="servicio_tecnico_id" 
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('servicio_tecnico_id') border-red-500 @enderror">
                            <option value="">Seleccionar servicio</option>
                            @foreach($serviciosTecnicos as $servicio)
                                <option value="{{ $servicio->id }}" {{ old('servicio_tecnico_id') == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('servicio_tecnico_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Notas Adicionales -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-capstone-500 to-capstone-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-sticky-note mr-2"></i>
                    Notas Adicionales
                </h2>
            </div>
            <div class="p-6">
                <div>
                    <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                        Notas y Observaciones
                    </label>
                    <textarea id="notas" 
                              name="notas" 
                              rows="4"
                              class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('notas') border-red-500 @enderror"
                              placeholder="Ingrese cualquier información adicional sobre el cliente (opcional)">{{ old('notas') }}</textarea>
                    @error('notas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Máximo 1000 caracteres</p>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.clientes.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-times mr-2"></i>
                Cancelar
            </a>
            <button type="submit" 
                    class="bg-capstone-600 hover:bg-capstone-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>
                Crear Cliente
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formateo automático de RUT
    const rutInput = document.getElementById('rut');
    
    rutInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9kK]/g, '');
        
        if (value.length > 1) {
            const body = value.slice(0, -1);
            const dv = value.slice(-1);
            
            // Formatear con puntos
            let formattedBody = body.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            
            e.target.value = formattedBody + '-' + dv;
        } else {
            e.target.value = value;
        }
    });

    // Validación del formulario antes del envío
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos.');
        }
    });

    // Contador de caracteres para notas
    const notasTextarea = document.getElementById('notas');
    const maxLength = 1000;
    
    notasTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        let counter = document.getElementById('notas-counter');
        
        if (!counter) {
            counter = document.createElement('p');
            counter.id = 'notas-counter';
            counter.className = 'mt-1 text-sm text-gray-500';
            this.parentNode.appendChild(counter);
        }
        
        counter.textContent = `${remaining} caracteres restantes`;
        
        if (remaining < 0) {
            counter.className = 'mt-1 text-sm text-red-500';
            this.classList.add('border-red-500');
        } else {
            counter.className = 'mt-1 text-sm text-gray-500';
            this.classList.remove('border-red-500');
        }
    });
});
</script>
@endpush
@endsection