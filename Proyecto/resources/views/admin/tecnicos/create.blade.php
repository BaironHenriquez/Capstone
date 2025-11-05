@extends('shared.layouts.admin')

@section('title', 'Crear Técnico')

@section('header')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="bg-sky-100 p-3 rounded-lg">
            <i class="fas fa-user-plus text-2xl text-sky-600"></i>
        </div>
        <div>
            <h2 class="text-3xl font-bold text-sky-800">Crear Nuevo Técnico</h2>
            <p class="text-gray-600 mt-1">Agrega un nuevo miembro al equipo de {{ $servicioTecnico->nombre_servicio }}</p>
        </div>
    </div>
    <div class="flex items-center gap-2 text-sm text-gray-600">
        <i class="fas fa-info-circle text-sky-500"></i>
        <span>Los campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios</span>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Alertas de Error -->
    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
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

    <form method="POST" action="{{ route('admin.tecnicos.store') }}" class="space-y-6">
        @csrf
        
        <!-- Información Personal -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                <i class="fas fa-user mr-2 text-sky-600"></i>
                Información Personal
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('nombre') border-red-500 @enderror">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
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
                           value="{{ old('apellido') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('apellido') border-red-500 @enderror">
                    @error('apellido')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
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
                           value="{{ old('rut') }}"
                           placeholder="12.345.678-9"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('rut') border-red-500 @enderror">
                    @error('rut')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Correo Electrónico <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
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
                           value="{{ old('telefono') }}"
                           placeholder="+56 9 1234 5678"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('telefono') border-red-500 @enderror">
                    @error('telefono')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
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
                           value="{{ old('telefono_trabajo') }}"
                           placeholder="+56 9 1234 5678"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Opcional. Si no se indica, se usará el teléfono personal.</p>
                </div>

                <!-- Fecha de Nacimiento -->
                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha de Nacimiento
                    </label>
                    <input type="date" 
                           id="fecha_nacimiento" 
                           name="fecha_nacimiento" 
                           value="{{ old('fecha_nacimiento') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('fecha_nacimiento') border-red-500 @enderror">
                    @error('fecha_nacimiento')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Dirección
                    </label>
                    <input type="text" 
                           id="direccion" 
                           name="direccion" 
                           value="{{ old('direccion') }}"
                           placeholder="Calle, número, depto/casa"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('direccion') border-red-500 @enderror">
                    @error('direccion')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ciudad -->
                <div>
                    <label for="ciudad" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ciudad
                    </label>
                    <input type="text" 
                           id="ciudad" 
                           name="ciudad" 
                           value="{{ old('ciudad') }}"
                           placeholder="Ej: Santiago, Valparaíso"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('ciudad') border-red-500 @enderror">
                    @error('ciudad')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Región -->
                <div>
                    <label for="region" class="block text-sm font-semibold text-gray-700 mb-2">
                        Región
                    </label>
                    <select id="region" 
                            name="region" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('region') border-red-500 @enderror">
                        <option value="">Seleccionar región</option>
                        <option value="Arica y Parinacota" {{ old('region') == 'Arica y Parinacota' ? 'selected' : '' }}>Arica y Parinacota</option>
                        <option value="Tarapacá" {{ old('region') == 'Tarapacá' ? 'selected' : '' }}>Tarapacá</option>
                        <option value="Antofagasta" {{ old('region') == 'Antofagasta' ? 'selected' : '' }}>Antofagasta</option>
                        <option value="Atacama" {{ old('region') == 'Atacama' ? 'selected' : '' }}>Atacama</option>
                        <option value="Coquimbo" {{ old('region') == 'Coquimbo' ? 'selected' : '' }}>Coquimbo</option>
                        <option value="Valparaíso" {{ old('region') == 'Valparaíso' ? 'selected' : '' }}>Valparaíso</option>
                        <option value="Metropolitana" {{ old('region') == 'Metropolitana' ? 'selected' : '' }}>Región Metropolitana</option>
                        <option value="O'Higgins" {{ old('region') == "O'Higgins" ? 'selected' : '' }}>O'Higgins</option>
                        <option value="Maule" {{ old('region') == 'Maule' ? 'selected' : '' }}>Maule</option>
                        <option value="Ñuble" {{ old('region') == 'Ñuble' ? 'selected' : '' }}>Ñuble</option>
                        <option value="Biobío" {{ old('region') == 'Biobío' ? 'selected' : '' }}>Biobío</option>
                        <option value="La Araucanía" {{ old('region') == 'La Araucanía' ? 'selected' : '' }}>La Araucanía</option>
                        <option value="Los Ríos" {{ old('region') == 'Los Ríos' ? 'selected' : '' }}>Los Ríos</option>
                        <option value="Los Lagos" {{ old('region') == 'Los Lagos' ? 'selected' : '' }}>Los Lagos</option>
                        <option value="Aysén" {{ old('region') == 'Aysén' ? 'selected' : '' }}>Aysén</option>
                        <option value="Magallanes" {{ old('region') == 'Magallanes' ? 'selected' : '' }}>Magallanes</option>
                    </select>
                    @error('region')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Credenciales de Acceso -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                <i class="fas fa-lock mr-2 text-sky-600"></i>
                Credenciales de Acceso al Sistema
            </h3>
            
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            El técnico podrá iniciar sesión con su correo electrónico y la contraseña que establezcas aquí.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Mínimo 6 caracteres</p>
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmar Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Información Profesional -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                <i class="fas fa-briefcase mr-2 text-sky-600"></i>
                Información Profesional
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nivel de Experiencia -->
                <div>
                    <label for="nivel_experiencia" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nivel de Experiencia <span class="text-red-500">*</span>
                    </label>
                    <select id="nivel_experiencia" 
                            name="nivel_experiencia" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('nivel_experiencia') border-red-500 @enderror">
                        <option value="">Seleccionar nivel</option>
                        <option value="junior" {{ old('nivel_experiencia') == 'junior' ? 'selected' : '' }}>Junior (0-2 años)</option>
                        <option value="semi-senior" {{ old('nivel_experiencia') == 'semi-senior' ? 'selected' : '' }}>Semi-Senior (2-4 años)</option>
                        <option value="senior" {{ old('nivel_experiencia') == 'senior' ? 'selected' : '' }}>Senior (4-7 años)</option>
                        <option value="experto" {{ old('nivel_experiencia') == 'experto' ? 'selected' : '' }}>Experto (7+ años)</option>
                    </select>
                    @error('nivel_experiencia')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
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
                           value="{{ old('zona_trabajo') }}"
                           placeholder="Ej: Santiago Centro, Providencia"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('zona_trabajo') border-red-500 @enderror">
                    @error('zona_trabajo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Horario de Trabajo -->
                <div>
                    <label for="horario_trabajo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Horario de Trabajo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="horario_trabajo" 
                           name="horario_trabajo" 
                           value="{{ old('horario_trabajo') }}"
                           placeholder="Ej: Lunes a Viernes 9:00-18:00"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('horario_trabajo') border-red-500 @enderror">
                    @error('horario_trabajo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salario Base -->
                <div>
                    <label for="salario_base" class="block text-sm font-semibold text-gray-700 mb-2">
                        Salario Base Mensual ($) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="salario_base" 
                           name="salario_base" 
                           value="{{ old('salario_base') }}"
                           step="0.01"
                           min="0"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('salario_base') border-red-500 @enderror">
                    @error('salario_base')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comisión por Orden -->
                <div class="md:col-span-2">
                    <label for="comision_por_orden" class="block text-sm font-semibold text-gray-700 mb-2">
                        Comisión por Orden ($)
                    </label>
                    <input type="number" 
                           id="comision_por_orden" 
                           name="comision_por_orden" 
                           value="{{ old('comision_por_orden', 0) }}"
                           step="0.01"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Monto que recibe por cada orden completada.</p>
                </div>
            </div>
        </div>

        <!-- Especialidades -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                <i class="fas fa-tools mr-2 text-sky-600"></i>
                Especialidades y Certificaciones
            </h3>
            
            <!-- Especialidades -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Especialidades <span class="text-red-500">*</span>
                </label>
                <p class="text-sm text-gray-600 mb-3">Selecciona o agrega las especialidades del técnico</p>
                
                <div id="especialidades-container" class="flex flex-wrap gap-2 mb-3 min-h-[40px] p-2 border border-gray-200 rounded-lg">
                    <!-- Las especialidades seleccionadas aparecerán aquí -->
                </div>
                
                <div class="flex gap-2">
                    <input type="text" 
                           id="nueva-especialidad" 
                           placeholder="Ej: Reparación de Pantallas"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <button type="button" 
                            onclick="agregarEspecialidad()"
                            class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i> Agregar
                    </button>
                </div>
                
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" onclick="agregarEspecialidadPredefinida('Reparación de Smartphones')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm transition-colors">+ Smartphones</button>
                    <button type="button" onclick="agregarEspecialidadPredefinida('Reparación de Laptops')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm transition-colors">+ Laptops</button>
                    <button type="button" onclick="agregarEspecialidadPredefinida('Reparación de Tablets')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm transition-colors">+ Tablets</button>
                    <button type="button" onclick="agregarEspecialidadPredefinida('Reparación de Consolas')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm transition-colors">+ Consolas</button>
                    <button type="button" onclick="agregarEspecialidadPredefinida('Cambio de Pantallas')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm transition-colors">+ Pantallas</button>
                    <button type="button" onclick="agregarEspecialidadPredefinida('Reparación de Baterías')" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm transition-colors">+ Baterías</button>
                </div>
                
                @error('especialidades')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Certificaciones -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Certificaciones
                </label>
                <p class="text-sm text-gray-600 mb-3">Agrega certificaciones o cursos completados (opcional)</p>
                
                <div id="certificaciones-container" class="flex flex-wrap gap-2 mb-3 min-h-[40px] p-2 border border-gray-200 rounded-lg">
                    <!-- Las certificaciones aparecerán aquí -->
                </div>
                
                <div class="flex gap-2">
                    <input type="text" 
                           id="nueva-certificacion" 
                           placeholder="Ej: Certificación Apple"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <button type="button" 
                            onclick="agregarCertificacion()"
                            class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        <!-- Información del Servicio y Rol -->
        <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-xl border-2 border-sky-200 p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <i class="fas fa-building text-2xl text-sky-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-sky-800 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Asignación Automática
                    </h3>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 bg-white p-3 rounded-lg">
                            <i class="fas fa-building text-sky-500"></i>
                            <span class="text-gray-700">Servicio Técnico:</span>
                            <strong class="text-sky-700">{{ $servicioTecnico->nombre_servicio }}</strong>
                        </div>
                        <div class="flex items-center gap-2 bg-white p-3 rounded-lg">
                            <i class="fas fa-user-shield text-green-500"></i>
                            <span class="text-gray-700">Rol del Sistema:</span>
                            <strong class="text-green-700">Técnico</strong>
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Automático</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-3 flex items-start gap-2">
                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                        <span>El técnico tendrá acceso al sistema con permisos de técnico y podrá gestionar órdenes de servicio</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center bg-gray-50 p-6 rounded-xl">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <i class="fas fa-lightbulb text-yellow-500"></i>
                <span>Revisa toda la información antes de guardar</span>
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.gestion-tecnicos') }}" 
                   class="flex-1 sm:flex-none px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all text-center font-medium shadow-sm">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
                <button type="submit" 
                        class="flex-1 sm:flex-none px-8 py-3 bg-gradient-to-r from-sky-600 to-blue-600 text-white rounded-lg hover:from-sky-700 hover:to-blue-700 transition-all font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-user-plus mr-2"></i>Crear Técnico
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let especialidades = [];
let certificaciones = [];

function agregarEspecialidad() {
    const input = document.getElementById('nueva-especialidad');
    const especialidad = input.value.trim();
    
    if (especialidad && !especialidades.includes(especialidad)) {
        especialidades.push(especialidad);
        actualizarEspecialidades();
        input.value = '';
    }
}

function agregarEspecialidadPredefinida(especialidad) {
    if (!especialidades.includes(especialidad)) {
        especialidades.push(especialidad);
        actualizarEspecialidades();
    }
}

function eliminarEspecialidad(index) {
    especialidades.splice(index, 1);
    actualizarEspecialidades();
}

function actualizarEspecialidades() {
    const container = document.getElementById('especialidades-container');
    container.innerHTML = '';
    
    if (especialidades.length === 0) {
        container.innerHTML = '<p class="text-gray-400 text-sm">No hay especialidades agregadas</p>';
        return;
    }
    
    especialidades.forEach((esp, index) => {
        const tag = document.createElement('div');
        tag.className = 'flex items-center gap-2 px-3 py-2 bg-sky-100 text-sky-800 rounded-lg transition-all hover:bg-sky-200';
        tag.innerHTML = `
            <span>${esp}</span>
            <button type="button" onclick="eliminarEspecialidad(${index})" class="text-sky-600 hover:text-sky-800 ml-1">
                <i class="fas fa-times"></i>
            </button>
            <input type="hidden" name="especialidades[]" value="${esp}">
        `;
        container.appendChild(tag);
    });
}

function agregarCertificacion() {
    const input = document.getElementById('nueva-certificacion');
    const certificacion = input.value.trim();
    
    if (certificacion && !certificaciones.includes(certificacion)) {
        certificaciones.push(certificacion);
        actualizarCertificaciones();
        input.value = '';
    }
}

function eliminarCertificacion(index) {
    certificaciones.splice(index, 1);
    actualizarCertificaciones();
}

function actualizarCertificaciones() {
    const container = document.getElementById('certificaciones-container');
    container.innerHTML = '';
    
    if (certificaciones.length === 0) {
        container.innerHTML = '<p class="text-gray-400 text-sm">No hay certificaciones agregadas</p>';
        return;
    }
    
    certificaciones.forEach((cert, index) => {
        const tag = document.createElement('div');
        tag.className = 'flex items-center gap-2 px-3 py-2 bg-green-100 text-green-800 rounded-lg transition-all hover:bg-green-200';
        tag.innerHTML = `
            <i class="fas fa-certificate"></i>
            <span>${cert}</span>
            <button type="button" onclick="eliminarCertificacion(${index})" class="text-green-600 hover:text-green-800 ml-1">
                <i class="fas fa-times"></i>
            </button>
            <input type="hidden" name="certificaciones[]" value="${cert}">
        `;
        container.appendChild(tag);
    });
}

// Permitir agregar especialidad con Enter
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nueva-especialidad').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            agregarEspecialidad();
        }
    });

    // Permitir agregar certificación con Enter
    document.getElementById('nueva-certificacion').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            agregarCertificacion();
        }
    });
    
    // Inicializar contenedores vacíos
    actualizarEspecialidades();
    actualizarCertificaciones();
});
</script>

@endsection