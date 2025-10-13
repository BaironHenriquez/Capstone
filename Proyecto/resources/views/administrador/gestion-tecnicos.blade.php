<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Técnicos - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dashboard-card {
            animation: fadeInScale 0.6s ease-out;
        }
        
        .dashboard-metric {
            animation: slideInUp 0.5s ease-out;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .animate-slide-down {
            animation: slideDown 0.6s ease-out;
        }

        .tech-card {
            transition: all 0.3s ease;
        }

        .tech-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .status-badge {
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-tech-dark-blue shadow-lg sticky top-0 z-50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools text-2xl text-white mr-3"></i>
                        <span class="text-white text-xl font-bold">TechService Pro</span>
                    </div>
                    <div class="ml-8">
                        <h1 class="text-white text-lg font-semibold">
                            <i class="fas fa-users-cog mr-2"></i>
                            Gestión de Técnicos
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard-admin') }}" class="text-white hover:text-gray-300 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                    </a>
                    <div class="relative">
                        <i class="fas fa-user-circle text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Alertas -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg animate-slide-down">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg animate-slide-down">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg dashboard-card hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Técnicos</p>
                        <p class="text-3xl font-bold text-capstone-700">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-capstone-100 p-3 rounded-lg">
                        <i class="fas fa-users text-capstone-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg dashboard-card hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Activos</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['activos'] }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-user-check text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg dashboard-card hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Inactivos</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['inactivos'] }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="fas fa-user-minus text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg dashboard-card hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Baneados</p>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['baneados'] }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-lg">
                        <i class="fas fa-user-slash text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones y Filtros -->
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8 dashboard-card">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-filter mr-2 text-capstone-600"></i>
                        Filtros y Búsqueda
                    </h2>
                    
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Búsqueda -->
                        <div class="md:col-span-1">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}"
                                   placeholder="Buscar técnico..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent">
                        </div>
                        
                        <!-- Estado -->
                        <div>
                            <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent">
                                <option value="todos">Todos los estados</option>
                                <option value="activo" {{ $estado == 'activo' ? 'selected' : '' }}>Activos</option>
                                <option value="inactivo" {{ $estado == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                                <option value="baneado" {{ $estado == 'baneado' ? 'selected' : '' }}>Baneados</option>
                            </select>
                        </div>
                        
                        <!-- Servicio -->
                        <div>
                            <select name="servicio" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-capstone-500 focus:border-transparent">
                                <option value="todos">Todos los servicios</option>
                                @foreach($serviciosTecnicos as $servicioTecnico)
                                    <option value="{{ $servicioTecnico->id }}" {{ $servicio == $servicioTecnico->id ? 'selected' : '' }}>
                                        {{ $servicioTecnico->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Botón buscar -->
                        <div>
                            <button type="submit" class="w-full bg-capstone-600 text-white px-4 py-2 rounded-lg hover:bg-capstone-700 transition-colors">
                                <i class="fas fa-search mr-2"></i>Filtrar
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.tecnicos.create') }}" 
                       class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors inline-flex items-center shadow-lg hover-lift">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Técnico
                    </a>
                </div>
            </div>
        </div>

        <!-- Lista de Técnicos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tecnicos as $tecnico)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden tech-card hover-lift">
                    <!-- Header con estado -->
                    <div class="bg-gradient-to-r from-capstone-500 to-capstone-600 p-4">
                        <div class="flex justify-between items-start">
                            <div class="text-white">
                                <h3 class="text-lg font-bold">{{ $tecnico->nombre }} {{ $tecnico->apellido }}</h3>
                                <p class="text-capstone-100 text-sm">{{ $tecnico->email }}</p>
                            </div>
                            <div class="flex flex-col items-end">
                                @if($tecnico->trabajador)
                                    @switch($tecnico->trabajador->estado)
                                        @case('activo')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full status-badge">
                                                <i class="fas fa-check-circle mr-1"></i>Activo
                                            </span>
                                            @break
                                        @case('inactivo')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full status-badge">
                                                <i class="fas fa-pause-circle mr-1"></i>Inactivo
                                            </span>
                                            @break
                                        @case('baneado')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full status-badge">
                                                <i class="fas fa-ban mr-1"></i>Baneado
                                            </span>
                                            @break
                                    @endswitch
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información del técnico -->
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- RUT y Teléfono -->
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-id-card mr-2 text-capstone-500 w-4"></i>
                                <span>{{ $tecnico->rut }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-phone mr-2 text-capstone-500 w-4"></i>
                                <span>{{ $tecnico->telefono }}</span>
                            </div>

                            <!-- Rol -->
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user-tag mr-2 text-capstone-500 w-4"></i>
                                <span>{{ $tecnico->role ? ucfirst($tecnico->role->nombre) : 'Sin rol' }}</span>
                            </div>

                            <!-- Servicio Técnico -->
                            @if($tecnico->servicioTecnico)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-building mr-2 text-capstone-500 w-4"></i>
                                    <span>{{ $tecnico->servicioTecnico->nombre }}</span>
                                </div>
                            @endif

                            <!-- Información adicional del trabajador -->
                            @if($tecnico->trabajador)
                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <i class="fas fa-tools mr-2 text-capstone-500 w-4"></i>
                                        <span>{{ ucfirst($tecnico->trabajador->nivel_experiencia) }}</span>
                                    </div>
                                    
                                    @if($tecnico->trabajador->habilidades)
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            @foreach(array_slice($tecnico->trabajador->habilidades, 0, 3) as $habilidad)
                                                <span class="bg-capstone-100 text-capstone-700 text-xs px-2 py-1 rounded-full">
                                                    {{ $habilidad }}
                                                </span>
                                            @endforeach
                                            @if(count($tecnico->trabajador->habilidades) > 3)
                                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                                    +{{ count($tecnico->trabajador->habilidades) - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Acciones -->
                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('admin.tecnicos.edit', $tecnico->id) }}" 
                               class="flex-1 bg-blue-600 text-white text-center px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                <i class="fas fa-edit mr-1"></i>Editar
                            </a>
                            
                            @if($tecnico->trabajador)
                                @if($tecnico->trabajador->estado !== 'baneado')
                                    <form method="POST" action="{{ route('admin.tecnicos.ban', $tecnico->id) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-orange-600 text-white px-3 py-2 rounded-lg hover:bg-orange-700 transition-colors text-sm"
                                                onclick="return confirm('¿Estás seguro de banear este técnico?')">
                                            <i class="fas fa-ban mr-1"></i>Banear
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.tecnicos.ban', $tecnico->id) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                            <i class="fas fa-user-check mr-1"></i>Desbanear
                                        </button>
                                    </form>
                                @endif
                            @endif
                            
                            <form method="POST" action="{{ route('admin.tecnicos.destroy', $tecnico->id) }}" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm"
                                        onclick="return confirm('¿Estás seguro de eliminar este técnico? Esta acción no se puede deshacer.')">
                                    <i class="fas fa-trash mr-1"></i>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron técnicos</h3>
                        <p class="text-gray-500 mb-6">No hay técnicos que coincidan con los filtros seleccionados.</p>
                        <a href="{{ route('admin.tecnicos.create') }}" 
                           class="bg-capstone-600 text-white px-6 py-3 rounded-lg hover:bg-capstone-700 transition-colors inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Primer Técnico
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($tecnicos->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-xl shadow-lg p-4">
                    {{ $tecnicos->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Script para confirmaciones -->
    <script>
        // Animación de entrada para las tarjetas
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.tech-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('dashboard-card');
            });
        });
    </script>

</body>
</html>