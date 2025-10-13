@extends('layouts.admin')

@section('title', 'Detalle del Cliente')

@section('header')
<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.clientes.index') }}" 
           class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $cliente->nombre_completo }}</h1>
            <p class="mt-2 text-gray-600">Información detallada del cliente y sus órdenes de servicio</p>
        </div>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.clientes.edit', $cliente->id) }}" 
           class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Editar Cliente
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Información General del Cliente -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Personal -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-capstone-500 to-capstone-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Información Personal
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nombre Completo</label>
                            <p class="text-lg font-medium text-gray-900">{{ $cliente->nombre_completo }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">RUT</label>
                            <p class="text-lg font-medium text-gray-900">{{ $cliente->rut }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-lg font-medium text-gray-900">
                                <a href="mailto:{{ $cliente->email }}" class="text-capstone-600 hover:text-capstone-800">
                                    {{ $cliente->email }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Teléfono</label>
                            <p class="text-lg font-medium text-gray-900">
                                <a href="tel:{{ $cliente->telefono }}" class="text-capstone-600 hover:text-capstone-800">
                                    {{ $cliente->telefono }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Empresa</label>
                            <p class="text-lg font-medium text-gray-900">{{ $cliente->empresa ?: 'No especificada' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tipo de Cliente</label>
                            <p class="text-lg font-medium text-gray-900">
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($cliente->tipo_cliente) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Estado</label>
                            <p class="text-lg font-medium text-gray-900">
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $cliente->estado_badge }}">
                                    {{ ucfirst($cliente->estado) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Servicio Técnico</label>
                            <p class="text-lg font-medium text-gray-900">{{ $cliente->servicioTecnico->nombre ?? 'No asignado' }}</p>
                        </div>
                    </div>
                </div>
                
                @if($cliente->direccion)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label class="text-sm font-medium text-gray-500">Dirección</label>
                        <p class="text-lg font-medium text-gray-900 mt-1">{{ $cliente->direccion }}</p>
                    </div>
                @endif
                
                @if($cliente->notas)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label class="text-sm font-medium text-gray-500">Notas</label>
                        <p class="text-gray-700 mt-1">{{ $cliente->notas }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="space-y-6">
            <!-- Resumen de Órdenes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Resumen de Órdenes
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-capstone-600">{{ $estadisticas['total_ordenes'] }}</div>
                            <div class="text-sm text-gray-600">Total Órdenes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $estadisticas['ordenes_completadas'] }}</div>
                            <div class="text-sm text-gray-600">Completadas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600">{{ $estadisticas['ordenes_pendientes'] }}</div>
                            <div class="text-sm text-gray-600">Pendientes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-purple-600">${{ number_format($estadisticas['valor_total_gastado'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-600">Valor Total</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-500 to-gray-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información del Sistema
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Registrado:</span>
                        <span class="font-medium">{{ $cliente->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Última actualización:</span>
                        <span class="font-medium">{{ $cliente->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($estadisticas['ultima_orden'])
                        <div class="flex justify-between">
                            <span class="text-gray-600">Última orden:</span>
                            <span class="font-medium">{{ $estadisticas['ultima_orden']->created_at->format('d/m/Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="#" 
                       class="w-full bg-capstone-100 hover:bg-capstone-200 text-capstone-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Orden de Servicio
                    </a>
                    <form method="POST" action="{{ route('admin.clientes.toggle-status', $cliente->id) }}" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full {{ $cliente->estado === 'activo' ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas {{ $cliente->estado === 'activo' ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                            {{ $cliente->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Órdenes de Servicio -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-capstone-500 to-capstone-600">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-clipboard-list mr-2"></i>
                Historial de Órdenes de Servicio ({{ $cliente->ordenes->count() }})
            </h2>
        </div>

        @if($cliente->ordenes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Número de Orden
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo de Servicio
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Técnico Asignado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Valor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cliente->ordenes as $orden)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $orden->numero_orden }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $orden->tipo_servicio }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($orden->tecnico)
                                            {{ $orden->tecnico->nombre }} {{ $orden->tecnico->apellido }}
                                        @else
                                            <span class="text-gray-500">No asignado</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $estadoBadge = [
                                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'en_progreso' => 'bg-blue-100 text-blue-800',
                                            'completada' => 'bg-green-100 text-green-800',
                                            'cancelada' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoBadge[$orden->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $orden->estado)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $orden->created_at->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $orden->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        @if($orden->precio_total)
                                            ${{ number_format($orden->precio_total, 0, ',', '.') }}
                                        @else
                                            <span class="text-gray-500">No definido</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="#" 
                                           class="text-capstone-600 hover:text-capstone-900"
                                           title="Ver orden">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($orden->estado === 'pendiente')
                                            <a href="#" 
                                               class="text-blue-600 hover:text-blue-900"
                                               title="Editar orden">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Sin órdenes de servicio</h3>
                <p class="text-gray-600 mb-6">Este cliente aún no tiene órdenes de servicio registradas.</p>
                <a href="#" 
                   class="bg-capstone-600 hover:bg-capstone-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primera Orden
                </a>
            </div>
        @endif
    </div>
</div>
@endsection