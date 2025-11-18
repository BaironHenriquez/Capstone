<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Órdenes - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    
    <!-- Navigation Header -->
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('tecnico.dashboard') }}" class="text-white hover:text-gray-200 mr-4">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools text-2xl text-white mr-3"></i>
                        <span class="text-white text-xl font-bold">TechService Pro</span>
                    </div>
                    <div class="ml-8">
                        <h1 class="text-white text-lg font-semibold">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            Todas mis Órdenes
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm">{{ $tecnico->nombre_completo }}</span>
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

            <!-- Filtros Rápidos -->
            <div class="mb-6 flex flex-wrap gap-3">
                <button onclick="filtrarPorEstado('todas')" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                    <i class="fas fa-list mr-2"></i>Todas
                </button>
                <button onclick="filtrarPorEstado('asignada')" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                    <i class="fas fa-inbox mr-2"></i>Nuevas
                </button>
                <button onclick="filtrarPorEstado('diagnostico')" class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-md hover:bg-yellow-200 transition-colors">
                    <i class="fas fa-stethoscope mr-2"></i>Diagnóstico
                </button>
                <button onclick="filtrarPorEstado('en_progreso')" class="px-4 py-2 bg-purple-100 text-purple-800 rounded-md hover:bg-purple-200 transition-colors">
                    <i class="fas fa-tools mr-2"></i>En Progreso
                </button>
                <button onclick="filtrarPorEstado('completada')" class="px-4 py-2 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                    <i class="fas fa-check-circle mr-2"></i>Completadas
                </button>
            </div>

            <!-- Tabla de Órdenes -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-tasks mr-2 text-purple-600"></i>
                        Listado Completo de Órdenes
                    </h2>
                </div>

                @if($ordenes->isEmpty())
                    <div class="p-12 text-center">
                        <i class="fas fa-clipboard text-6xl text-gray-300 mb-4"></i>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No hay órdenes asignadas</h3>
                        <p class="mt-1 text-sm text-gray-500">Actualmente no tienes órdenes de trabajo asignadas.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Orden</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Programada</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tablaOrdenes">
                                @foreach($ordenes as $orden)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200 orden-row" data-estado="{{ $orden->estado }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-purple-600">{{ $orden->numero_orden }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $orden->cliente->nombre ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">{{ $orden->cliente->telefono ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $orden->equipo->modelo ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">{{ $orden->equipo->marca->nombre ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $estadoBadges = [
                                                    'asignada' => 'bg-blue-100 text-blue-800',
                                                    'diagnostico' => 'bg-yellow-100 text-yellow-800',
                                                    'en_progreso' => 'bg-purple-100 text-purple-800',
                                                    'completada' => 'bg-green-100 text-green-800',
                                                ];
                                                $badge = $estadoBadges[$orden->estado] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge }}">
                                                {{ ucfirst($orden->estado) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $prioridadBadges = [
                                                    'baja' => 'bg-gray-100 text-gray-800',
                                                    'media' => 'bg-blue-100 text-blue-800',
                                                    'alta' => 'bg-orange-100 text-orange-800',
                                                    'urgente' => 'bg-red-100 text-red-800',
                                                ];
                                                $prioridadBadge = $prioridadBadges[$orden->prioridad] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $prioridadBadge }}">
                                                {{ ucfirst($orden->prioridad) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $orden->fecha_programada ? $orden->fecha_programada->format('d/m/Y') : 'No programada' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('tecnico.ordenes.show', $orden->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                <i class="fas fa-eye mr-1"></i>Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $ordenes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function filtrarPorEstado(estado) {
            const filas = document.querySelectorAll('.orden-row');
            
            filas.forEach(fila => {
                if (estado === 'todas' || fila.dataset.estado === estado) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
