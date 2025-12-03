@extends('shared.layouts.super-admin')

@section('title', 'Reporte Financiero - Super Admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reporte Financiero</h1>
            <p class="text-sm text-gray-600 mt-1">Análisis de ingresos y métricas financieras</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">MRR (Ingreso Recurrente Mensual)</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">${{ number_format($mrr, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Ingresos recurrentes mensuales</p>
                </div>
                <div class="bg-emerald-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tasa de Cancelación (Churn Rate)</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $churnRate }}%</p>
                    <p class="text-xs text-gray-500 mt-1">Año {{ $year }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ingresos Anuales</p>
                    @php
                        $totalAnual = $ingresosMensuales->sum('total');
                    @endphp
                    <p class="text-3xl font-bold text-blue-600 mt-2">${{ number_format($totalAnual, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total {{ $year }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ingresos Mensuales {{ $year }}</h2>
            <div style="height: 300px;">
                <canvas id="ingresosMensualesChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Distribución de Planes</h2>
            <div class="space-y-4">
                @foreach($distribucionPlanes as $plan)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">{{ $plan->total }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                @switch($plan->plan_type)
                                    @case('monthly')
                                        Plan Mensual
                                        @break
                                    @case('quarterly')
                                        Plan Trimestral
                                        @break
                                    @case('yearly')
                                        Plan Anual
                                        @break
                                    @case('premium')
                                        Plan Premium
                                        @break
                                    @default
                                        {{ ucfirst($plan->plan_type) }}
                                @endswitch
                            </p>
                            <p class="text-xs text-gray-500">Suscripciones activas</p>
                        </div>
                    </div>
                    @php
                        $totalPlanes = $distribucionPlanes->sum('total');
                        $percentage = $totalPlanes > 0 ? round(($plan->total / $totalPlanes) * 100, 1) : 0;
                    @endphp
                    <span class="text-lg font-semibold text-gray-700">{{ $percentage }}%</span>
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
    const ctx = document.getElementById('ingresosMensualesChart').getContext('2d');
    
    const mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    const ingresosPorMes = new Array(12).fill(0);
    const pagosPorMes = new Array(12).fill(0);
    
    @foreach($ingresosMensuales as $ingreso)
        ingresosPorMes[{{ $ingreso->mes - 1 }}] = {{ $ingreso->total }};
        pagosPorMes[{{ $ingreso->mes - 1 }}] = {{ $ingreso->cantidad }};
    @endforeach
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: mesesLabels,
            datasets: [{
                label: 'Ingresos ($)',
                data: ingresosPorMes,
                backgroundColor: 'rgba(20, 184, 166, 0.8)',
                borderColor: 'rgb(20, 184, 166)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(20, 184, 166, 1)',
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
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            const mes = context.dataIndex;
                            const ingreso = context.parsed.y;
                            const pagos = pagosPorMes[mes];
                            return [
                                'Ingresos: $' + ingreso.toLocaleString('es-CL'),
                                'Pagos: ' + pagos
                            ];
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
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush