@extends('shared.layouts.super-admin')

@section('title', 'Servicios Técnicos - Super Admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Servicios Técnicos Registrados</h1>
            <p class="text-sm text-gray-600 mt-1">Gestión de todos los servicios en la plataforma</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" class="flex gap-4">
            <input type="text" 
                   name="buscar" 
                   placeholder="Buscar por nombre, RUT o correo..." 
                   value="{{ request('buscar') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
                Buscar
            </button>
            @if(request('buscar'))
            <a href="{{ route('super-admin.servicios-tecnicos') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Limpiar
            </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propietario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suscripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($servicios as $servicio)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-teal-600 font-semibold text-sm">
                                        {{ strtoupper(substr($servicio->nombre_servicio, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $servicio->nombre_servicio }}</p>
                                    <p class="text-xs text-gray-500">RUT: {{ $servicio->rut }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($servicio->user)
                            <div>
                                <p class="text-sm text-gray-900">{{ $servicio->user->nombre ?? $servicio->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $servicio->user->email }}</p>
                            </div>
                            @else
                            <span class="text-xs text-gray-400">Sin usuario</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="text-gray-900">{{ $servicio->telefono }}</p>
                                <p class="text-gray-500">{{ $servicio->correo }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $suscripcionActiva = $servicio->user && $servicio->user->subscriptions ? $servicio->user->subscriptions->where('status', 'active')->first() : null;
                            @endphp
                            @if($suscripcionActiva)
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activa
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ ucfirst($suscripcionActiva->plan_type) }} - ${{ number_format($suscripcionActiva->amount, 0) }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    Vence: {{ $suscripcionActiva->ends_at->format('d/m/Y') }}
                                </p>
                            </div>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Sin suscripción
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $totalPagos = $servicio->user && $servicio->user->payments ? $servicio->user->payments->where('status', 'completed')->count() : 0;
                                $montoPagos = $servicio->user && $servicio->user->payments ? $servicio->user->payments->where('status', 'completed')->sum('amount') : 0;
                            @endphp
                            <div class="text-sm">
                                <p class="text-gray-900 font-medium">{{ $totalPagos }} pagos</p>
                                <p class="text-gray-500">${{ number_format($montoPagos, 0) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $servicio->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">No se encontraron servicios técnicos</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($servicios->hasPages())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        {{ $servicios->links() }}
    </div>
    @endif
</div>
@endsection
