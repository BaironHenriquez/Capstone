<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Técnico - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-section {
            animation: slideInUp 0.6s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .skill-tag {
            transition: all 0.2s ease;
        }

        .skill-tag:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-tech-dark-blue shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools text-2xl text-white mr-3"></i>
                        <span class="text-white text-xl font-bold">TechService Pro</span>
                    </div>
                    <div class="ml-8">
                        <h1 class="text-white text-lg font-semibold">
                            <i class="fas fa-user-plus mr-2"></i>
                            Crear Nuevo Técnico
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.gestion-tecnicos') }}" class="text-white hover:text-gray-300 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver a Gestión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
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

        <form method="POST" action="{{ route('admin.tecnicos.store') }}" class="space-y-8">
            @csrf
            
            <!-- Información Personal -->
            <div class="bg-white rounded-xl shadow-lg p-6 form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                    <i class="fas fa-user mr-2 text-capstone-600"></i>
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
                               value="{{ old('nombre') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('nombre') border-red-500 @enderror">
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
                               value="{{ old('apellido') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('apellido') border-red-500 @enderror">
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
                               value="{{ old('rut') }}"
                               required
                               placeholder="12.345.678-9"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('rut') border-red-500 @enderror">
                        @error('rut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono') }}"
                               required
                               placeholder="+56 9 1234 5678"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('telefono') border-red-500 @enderror">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Credenciales -->
            <div class="bg-white rounded-xl shadow-lg p-6 form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                    <i class="fas fa-key mr-2 text-capstone-600"></i>
                    Credenciales de Acceso
                </h2>
                
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors">
                    </div>
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="bg-white rounded-xl shadow-lg p-6 form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                    <i class="fas fa-briefcase mr-2 text-capstone-600"></i>
                    Información Laboral
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Rol -->
                    <div>
                        <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rol <span class="text-red-500">*</span>
                        </label>
                        <select name="role_id" 
                                id="role_id" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('role_id') border-red-500 @enderror">
                            <option value="">Seleccionar rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->nombre) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Servicio Técnico -->
                    <div>
                        <label for="servicio_tecnico_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Servicio Técnico <span class="text-red-500">*</span>
                        </label>
                        <select name="servicio_tecnico_id" 
                                id="servicio_tecnico_id" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('servicio_tecnico_id') border-red-500 @enderror">
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

                    <!-- Técnico Asociado -->
                    <div>
                        <label for="tecnico_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Técnico Supervisor
                        </label>
                        <select name="tecnico_id" 
                                id="tecnico_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors">
                            <option value="">Sin supervisor</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ old('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                                    {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipo de Trabajo -->
                    <div>
                        <label for="tipo_trabajo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Trabajo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="tipo_trabajo" 
                               name="tipo_trabajo" 
                               value="{{ old('tipo_trabajo') }}"
                               required
                               placeholder="ej: Reparación de computadoras"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('tipo_trabajo') border-red-500 @enderror">
                        @error('tipo_trabajo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nivel de Experiencia -->
                    <div>
                        <label for="nivel_experiencia" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nivel de Experiencia <span class="text-red-500">*</span>
                        </label>
                        <select name="nivel_experiencia" 
                                id="nivel_experiencia" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('nivel_experiencia') border-red-500 @enderror">
                            <option value="">Seleccionar nivel</option>
                            <option value="junior" {{ old('nivel_experiencia') == 'junior' ? 'selected' : '' }}>Junior (0-2 años)</option>
                            <option value="intermedio" {{ old('nivel_experiencia') == 'intermedio' ? 'selected' : '' }}>Intermedio (2-5 años)</option>
                            <option value="senior" {{ old('nivel_experiencia') == 'senior' ? 'selected' : '' }}>Senior (5+ años)</option>
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
                               value="{{ old('zona_trabajo') }}"
                               required
                               placeholder="ej: Santiago Centro"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('zona_trabajo') border-red-500 @enderror">
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
                               value="{{ old('telefono_trabajo') }}"
                               placeholder="Opcional - Si es diferente al personal"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors">
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
                               required
                               placeholder="ej: Lunes a Viernes 9:00-18:00"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('horario_trabajo') border-red-500 @enderror">
                        @error('horario_trabajo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salario por Hora -->
                    <div>
                        <label for="salario_por_hora" class="block text-sm font-semibold text-gray-700 mb-2">
                            Salario por Hora (CLP) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="salario_por_hora" 
                               name="salario_por_hora" 
                               value="{{ old('salario_por_hora') }}"
                               required
                               min="0"
                               step="0.01"
                               placeholder="15000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent transition-colors @error('salario_por_hora') border-red-500 @enderror">
                        @error('salario_por_hora')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Habilidades -->
            <div class="bg-white rounded-xl shadow-lg p-6 form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-3">
                    <i class="fas fa-tools mr-2 text-capstone-600"></i>
                    Habilidades Técnicas
                </h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Seleccionar Habilidades <span class="text-red-500">*</span>
                    </label>
                    <p class="text-sm text-gray-600 mb-4">Selecciona las habilidades técnicas del trabajador</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3" id="habilidades-container">
                    @php
                    $habilidadesDisponibles = [
                        'Reparación PC', 'Reparación Laptops', 'Reparación Móviles', 'Instalación Software',
                        'Mantenimiento Hardware', 'Soporte Técnico', 'Redes e Internet', 'Sistemas Operativos',
                        'Recuperación de Datos', 'Instalación Antivirus', 'Configuración Email', 'Backup y Restore',
                        'Diagnóstico Hardware', 'Limpieza Equipos', 'Actualización Sistemas', 'Consultoría TI'
                    ];
                    @endphp
                    
                    @foreach($habilidadesDisponibles as $habilidad)
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-capstone-50 transition-colors skill-tag">
                            <input type="checkbox" 
                                   name="habilidades[]" 
                                   value="{{ $habilidad }}" 
                                   {{ in_array($habilidad, old('habilidades', [])) ? 'checked' : '' }}
                                   class="mr-3 text-capstone-600 focus:ring-capstone-500">
                            <span class="text-sm text-gray-700">{{ $habilidad }}</span>
                        </label>
                    @endforeach
                </div>
                
                @error('habilidades')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('admin.gestion-tecnicos') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
                <button type="submit" 
                        class="bg-capstone-600 text-white px-6 py-3 rounded-lg hover:bg-capstone-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Crear Técnico
                </button>
            </div>
        </form>
    </div>

    <script>
        // Formateo automático del RUT
        document.getElementById('rut').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\dkK]/g, '');
            if (value.length > 1) {
                value = value.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '-' + value.slice(-1);
            }
            e.target.value = value;
        });

        // Animación de entrada para las secciones
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.form-section');
            sections.forEach((section, index) => {
                section.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>

</body>
</html>