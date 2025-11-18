<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden {{ $orden->numero_orden }} - TechService Pro</title>
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
                            <i class="fas fa-file-invoice mr-2"></i>
                            Orden {{ $orden->numero_orden }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm">{{ auth()->guard('tecnico')->user()->nombre_completo }}</span>
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

            <!-- Estado y Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            Orden #{{ $orden->numero_orden }}
                        </h2>
                        @php
                            $estadoBadges = [
                                'asignada' => ['bg-blue-100 text-blue-800', 'Nueva Asignación'],
                                'diagnostico' => ['bg-yellow-100 text-yellow-800', 'En Diagnóstico'],
                                'en_progreso' => ['bg-purple-100 text-purple-800', 'En Reparación'],
                                'completada' => ['bg-green-100 text-green-800', 'Completada'],
                                'cancelada' => ['bg-red-100 text-red-800', 'Cancelada'],
                            ];
                            [$badge, $texto] = $estadoBadges[$orden->estado] ?? ['bg-gray-100 text-gray-800', 'Desconocido'];
                        @endphp
                        <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $badge }}">
                            <i class="fas fa-circle text-xs mr-2 mt-1"></i>{{ $texto }}
                        </span>
                    </div>
                    
                    <!-- Acciones según el estado -->
                    <div class="flex space-x-3">
                        @if($orden->estado === 'asignada')
                            <button onclick="cambiarEstado('diagnostico')" 
                                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md transition-colors">
                                <i class="fas fa-stethoscope mr-2"></i>Iniciar Diagnóstico
                            </button>
                            <button onclick="cambiarEstado('en_progreso')" 
                                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md transition-colors">
                                <i class="fas fa-play mr-2"></i>Comenzar Reparación
                            </button>
                        @elseif($orden->estado === 'diagnostico')
                            <button onclick="mostrarModalDiagnostico()" 
                                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md transition-colors">
                                <i class="fas fa-file-medical mr-2"></i>Guardar Diagnóstico
                            </button>
                            <button onclick="cambiarEstado('en_progreso')" 
                                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md transition-colors">
                                <i class="fas fa-wrench mr-2"></i>Iniciar Reparación
                            </button>
                        @elseif($orden->estado === 'en_progreso')
                            <button onclick="mostrarModalObservacion()" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                                <i class="fas fa-comment-dots mr-2"></i>Agregar Observación
                            </button>
                            <button onclick="mostrarModalCompletar()" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors">
                                <i class="fas fa-check-circle mr-2"></i>Completar Trabajo
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del Cliente y Equipo -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Cliente -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-purple-600 mr-2"></i>
                        Información del Cliente
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-24">Nombre:</span>
                            <span class="text-sm text-gray-900">{{ $orden->cliente->nombre ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-24">RUT:</span>
                            <span class="text-sm text-gray-900">{{ $orden->cliente->rut ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-24">Teléfono:</span>
                            <span class="text-sm text-gray-900">
                                <a href="tel:{{ $orden->cliente->telefono }}" class="text-purple-600 hover:underline">
                                    {{ $orden->cliente->telefono ?? 'N/A' }}
                                </a>
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-24">Email:</span>
                            <span class="text-sm text-gray-900">
                                <a href="mailto:{{ $orden->cliente->email }}" class="text-purple-600 hover:underline">
                                    {{ $orden->cliente->email ?? 'N/A' }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Equipo -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-laptop text-purple-600 mr-2"></i>
                        Información del Equipo
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-32">Tipo:</span>
                            <span class="text-sm text-gray-900">{{ $orden->equipo->tipo ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-32">Marca:</span>
                            <span class="text-sm text-gray-900">{{ $orden->equipo->marca->nombre ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-32">Modelo:</span>
                            <span class="text-sm text-gray-900">{{ $orden->equipo->modelo ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-32">N° Serie:</span>
                            <span class="text-sm text-gray-900 font-mono">{{ $orden->equipo->numero_serie ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de la Orden -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Detalles del Trabajo
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <span class="text-sm font-medium text-gray-500 block mb-1">Prioridad</span>
                        @php
                            $prioridadBadges = [
                                'baja' => 'bg-gray-100 text-gray-800',
                                'media' => 'bg-blue-100 text-blue-800',
                                'alta' => 'bg-orange-100 text-orange-800',
                                'urgente' => 'bg-red-100 text-red-800',
                            ];
                            $prioridadBadge = $prioridadBadges[$orden->prioridad] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $prioridadBadge }}">
                            {{ ucfirst($orden->prioridad) }}
                        </span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500 block mb-1">Fecha Programada</span>
                        <span class="text-sm text-gray-900">
                            {{ $orden->fecha_programada ? $orden->fecha_programada->format('d/m/Y H:i') : 'No programada' }}
                        </span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500 block mb-1">Fecha Estimada</span>
                        <span class="text-sm text-gray-900">
                            {{ $orden->fecha_estimada_completion ? $orden->fecha_estimada_completion->format('d/m/Y') : 'No definida' }}
                        </span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Descripción del Problema</h4>
                    <p class="text-sm text-gray-600 bg-gray-50 p-4 rounded-md">
                        {{ $orden->descripcion_problema ?? 'No se proporcionó descripción' }}
                    </p>
                </div>

                @if($orden->dictamen_tecnico)
                    <div class="border-t mt-4 pt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-file-medical-alt text-yellow-600 mr-2"></i>
                            Diagnóstico Técnico
                        </h4>
                        <p class="text-sm text-gray-600 bg-yellow-50 p-4 rounded-md border-l-4 border-yellow-400">
                            {{ $orden->dictamen_tecnico }}
                        </p>
                    </div>
                @endif

                @if($orden->observaciones_tecnico)
                    <div class="border-t mt-4 pt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-comment-dots text-blue-600 mr-2"></i>
                            Observaciones del Técnico
                        </h4>
                        <p class="text-sm text-gray-600 bg-blue-50 p-4 rounded-md border-l-4 border-blue-400">
                            {{ $orden->observaciones_tecnico }}
                        </p>
                    </div>
                @endif

                @if($orden->estado === 'completada')
                    <div class="border-t mt-4 pt-4 bg-green-50 p-4 rounded-md">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Fecha de Completado</h4>
                                <p class="text-sm text-gray-900">{{ $orden->fecha_completada?->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Costo Total</h4>
                                <p class="text-xl font-bold text-green-600">${{ number_format($orden->costo_total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Botón Volver -->
            <div class="flex justify-center">
                <a href="{{ route('tecnico.dashboard') }}" 
                   class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Diagnóstico -->
    <div id="modalDiagnostico" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-file-medical text-yellow-600 mr-2"></i>
                        Agregar Diagnóstico
                    </h3>
                    <button onclick="cerrarModalDiagnostico()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="formDiagnostico" onsubmit="guardarDiagnostico(event)">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Diagnóstico Técnico *</label>
                        <textarea name="diagnostico" 
                                  rows="6" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                  placeholder="Describe el diagnóstico del equipo, problema encontrado, causas posibles..."
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="cerrarModalDiagnostico()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Guardar Diagnóstico
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Observación -->
    <div id="modalObservacion" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-comment-dots text-blue-600 mr-2"></i>
                        Agregar Observación
                    </h3>
                    <button onclick="cerrarModalObservacion()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="formObservacion" onsubmit="guardarObservacion(event)">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Técnicas *</label>
                        <textarea name="observacion" 
                                  rows="5" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Notas sobre el trabajo realizado, partes reemplazadas, recomendaciones..."
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="cerrarModalObservacion()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Guardar Observación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Completar (igual que en dashboard) -->
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
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Diagnóstico Final *</label>
                        <textarea name="dictamen_tecnico" 
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                  placeholder="Resumen completo del problema y solución aplicada..."
                                  required>{{ $orden->dictamen_tecnico }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones Técnicas</label>
                        <textarea name="observaciones_tecnico" 
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                  placeholder="Recomendaciones, partes reemplazadas, etc...">{{ $orden->observaciones_tecnico }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Costo Total *</label>
                            <input type="number" 
                                   name="costo_total" 
                                   step="0.01" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="0.00"
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Completado *</label>
                            <input type="date" 
                                   name="fecha_completada" 
                                   value="{{ date('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   required>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" 
                                onclick="cerrarModalCompletar()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Cancelar
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
        const ordenId = {{ $orden->id }};

        function cambiarEstado(nuevoEstado) {
            if (!confirm(`¿Cambiar estado a "${nuevoEstado.replace('_', ' ')}"?`)) return;

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
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Error al actualizar el estado'));
        }

        function mostrarModalDiagnostico() {
            document.getElementById('modalDiagnostico').classList.remove('hidden');
        }

        function cerrarModalDiagnostico() {
            document.getElementById('modalDiagnostico').classList.add('hidden');
        }

        function guardarDiagnostico(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            fetch(`/tecnico/ordenes/${ordenId}/agregar-diagnostico`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ diagnostico: formData.get('diagnostico') })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Diagnóstico guardado exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }

        function mostrarModalObservacion() {
            document.getElementById('modalObservacion').classList.remove('hidden');
        }

        function cerrarModalObservacion() {
            document.getElementById('modalObservacion').classList.add('hidden');
        }

        function guardarObservacion(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            fetch(`/tecnico/ordenes/${ordenId}/agregar-observacion`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ observacion: formData.get('observacion') })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Observación guardada exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }

        function mostrarModalCompletar() {
            document.getElementById('modalCompletar').classList.remove('hidden');
        }

        function cerrarModalCompletar() {
            document.getElementById('modalCompletar').classList.add('hidden');
        }

        function completarOrden(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            
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
                    alert('Error: ' + data.message);
                }
            });
        }
    </script>
</body>
</html>
