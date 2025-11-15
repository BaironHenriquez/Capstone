@extends('shared.layouts.admin')

@section('title', 'Editar Técnico')

@push('styles')
<style>
    .form-section {
        animation: slideInUp 0.3s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">
                    <i class="fas fa-user-edit text-blue-500 mr-2"></i>
                    Editar Técnico
                </h1>
                <p class="text-gray-600">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</p>
            </div>
            <a href="{{ route('admin.gestion-tecnicos') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong>Por favor corrige los siguientes errores:</strong>
            </div>
            <ul class="list-disc list-inside ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tecnicos.update', $tecnico->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Información Personal -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 form-section">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                <i class="fas fa-user text-blue-500 mr-2"></i>
                Información Personal
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre', $tecnico->nombre) }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Apellido -->
                <div>
                    <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-2">
                        Apellido <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="apellido" 
                           name="apellido" 
                           value="{{ old('apellido', $tecnico->apellido) }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('apellido') border-red-500 @enderror">
                    @error('apellido')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RUT -->
                <div>
                    <label for="rut" class="block text-sm font-semibold text-gray-700 mb-2">
                        RUT <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="rut" 
                           name="rut" 
                           value="{{ old('rut', $tecnico->rut) }}"
                           required
                           placeholder="12.345.678-9"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('rut') border-red-500 @enderror">
                    @error('rut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $tecnico->email) }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                        Teléfono Personal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="telefono" 
                           name="telefono" 
                           value="{{ old('telefono', $tecnico->telefono) }}"
                           required
                           placeholder="+56 9 1234 5678"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telefono') border-red-500 @enderror">
                    @error('telefono')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de Nacimiento -->
                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha de Nacimiento
                    </label>
                    <input type="date" 
                           id="fecha_nacimiento" 
                           name="fecha_nacimiento" 
                           value="{{ old('fecha_nacimiento', $tecnico->fecha_nacimiento) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Dirección
                    </label>
                    <input type="text" 
                           id="direccion" 
                           name="direccion" 
                           value="{{ old('direccion', $tecnico->direccion) }}"
                           placeholder="Calle, número, depto/casa"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Ciudad -->
                <div>
                    <label for="ciudad" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ciudad
                    </label>
                    <input type="text" 
                           id="ciudad" 
                           name="ciudad" 
                           value="{{ old('ciudad', $tecnico->ciudad) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Región -->
                <div>
                    <label for="region" class="block text-sm font-semibold text-gray-700 mb-2">
                        Región
                    </label>
                    <input type="text" 
                           id="region" 
                           name="region" 
                           value="{{ old('region', $tecnico->region) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Información Laboral -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 form-section">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                <i class="fas fa-briefcase text-purple-500 mr-2"></i>
                Información Laboral
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nivel de Experiencia -->
                <div>
                    <label for="nivel_experiencia" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nivel de Experiencia <span class="text-red-500">*</span>
                    </label>
                    <select name="nivel_experiencia" 
                            id="nivel_experiencia" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nivel_experiencia') border-red-500 @enderror">
                        <option value="junior" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="semi-senior" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'semi-senior' ? 'selected' : '' }}>Semi-Senior</option>
                        <option value="senior" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="experto" {{ old('nivel_experiencia', $tecnico->nivel_experiencia) == 'experto' ? 'selected' : '' }}>Experto</option>
                    </select>
                    @error('nivel_experiencia')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Zona de Trabajo -->
                <div>
                    <label for="zona_trabajo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Zona de Trabajo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="zona_trabajo" 
                           name="zona_trabajo" 
                           value="{{ old('zona_trabajo', $tecnico->zona_trabajo) }}"
                           required
                           placeholder="Ej: Región Metropolitana"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('zona_trabajo') border-red-500 @enderror">
                    @error('zona_trabajo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono de Trabajo -->
                <div>
                    <label for="telefono_trabajo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Teléfono de Trabajo
                    </label>
                    <input type="text" 
                           id="telefono_trabajo" 
                           name="telefono_trabajo" 
                           value="{{ old('telefono_trabajo', $tecnico->telefono_trabajo) }}"
                           placeholder="+56 9 1234 5678"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Horario de Trabajo -->
                <div>
                    <label for="horario_trabajo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Horario de Trabajo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="horario_trabajo" 
                           name="horario_trabajo" 
                           value="{{ old('horario_trabajo', $tecnico->horario_trabajo) }}"
                           required
                           placeholder="Ej: lunes a viernes de 8:30 a 18:30"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('horario_trabajo') border-red-500 @enderror">
                    @error('horario_trabajo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salario Base -->
                <div>
                    <label for="salario_base" class="block text-sm font-semibold text-gray-700 mb-2">
                        Salario Base (CLP) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-semibold pointer-events-none">$</span>
                        <input type="text" 
                               id="salario_base" 
                               name="salario_base" 
                               value="{{ old('salario_base', number_format($tecnico->salario_base ?? 0, 0, ',', '.')) }}"
                               required
                               placeholder="900.000"
                               class="w-full pl-7 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('salario_base') border-red-500 @enderror">
                    </div>
                    @error('salario_base')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-600">Ingresa el monto con puntos de miles</p>
                </div>

                <!-- Comisión por Orden -->
                <div>
                    <label for="comision_por_orden" class="block text-sm font-semibold text-gray-700 mb-2">
                        Comisión por Orden (%)
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="comision_por_orden" 
                               name="comision_por_orden" 
                               value="{{ old('comision_por_orden', number_format($tecnico->comision_por_orden ?? 0, 2, '.', '')) }}"
                               placeholder="20"
                               class="w-full pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-semibold pointer-events-none">%</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">Ej: 20 para 20% de comisión</p>
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-semibold text-gray-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select name="estado" 
                            id="estado" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('estado') border-red-500 @enderror">
                        <option value="activo" {{ old('estado', $tecnico->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $tecnico->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="vacaciones" {{ old('estado', $tecnico->estado) == 'vacaciones' ? 'selected' : '' }}>Vacaciones</option>
                        <option value="licencia" {{ old('estado', $tecnico->estado) == 'licencia' ? 'selected' : '' }}>Licencia</option>
                        <option value="suspendido" {{ old('estado', $tecnico->estado) == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Especialidades -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 form-section">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                <i class="fas fa-tools text-green-500 mr-2"></i>
                Especialidades <span class="text-red-500">*</span>
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @php
                $especialidadesDisponibles = [
                    'Reparación de Smartphones',
                    'Reparación de Laptops',
                    'Reparación de Tablets',
                    'Reparación de Consolas',
                    'Cambio de Pantallas',
                    'Reparación de Baterías',
                    'Mantenimiento Preventivo',
                    'Instalación de Software',
                    'Recuperación de Datos',
                    'Reparación de Placa Base',
                    'Limpieza Interna',
                    'Diagnóstico Hardware'
                ];
                
                // Decodificar especialidades de forma segura
                $especialidadesActuales = [];
                if (old('especialidades')) {
                    $especialidadesActuales = old('especialidades');
                } elseif ($tecnico->especialidades) {
                    if (is_string($tecnico->especialidades)) {
                        $especialidadesActuales = json_decode($tecnico->especialidades, true) ?? [];
                    } elseif (is_array($tecnico->especialidades)) {
                        $especialidadesActuales = $tecnico->especialidades;
                    }
                }
                @endphp
                
                @foreach($especialidadesDisponibles as $especialidad)
                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-all">
                        <input type="checkbox" 
                               name="especialidades[]" 
                               value="{{ $especialidad }}" 
                               {{ in_array($especialidad, $especialidadesActuales) ? 'checked' : '' }}
                               class="mr-2 text-blue-600 focus:ring-blue-500 rounded">
                        <span class="text-sm text-gray-700">{{ $especialidad }}</span>
                    </label>
                @endforeach
            </div>
            
            @error('especialidades')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-3 text-sm text-gray-600">Selecciona al menos una especialidad</p>
        </div>

        <!-- Certificaciones -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 form-section">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                <i class="fas fa-certificate text-yellow-500 mr-2"></i>
                Certificaciones (Opcional)
            </h2>
            
            <div id="certificaciones-container">
                @php
                // Decodificar certificaciones de forma segura
                $certificacionesActuales = [];
                if (old('certificaciones')) {
                    $certificacionesActuales = old('certificaciones');
                } elseif ($tecnico->certificaciones) {
                    if (is_string($tecnico->certificaciones)) {
                        $certificacionesActuales = json_decode($tecnico->certificaciones, true) ?? [];
                    } elseif (is_array($tecnico->certificaciones)) {
                        $certificacionesActuales = $tecnico->certificaciones;
                    }
                }
                @endphp
                
                @forelse($certificacionesActuales as $index => $cert)
                    <div class="certificacion-item flex gap-2 mb-3">
                        <input type="text" 
                               name="certificaciones[]" 
                               value="{{ $cert }}"
                               placeholder="Nombre de la certificación"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" 
                                onclick="this.parentElement.remove()" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @empty
                    <div class="certificacion-item flex gap-2 mb-3">
                        <input type="text" 
                               name="certificaciones[]" 
                               placeholder="Nombre de la certificación"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" 
                                onclick="this.parentElement.remove()" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endforelse
            </div>
            
            <button type="button" 
                    onclick="agregarCertificacion()" 
                    class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Agregar Certificación
            </button>
        </div>

        <!-- Notas Administrativas -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 form-section">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                <i class="fas fa-sticky-note text-orange-500 mr-2"></i>
                Notas Administrativas
            </h2>
            
            <div>
                <textarea name="notas_admin" 
                          id="notas_admin" 
                          rows="4" 
                          placeholder="Observaciones internas sobre el técnico..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notas_admin', $tecnico->notas_admin) }}</textarea>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex justify-end gap-4 pb-6">
            <a href="{{ route('admin.gestion-tecnicos') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition-colors font-semibold">
                <i class="fas fa-times mr-2"></i>Cancelar
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors font-semibold shadow-lg hover:shadow-xl">
                <i class="fas fa-save mr-2"></i>Guardar Cambios
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Función para agregar certificación
function agregarCertificacion() {
    const container = document.getElementById('certificaciones-container');
    const div = document.createElement('div');
    div.className = 'certificacion-item flex gap-2 mb-3';
    div.innerHTML = `
        <input type="text" 
               name="certificaciones[]" 
               placeholder="Nombre de la certificación"
               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <button type="button" 
                onclick="this.parentElement.remove()" 
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

// Formateo automático del RUT
document.getElementById('rut').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\dkK]/g, '');
    if (value.length > 1) {
        value = value.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '-' + value.slice(-1);
    }
    e.target.value = value;
});

// Formateo de salario con separador de miles
const salarioInput = document.getElementById('salario_base');
salarioInput.addEventListener('input', function(e) {
    // Remover todo excepto números
    let value = e.target.value.replace(/\D/g, '');
    
    // Formatear con puntos de miles
    if (value) {
        value = parseInt(value).toLocaleString('es-CL');
    }
    
    e.target.value = value;
});

// Al enviar el formulario, limpiar el formato
salarioInput.form.addEventListener('submit', function() {
    salarioInput.value = salarioInput.value.replace(/\./g, '');
});

// Formateo de comisión (solo números y punto decimal)
const comisionInput = document.getElementById('comision_por_orden');
comisionInput.addEventListener('input', function(e) {
    // Permitir solo números y un punto decimal
    let value = e.target.value.replace(/[^\d.]/g, '');
    
    // Evitar múltiples puntos decimales
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
    }
    
    // Limitar a 2 decimales
    if (parts[1] && parts[1].length > 2) {
        value = parts[0] + '.' + parts[1].substring(0, 2);
    }
    
    // Limitar el rango 0-100
    const numValue = parseFloat(value);
    if (numValue > 100) {
        value = '100';
    }
    
    e.target.value = value;
});
</script>
@endpush

@endsection
