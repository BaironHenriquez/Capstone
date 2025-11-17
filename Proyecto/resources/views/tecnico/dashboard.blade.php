<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Técnico - TechService Pro</title>
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
                        <span class="text-white text-xl font-bold">TechService Pro</span>
                    </div>
                    <div class="ml-8">
                        <h1 class="text-white text-lg font-semibold">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Panel del Técnico
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

            <!-- Mensaje de Bienvenida -->
            <div class="mb-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">
                            <i class="fas fa-user-tie mr-2"></i>¡Bienvenido, {{ $tecnico->nombre_completo }}!
                        </h2>
                        <p class="text-purple-100">
                            Tienes <strong class="text-white">{{ $estadisticas['pendientes'] + $estadisticas['en_progreso'] }}</strong> órdenes activas que requieren tu atención
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <i class="fas fa-tools text-6xl text-white opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Asignadas</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $estadisticas['asignadas'] }}</p>
                        </div>
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-4">
                            <i class="fas fa-clipboard-list text-2xl text-purple-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Pendientes</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $estadisticas['pendientes'] }}</p>
                        </div>
                        <div class="flex-shrink-0 bg-yellow-100 rounded-full p-4">
                            <i class="fas fa-clock text-2xl text-yellow-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">En Progreso</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $estadisticas['en_progreso'] }}</p>
                        </div>
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-4">
                            <i class="fas fa-tools text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Completadas (Mes)</p>
                            <p class="text-3xl font-bold text-green-600">{{ $estadisticas['completadas_mes'] }}</p>
                        </div>
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-4">
                            <i class="fas fa-check-circle text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Órdenes Asignadas -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-tasks mr-2 text-purple-600"></i>
                        Mis Órdenes de Trabajo Activas
                    </h2>
                    <a href="{{ route('tecnico.ordenes.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md transition-colors">
                        <i class="fas fa-list-ul mr-2"></i>Ver Todas las Órdenes
                    </a>
                </div>

                @if($ordenesAsignadas->isEmpty())
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
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($ordenesAsignadas as $orden)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-purple-600">{{ $orden->numero_orden }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $orden->cliente->nombre ?? 'N/A' }}</div>
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
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- Ver Detalles -->
                                                <a href="{{ route('tecnico.ordenes.show', $orden->id) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-md transition-colors duration-200"
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye mr-1"></i>Ver
                                                </a>
                                                
                                                <!-- Cambiar Estado -->
                                                @if($orden->estado === 'asignada')
                                                    <button onclick="cambiarEstado({{ $orden->id }}, 'en_progreso')" 
                                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors duration-200"
                                                            title="Iniciar trabajo">
                                                        <i class="fas fa-play mr-1"></i>Iniciar
                                                    </button>
                                                @elseif($orden->estado === 'en_progreso')
                                                    <button onclick="mostrarModalCompletar({{ $orden->id }})" 
                                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors duration-200"
                                                            title="Completar orden">
                                                        <i class="fas fa-check mr-1"></i>Completar
                                                    </button>
                                                @elseif($orden->estado === 'diagnostico')
                                                    <button onclick="cambiarEstado({{ $orden->id }}, 'en_progreso')" 
                                                            class="inline-flex items-center px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded-md transition-colors duration-200"
                                                            title="Continuar con reparación">
                                                        <i class="fas fa-wrench mr-1"></i>Reparar
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para completar orden -->
    <div id="modalCompletar" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        Completar Orden de Servicio
                    </h3>
                    <button onclick="cerrarModalCompletar()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="formCompletar" onsubmit="completarOrden(event)">
                    <input type="hidden" id="ordenIdCompletar" name="orden_id">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-medical-alt mr-1"></i>Diagnóstico Final *
                        </label>
                        <textarea name="dictamen_tecnico" 
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                  placeholder="Descripción del problema encontrado y trabajo realizado..."
                                  required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment-dots mr-1"></i>Observaciones Técnicas
                        </label>
                        <textarea name="observaciones_tecnico" 
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                  placeholder="Recomendaciones, partes reemplazadas, etc..."></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign mr-1"></i>Costo Total *
                            </label>
                            <input type="number" 
                                   name="costo_total" 
                                   step="0.01" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   placeholder="0.00"
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-check mr-1"></i>Fecha de Completado *
                            </label>
                            <input type="date" 
                                   name="fecha_completada" 
                                   value="{{ date('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   required>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" 
                                onclick="cerrarModalCompletar()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>Completar Orden
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Cambiar estado de la orden
        function cambiarEstado(ordenId, nuevoEstado) {
            if (!confirm(`¿Estás seguro de cambiar el estado a "${nuevoEstado.replace('_', ' ')}"?`)) {
                return;
            }

            fetch(`/tecnico/ordenes/${ordenId}/actualizar-estado`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ estado: nuevoEstado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar el estado: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el estado');
            });
        }

        // Mostrar modal para completar orden
        function mostrarModalCompletar(ordenId) {
            document.getElementById('ordenIdCompletar').value = ordenId;
            document.getElementById('modalCompletar').classList.remove('hidden');
        }

        // Cerrar modal
        function cerrarModalCompletar() {
            document.getElementById('modalCompletar').classList.add('hidden');
            document.getElementById('formCompletar').reset();
        }

        // Completar orden
        function completarOrden(event) {
            event.preventDefault();
            
            const form = event.target;
            const ordenId = document.getElementById('ordenIdCompletar').value;
            const formData = new FormData(form);
            
            const data = {
                dictamen_tecnico: formData.get('dictamen_tecnico'),
                observaciones_tecnico: formData.get('observaciones_tecnico'),
                costo_total: formData.get('costo_total'),
                fecha_completada: formData.get('fecha_completada')
            };

            fetch(`/tecnico/ordenes/${ordenId}/completar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('¡Orden completada exitosamente!');
                    location.reload();
                } else {
                    alert('Error al completar la orden: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al completar la orden');
            });
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalCompletar').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalCompletar();
            }
        });
    </script>
</body>
</html>
