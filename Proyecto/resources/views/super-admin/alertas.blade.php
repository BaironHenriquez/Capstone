@extends('shared.layouts.super-admin')

@section('title', 'Alertas - Super Admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Alertas y Notificaciones</h1>
            <p class="text-sm text-gray-600 mt-1">Monitoreo de eventos importantes</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
            Suscripciones Por Vencer (Próximos 30 días)
        </h2>
        <div class="space-y-3">
            @forelse($suscripcionesPorVencer as $suscripcion)
            <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $suscripcion->user->servicioTecnico->nombre_servicio ?? 'Sin servicio' }}</p>
                        <p class="text-xs text-gray-600">Plan {{ ucfirst($suscripcion->plan_type) }} - ${{ number_format($suscripcion->amount, 0) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-red-600">{{ $suscripcion->ends_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $suscripcion->ends_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">No hay suscripciones próximas a vencer</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
            Pagos Pendientes (Más de 3 días)
        </h2>
        <div class="space-y-3">
            @forelse($pagosFallidos as $pago)
            <div class="flex items-center justify-between p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $pago->user->servicioTecnico->nombre_servicio ?? 'Sin servicio' }}</p>
                        <p class="text-xs text-gray-600">{{ $pago->getProviderName() }} - ID: {{ $pago->payment_provider_id }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-orange-600">${{ number_format($pago->amount, 0) }}</p>
                    <p class="text-xs text-gray-500">{{ $pago->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">No hay pagos pendientes antiguos</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
            Pruebas Gratuitas Por Expirar (7 días)
        </h2>
        <div class="space-y-3">
            @forelse($pruebasGratuitasPorExpirar as $usuario)
            <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-yellow-600 font-semibold text-sm">
                            {{ strtoupper(substr($usuario->nombre ?? $usuario->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $usuario->servicioTecnico->nombre_servicio ?? 'Sin servicio' }}</p>
                        <p class="text-xs text-gray-600">{{ $usuario->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-yellow-600">{{ $usuario->trial_ends_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $usuario->trial_ends_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">No hay pruebas gratuitas próximas a expirar</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
            Cancelaciones Recientes (Últimos 7 días)
        </h2>
        <div class="space-y-3">
            @forelse($cancelacionesRecientes as $suscripcion)
            <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $suscripcion->user->servicioTecnico->nombre_servicio ?? 'Sin servicio' }}</p>
                        <p class="text-xs text-gray-600">Plan {{ ucfirst($suscripcion->plan_type) }} - ${{ number_format($suscripcion->amount, 0) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-600">{{ $suscripcion->cancelled_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $suscripcion->cancelled_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">No hay cancelaciones recientes</p>
            @endforelse
        </div>
    </div>
</div>
@endsection