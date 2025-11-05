@extends('shared.layouts.tecnico')

@section('title', 'Editar Orden de Servicio')

@section('breadcrumb', 'Editar Orden')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-blue-900">📝 Editar Orden de Servicio</h2>
        <a href="{{ route('tecnico.ordenes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Volver
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('tecnico.ordenes.update', $orden->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Orden</label>
                    <input type="text" value="{{ $orden->numero_orden }}" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                    <input type="text" value="{{ $orden->cliente->nombre ?? 'Sin asignar' }}" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                </div>
            </div>

            <!-- Estado y Prioridad -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" id="estado" class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="pendiente" {{ $orden->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ $orden->estado === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completada" {{ $orden->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="retrasada" {{ $orden->estado === 'retrasada' ? 'selected' : '' }}>Retrasada</option>
                    </select>
                </div>

                <div>
                    <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                    <select name="prioridad" id="prioridad" class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="baja" {{ $orden->prioridad === 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ $orden->prioridad === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ $orden->prioridad === 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fecha_programada" class="block text-sm font-medium text-gray-700 mb-2">Fecha Programada</label>
                    <input type="datetime-local" name="fecha_programada" id="fecha_programada" 
                           value="{{ $orden->fecha_programada ? $orden->fecha_programada->format('Y-m-d\TH:i') : '' }}"
                           class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="fecha_aprox_entrega" class="block text-sm font-medium text-gray-700 mb-2">Fecha Aproximada de Entrega</label>
                    <input type="date" name="fecha_aprox_entrega" id="fecha_aprox_entrega" 
                           value="{{ $orden->fecha_aprox_entrega ? $orden->fecha_aprox_entrega->format('Y-m-d') : '' }}"
                           class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Descripción del problema -->
            <div>
                <label for="descripcion_problema" class="block text-sm font-medium text-gray-700 mb-2">Descripción del Problema</label>
                <textarea name="descripcion_problema" id="descripcion_problema" rows="4" 
                          class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $orden->descripcion_problema }}</textarea>
            </div>

            <!-- Dictamen técnico -->
            <div>
                <label for="dictamen_tecnico" class="block text-sm font-medium text-gray-700 mb-2">Dictamen Técnico</label>
                <textarea name="dictamen_tecnico" id="dictamen_tecnico" rows="4" 
                          class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $orden->dictamen_tecnico }}</textarea>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones_tecnico" class="block text-sm font-medium text-gray-700 mb-2">Observaciones del Técnico</label>
                <textarea name="observaciones_tecnico" id="observaciones_tecnico" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $orden->observaciones_tecnico }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('tecnico.ordenes.index') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection