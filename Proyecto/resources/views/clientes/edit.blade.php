@extends('layouts.admin')

@section('title', 'Editar Cliente')

@section('header')
<div class="flex items-center space-x-4">
    <a href="{{ route('admin.clientes.index') }}" 
       class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
        <i class="fas fa-arrow-left text-xl"></i>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Editar Cliente</h1>
        <p class="mt-2 text-gray-600">Modifica la información de {{ $cliente->nombre_completo }}</p>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Formulario de Edición (2/3 del ancho) -->
        <div class="lg:col-span-2 space-y-8">
            <form method="POST" action="{{ route('admin.clientes.update', $cliente->id) }}" class="space-y-8">
                @csrf
                @method('PUT')
                
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
                                       value="{{ old('nombre', $cliente->nombre) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('nombre') border-red-500 @enderror">
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
                                       value="{{ old('apellido', $cliente->apellido) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('apellido') border-red-500 @enderror">
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
                                       value="{{ old('rut', $cliente->rut) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('rut') border-red-500 @enderror"
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
                                       value="{{ old('email', $cliente->email) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('email') border-red-500 @enderror">
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
                                       value="{{ old('telefono', $cliente->telefono) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('telefono') border-red-500 @enderror">
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
                                       value="{{ old('empresa', $cliente->empresa) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('empresa') border-red-500 @enderror">
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
                                          class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $cliente->direccion) }}</textarea>
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
                                    <option value="regular" {{ old('tipo_cliente', $cliente->tipo_cliente) == 'regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="vip" {{ old('tipo_cliente', $cliente->tipo_cliente) == 'vip' ? 'selected' : '' }}>VIP</option>
                                    <option value="corporativo" {{ old('tipo_cliente', $cliente->tipo_cliente) == 'corporativo' ? 'selected' : '' }}>Corporativo</option>
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
                                    <option value="activo" {{ old('estado', $cliente->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $cliente->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="vip" {{ old('estado', $cliente->estado) == 'vip' ? 'selected' : '' }}>VIP</option>
                                    <option value="moroso" {{ old('estado', $cliente->estado) == 'moroso' ? 'selected' : '' }}>Moroso</option>
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
                                        <option value="{{ $servicio->id }}" {{ old('servicio_tecnico_id', $cliente->servicio_tecnico_id) == $servicio->id ? 'selected' : '' }}>
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
                                      class="w-full rounded-lg border-gray-300 focus:border-capstone-500 focus:ring-capstone-500 @error('notas') border-red-500 @enderror">{{ old('notas', $cliente->notas) }}</textarea>
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
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Panel de Información y Estadísticas (1/3 del ancho) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Información del Cliente -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        Información del Cliente
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cliente desde:</span>
                        <span class="font-medium">{{ $cliente->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Última actualización:</span>
                        <span class="font-medium">{{ $cliente->updated_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Estado actual:</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $cliente->estado_badge }}">
                            {{ ucfirst($cliente->estado) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Servicio técnico:</span>
                        <span class="font-medium">{{ $cliente->servicioTecnico->nombre ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de Órdenes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Órdenes de Servicio
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-capstone-600">{{ $cliente->totalOrdenes() }}</div>
                            <div class="text-sm text-gray-600">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $cliente->ordenesCompletadas() }}</div>
                            <div class="text-sm text-gray-600">Completadas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ $cliente->ordenesPendientes() }}</div>
                            <div class="text-sm text-gray-600">Pendientes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">${{ number_format($cliente->valorTotalGastado(), 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-600">Gastado</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Última Orden -->
            @if($cliente->ultimaOrden())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            Última Orden
                        </h3>
                    </div>
                    <div class="p-6">
                        @php $ultimaOrden = $cliente->ultimaOrden() @endphp
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600">Número:</span>
                                <span class="font-medium">{{ $ultimaOrden->numero_orden }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Fecha:</span>
                                <span class="font-medium">{{ $ultimaOrden->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Estado:</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($ultimaOrden->estado) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Servicio:</span>
                                <span class="font-medium">{{ $ultimaOrden->tipo_servicio }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acceso Rápido -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-500 to-gray-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.clientes.show', $cliente->id) }}" 
                       class="w-full bg-capstone-100 hover:bg-capstone-200 text-capstone-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                        <i class="fas fa-eye mr-2"></i>
                        Ver Detalles Completos
                    </a>
                    <form method="POST" action="{{ route('admin.clientes.toggle-status', $cliente->id) }}" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full {{ $cliente->estado === 'activo' ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas {{ $cliente->estado === 'activo' ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                            {{ $cliente->estado === 'activo' ? 'Desactivar Cliente' : 'Activar Cliente' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formateo automático de RUT (mantener formato existente si viene formateado)
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

    // Contador de caracteres para notas
    const notasTextarea = document.getElementById('notas');
    const maxLength = 1000;
    
    function updateCounter() {
        const remaining = maxLength - notasTextarea.value.length;
        let counter = document.getElementById('notas-counter');
        
        if (!counter) {
            counter = document.createElement('p');
            counter.id = 'notas-counter';
            counter.className = 'mt-1 text-sm text-gray-500';
            notasTextarea.parentNode.appendChild(counter);
        }
        
        counter.textContent = `${remaining} caracteres restantes`;
        
        if (remaining < 0) {
            counter.className = 'mt-1 text-sm text-red-500';
            notasTextarea.classList.add('border-red-500');
        } else {
            counter.className = 'mt-1 text-sm text-gray-500';
            notasTextarea.classList.remove('border-red-500');
        }
    }
    
    notasTextarea.addEventListener('input', updateCounter);
    updateCounter(); // Inicializar contador
});
</script>
@endpush
@endsection