@extends('shared.layouts.admin')

@section('title', 'Asignar Órdenes de Servicio')

@section('header')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.gestion-tecnicos') }}" 
               class="bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <i class="fas fa-arrow-left text-sky-600"></i>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-sky-800">Asignar Órdenes de Servicio</h2>
                <p class="text-gray-600 mt-1">Gestiona las asignaciones de {{ $tecnico->nombre_completo }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Panel izquierdo - Información del Técnico -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
            <!-- Avatar y nombre -->
            <div class="text-center mb-6">
                <div class="w-24 h-24 bg-gradient-to-br from-sky-400 to-blue-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold mb-3">
                    {{ strtoupper(substr($tecnico->nombre, 0, 1) . substr($tecnico->apellido, 0, 1)) }}
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ $tecnico->nombre_completo }}</h3>
                <p class="text-sm text-gray-600">{{ $tecnico->email }}</p>
                <span class="inline-block mt-2 px-3 py-1 bg-{{ $tecnico->disponible ? 'green' : 'gray' }}-100 text-{{ $tecnico->disponible ? 'green' : 'gray' }}-700 rounded-full text-xs font-medium">
                    {{ $tecnico->disponible ? 'Disponible' : 'No disponible' }}
                </span>
            </div>

            <!-- Estadísticas -->
            <div class="space-y-4 mb-6">
                <div class="bg-gradient-to-r from-{{ $cargaTrabajo >= 90 ? 'red' : ($cargaTrabajo >= 70 ? 'yellow' : 'blue') }}-50 to-{{ $cargaTrabajo >= 90 ? 'red' : ($cargaTrabajo >= 70 ? 'yellow' : 'blue') }}-100 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Carga de Trabajo</p>
                            <p class="text-2xl font-bold text-{{ $cargaTrabajo >= 90 ? 'red' : ($cargaTrabajo >= 70 ? 'yellow' : 'blue') }}-700">{{ round($cargaTrabajo) }}%</p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if($estadoTecnico === 'sobrecargado')
                                    <i class="fas fa-exclamation-triangle text-red-500"></i> Sobrecargado
                                @elseif($estadoTecnico === 'activo')
                                    <i class="fas fa-clock text-yellow-500"></i> Activo
                                @else
                                    <i class="fas fa-check-circle text-green-500"></i> Disponible
                                @endif
                            </p>
                        </div>
                        <i class="fas fa-chart-line text-3xl text-{{ $cargaTrabajo >= 90 ? 'red' : ($cargaTrabajo >= 70 ? 'yellow' : 'blue') }}-400"></i>
                    </div>
                    <div class="mt-3 bg-white rounded-full h-3 overflow-hidden shadow-inner">
                        <div class="bg-{{ $cargaTrabajo >= 90 ? 'red' : ($cargaTrabajo >= 70 ? 'yellow' : 'blue') }}-600 h-full transition-all duration-500" style="width: {{ round($cargaTrabajo) }}%"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-purple-50 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-600 mb-1">Órdenes Activas</p>
                        <p class="text-xl font-bold text-purple-700">{{ $ordenesActivas->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center">
                        <p class="text-xs text-gray-600 mb-1">Completadas</p>
                        <p class="text-xl font-bold text-green-700">{{ $ordenesCompletadas }}</p>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="border-t pt-4 space-y-3">
                <div class="flex items-center text-sm">
                    <i class="fas fa-briefcase w-5 text-gray-400"></i>
                    <span class="text-gray-700 ml-2 capitalize">{{ $tecnico->nivel_experiencia }}</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                    <span class="text-gray-700 ml-2">{{ $tecnico->zona_trabajo }}</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class="fas fa-clock w-5 text-gray-400"></i>
                    <span class="text-gray-700 ml-2">{{ $tecnico->horario_trabajo }}</span>
                </div>
            </div>

            <!-- Especialidades -->
            @if(!empty($tecnico->especialidades))
                <div class="border-t pt-4 mt-4">
                    <p class="text-xs font-semibold text-gray-600 mb-2">ESPECIALIDADES</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tecnico->especialidades as $especialidad)
                            <span class="bg-sky-100 text-sky-700 text-xs px-2 py-1 rounded-full">
                                {{ $especialidad }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Panel derecho - Órdenes -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Órdenes Actualmente Asignadas -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-tasks text-purple-600 mr-2"></i>
                    Órdenes Asignadas ({{ $ordenesActivas->count() }})
                </h3>
            </div>

            @if($ordenesActivas->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-600">No hay órdenes asignadas actualmente</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($ordenesActivas as $orden)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-semibold text-gray-900">{{ $orden->numero_orden }}</span>
                                        @php
                                            $estadoColor = match($orden->estado) {
                                                'pendiente' => 'yellow',
                                                'asignada' => 'sky',
                                                'en_proceso' => 'blue',
                                                'diagnostico' => 'purple',
                                                'completado' => 'green',
                                                default => 'gray'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 bg-{{ $estadoColor }}-100 text-{{ $estadoColor }}-700 text-xs rounded-full">
                                            {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">
                                        <i class="fas fa-tools text-gray-400 mr-1"></i>
                                        {{ $orden->descripcion_problema ?? 'Sin descripción' }}
                                    </p>
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $orden->cliente->nombre ?? 'Cliente desconocido' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($orden->fecha_ingreso)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.tecnicos.desasignar', [$tecnico->id, $orden->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="ml-4 text-red-600 hover:text-red-800 transition-colors"
                                            onclick="return confirm('¿Desasignar esta orden?')">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Órdenes Disponibles para Asignar -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-clipboard-check text-green-600 mr-2"></i>
                    Órdenes Disponibles ({{ $ordenesDisponibles->count() }})
                </h3>
            </div>

            <!-- Filtros -->
            <div class="mb-4">
                <input type="text" 
                       id="buscar-orden" 
                       placeholder="Buscar por cliente, equipo o descripción..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500">
            </div>

            @if($ordenesDisponibles->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-600">No hay órdenes disponibles para asignar</p>
                </div>
            @else
                <div class="space-y-3 max-h-[600px] overflow-y-auto">
                    @foreach($ordenesDisponibles as $orden)
                        <div class="orden-item border border-gray-200 rounded-lg p-4 hover:border-green-300 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-semibold text-gray-900">{{ $orden->numero_orden }}</span>
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                            {{ ucfirst($orden->prioridad ?? 'normal') }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">
                                        <i class="fas fa-laptop text-gray-400 mr-1"></i>
                                        {{ $orden->equipo->tipo ?? 'Equipo' }}: {{ $orden->descripcion_problema ?? 'Sin descripción' }}
                                    </p>
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $orden->cliente->nombre ?? 'Cliente' }} {{ $orden->cliente->apellido ?? '' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($orden->fecha_ingreso)->format('d/m/Y') }}
                                        </span>
                                        @if($orden->fecha_compromiso)
                                            <span class="text-orange-600">
                                                <i class="fas fa-clock mr-1"></i>
                                                Entrega: {{ \Carbon\Carbon::parse($orden->fecha_compromiso)->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.tecnicos.asignar.store', $tecnico->id) }}">
                                    @csrf
                                    <input type="hidden" name="orden_id" value="{{ $orden->id }}">
                                    <button type="submit" 
                                            class="ml-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-plus mr-1"></i>Asignar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Búsqueda en tiempo real
document.getElementById('buscar-orden').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const ordenes = document.querySelectorAll('.orden-item');
    
    ordenes.forEach(orden => {
        const text = orden.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            orden.style.display = '';
        } else {
            orden.style.display = 'none';
        }
    });
});
</script>

@endsection
