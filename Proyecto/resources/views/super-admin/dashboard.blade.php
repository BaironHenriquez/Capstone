@extends('shared.layouts.super-admin')

@section('title', 'Dashboard Global - Baieco')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Global</h1>
            <p class="text-sm text-gray-600 mt-1">Resumen ejecutivo de la plataforma</p>
        </div>
        <div class="text-sm text-gray-500">
            Actualizado: {{ \Carbon\Carbon::now()->timezone('America/Santiago')->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">Servicios Técnicos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalServicios }}</p>
                    <p class="text-xs text-teal-600 mt-2 font-medium">
                        {{ $serviciosActivos }} activos ({{ $totalServicios > 0 ? round(($serviciosActivos / $totalServicios) * 100, 1) : 0 }}%)
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">Suscripciones</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $suscripcionesActivas }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $conversionRate }}% tasa de conversión
                    </p>
                </div>
                <div class="bg-emerald-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">Ingresos Totales</p>
                    <p class="text-3xl font-bold text-teal-600 mt-2">${{ number_format($ingresosCompletados, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Ticket promedio: ${{ number_format($ticketPromedioPago, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-teal-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600">Crecimiento Mensual</p>
                    <p class="text-3xl font-bold text-sky-600 mt-2">+{{ $nuevosMesActual }}</p>
                    <p class="text-xs text-orange-600 mt-2 font-medium">
                        {{ $pagosPendientes }} pagos pendientes
                    </p>
                </div>
                <div class="bg-sky-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl shadow-sm border border-amber-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tasa de Retención</h3>
                <div class="bg-amber-100 rounded-full p-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold text-amber-600 mb-2">{{ $retencionPorcentaje }}%</div>
            <p class="text-sm text-gray-600">Suscripciones renovadas del año anterior</p>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-xl shadow-sm border border-red-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Alertas Urgentes</h3>
                <div class="bg-red-100 rounded-full p-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-4xl font-bold text-red-600 mb-2">{{ $suscripcionesExpiran }}</div>
            <p class="text-sm text-gray-600">Suscripciones expiran en 30 días</p>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl shadow-sm border border-purple-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Acciones Rápidas</h3>
                <div class="bg-purple-100 rounded-full p-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <a href="{{ route('super-admin.servicios-tecnicos') }}" class="block w-full px-4 py-2 text-center text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition">
                    Ver servicios técnicos
                </a>
                <a href="{{ route('super-admin.reporte-financiero') }}" class="block w-full px-4 py-2 text-center text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition">
                    Análisis financiero
                </a>
                <a href="{{ route('super-admin.alertas') }}" class="block w-full px-4 py-2 text-center text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition">
                    Revisar alertas
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Crecimiento de Servicios {{ now()->year }}</h2>
            <div style="height: 280px;">
                <canvas id="crecimientoChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ingresos Mensuales {{ now()->year }}</h2>
            <div style="height: 280px;">
                <canvas id="ingresosChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Distribución de Métodos de Pago</h2>
            <div class="space-y-4">
                @foreach($distribucionPagos as $pago)
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">
                            @if($pago->payment_method === 'paypal')
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                    PayPal
                                </span>
                            @else
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Transbank
                                </span>
                            @endif
                        </span>
                        <span class="text-sm font-semibold text-gray-900">
                            ${{ number_format($pago->monto_total, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 bg-gray-200 rounded-full h-3">
                            @php
                                $percentage = ($pago->monto_total / $ingresosCompletados) * 100;
                            @endphp
                            <div class="h-3 rounded-full {{ $pago->payment_method === 'paypal' ? 'bg-blue-500' : 'bg-red-500' }}" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-xs text-gray-500 w-12 text-right">{{ round($percentage, 1) }}%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $pago->total }} transacciones</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Distribución de Planes</h2>
            <div style="height: 200px;">
                <canvas id="planesChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-4">
                @foreach($distribucionPlanes as $plan)
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $plan->total }}</div>
                    <div class="text-xs text-gray-500">
                        @switch($plan->plan_type)
                            @case('monthly')
                                Mensual
                                @break
                            @case('quarterly')
                                Trimestral
                                @break
                            @case('yearly')
                                Anual
                                @break
                            @default
                                {{ ucfirst($plan->plan_type) }}
                        @endswitch
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    
    const crecimientoData = new Array(12).fill(0);
    @foreach($crecimientoMensual as $dato)
        crecimientoData[{{ $dato->mes - 1 }}] = {{ $dato->total }};
    @endforeach
    
    new Chart(document.getElementById('crecimientoChart'), {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{
                label: 'Nuevos servicios',
                data: crecimientoData,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    const ingresosData = new Array(12).fill(0);
    @foreach($ingresosMensuales as $dato)
        ingresosData[{{ $dato->mes - 1 }}] = {{ $dato->total }};
    @endforeach
    
    new Chart(document.getElementById('ingresosChart'), {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Ingresos',
                data: ingresosData,
                backgroundColor: 'rgba(20, 184, 166, 0.8)',
                borderColor: 'rgb(20, 184, 166)',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toLocaleString('es-CL');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-CL');
                        }
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('planesChart'), {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($distribucionPlanes as $plan)
                    '{{ $plan->plan_type === "monthly" ? "Mensual" : ($plan->plan_type === "quarterly" ? "Trimestral" : ($plan->plan_type === "yearly" ? "Anual" : ucfirst($plan->plan_type))) }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($distribucionPlanes as $plan)
                        {{ $plan->total }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(251, 146, 60)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
