<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Baieco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools text-2xl text-white mr-3"></i>
                        <span class="text-white text-xl font-bold">Baieco</span>
                    </div>
                    <div class="ml-8 flex space-x-6">
                        <a href="{{ route('tecnico.dashboard') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('tecnico.ganancias') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
                            <i class="fas fa-dollar-sign mr-2"></i>Ganancias
                        </a>
                        <a href="{{ route('tecnico.ordenes-trabajadas') }}" class="text-white hover:text-purple-200 transition-colors flex items-center">
                            <i class="fas fa-history mr-2"></i>Órdenes Trabajadas
                        </a>
                        <a href="{{ route('tecnico.perfil') }}" class="text-white font-semibold border-b-2 border-white flex items-center">
                            <i class="fas fa-user mr-2"></i>Perfil
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</span>
                    <form method="POST" action="{{ route('tecnico.logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-user-circle mr-2 text-purple-600"></i>Mi Perfil
                </h1>
                <p class="text-gray-600">Gestiona tu información personal y configuración de cuenta</p>
            </div>

            <!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-xl mr-3"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-xl mr-3 mt-1"></i>
                        <div>
                            <p class="font-semibold mb-2">Por favor, corrija los siguientes errores:</p>
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Columna Izquierda: Estadísticas del Técnico -->
                <div class="lg:col-span-1">
                    <!-- Tarjeta de Perfil -->
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full mb-4">
                                <i class="fas fa-user text-4xl text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $tecnico->email }}</p>
                            <div class="flex items-center justify-center text-yellow-500 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($estadisticas['calificacion_promedio'] ?? 0))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600 text-sm">
                                    ({{ number_format($estadisticas['calificacion_promedio'] ?? 0, 1) }})
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-chart-bar mr-2 text-purple-600"></i>Estadísticas
                        </h4>
                        <div class="space-y-4">
                            <!-- Total Órdenes -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-tasks text-blue-600"></i>
                                    </div>
                                    <span class="text-sm text-gray-600">Total Órdenes</span>
                                </div>
                                <span class="text-lg font-bold text-gray-900">{{ $estadisticas['total_ordenes'] }}</span>
                            </div>

                            <!-- Completadas -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    </div>
                                    <span class="text-sm text-gray-600">Completadas</span>
                                </div>
                                <span class="text-lg font-bold text-green-600">{{ $estadisticas['completadas'] }}</span>
                            </div>

                            <!-- En Progreso -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-spinner text-yellow-600"></i>
                                    </div>
                                    <span class="text-sm text-gray-600">En Progreso</span>
                                </div>
                                <span class="text-lg font-bold text-yellow-600">{{ $estadisticas['en_progreso'] }}</span>
                            </div>

                            <!-- Total Ganado -->
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                <div class="flex items-center">
                                    <div class="bg-green-500 p-2 rounded-lg mr-3">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">Total Ganado</span>
                                </div>
                                <span class="text-lg font-bold text-green-700">
                                    ${{ number_format($estadisticas['total_ganado'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Formularios -->
                <div class="lg:col-span-2">
                    
                    <!-- Información Personal -->
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-6">
                            <i class="fas fa-id-card mr-2 text-purple-600"></i>Información Personal
                        </h4>
                        <form method="POST" action="{{ route('tecnico.perfil.actualizar') }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nombre -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-1"></i>Nombre
                                    </label>
                                    <input type="text" name="nombre" 
                                        value="{{ old('nombre', $tecnico->nombre) }}" 
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nombre') border-red-500 @enderror">
                                    @error('nombre')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellido -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-1"></i>Apellido
                                    </label>
                                    <input type="text" name="apellido" 
                                        value="{{ old('apellido', $tecnico->apellido) }}" 
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('apellido') border-red-500 @enderror">
                                    @error('apellido')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-1"></i>Correo Electrónico
                                    </label>
                                    <input type="email" name="email" 
                                        value="{{ old('email', $tecnico->email) }}" 
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-phone mr-1"></i>Teléfono
                                    </label>
                                    <input type="tel" name="telefono" 
                                        value="{{ old('telefono', $tecnico->telefono) }}" 
                                        placeholder="+56 9 1234 5678"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('telefono') border-red-500 @enderror">
                                    @error('telefono')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Especialidades -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-tools mr-1"></i>Especialidades
                                    </label>
                                    <input type="text" name="especialidades" 
                                        value="{{ old('especialidades', $tecnico->especialidades) }}" 
                                        placeholder="Ej: Hardware, Redes, Software"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('especialidades') border-red-500 @enderror">
                                    @error('especialidades')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-6">
                            <i class="fas fa-lock mr-2 text-red-600"></i>Cambiar Contraseña
                        </h4>
                        <form method="POST" action="{{ route('tecnico.perfil.actualizar') }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <!-- Nueva Contraseña -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-key mr-1"></i>Nueva Contraseña
                                    </label>
                                    <input type="password" name="password" 
                                        minlength="8"
                                        placeholder="Mínimo 8 caracteres"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-key mr-1"></i>Confirmar Nueva Contraseña
                                    </label>
                                    <input type="password" name="password_confirmation" 
                                        minlength="8"
                                        placeholder="Repite la contraseña"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>

                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                    <div class="flex">
                                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                                        <div>
                                            <p class="text-sm text-blue-700">
                                                <strong>Requisitos de contraseña:</strong>
                                            </p>
                                            <ul class="text-sm text-blue-600 list-disc list-inside mt-2">
                                                <li>Mínimo 8 caracteres</li>
                                                <li>Deja en blanco si no deseas cambiarla</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    <i class="fas fa-shield-alt mr-2"></i>Actualizar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

</body>
</html>
