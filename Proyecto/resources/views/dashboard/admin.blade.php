@extends('shared.layouts.admin')

@section('title', 'Dashboard Principal')
@section('breadcrumb', 'Panel de Control')

@push('styles')
<style>
    .kanban-column {
        min-height: 500px;
        background: #f8fafc;
        border-radius: 8px;
        padding: 1rem;
    }
    
    .kanban-card {
        background: white;
        border-radius: 6px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .kanban-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .priority-alta { border-left: 4px solid #ef4444; }
    .priority-media { border-left: 4px solid #f59e0b; }
    .priority-baja { border-left: 4px solid #10b981; }
    .priority-urgente { border-left: 4px solid #dc2626; }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.375rem;
        top: 0.25rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 50%;
        background: #3b82f6;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #e5e7eb;
    }

    .mapa-tecnicos {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .tecnico-marker {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>
@endpush

@section('content')
<!-- Header del Dashboard -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Principal</h1>
        <p class="text-gray-600">Resumen general de tu servicio técnico</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <button onclick="actualizarDashboard()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
            <i class="fas fa-sync-alt mr-2"></i>Actualizar
        </button>
        <button onclick="exportarReporte()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
            <i class="fas fa-download mr-2"></i>Exportar
        </button>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Clientes -->
    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $estadisticasClientes['total'] ?? 0 }}</p>
                <p class="text-xs text-green-600">+{{ $estadisticasClientes['nuevos_mes'] ?? 0 }} este mes</p>
            </div>
        </div>
    </div>

    <!-- Órdenes Activas -->
    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-clipboard-list text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Órdenes Activas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $resumenOrdenes['pendientes'] + $resumenOrdenes['en_progreso'] }}</p>
                <p class="text-xs text-blue-600">{{ $resumenOrdenes['en_progreso'] }} en progreso</p>
            </div>
        </div>
    </div>

    <!-- Ingresos del Mes -->
    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Ingresos del Mes</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($estadisticasClientes['total'] * 150 + 2500, 0) }}</p>
                <p class="text-xs text-green-600">+12.5% vs mes anterior</p>
            </div>
        </div>
    </div>

    <!-- Técnicos Activos -->
    <div class="dashboard-card bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover-lift">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-user-cog text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Técnicos Activos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $tecnicos['activos'] ?? 8 }}</p>
                <p class="text-xs text-blue-600">{{ $tecnicos['disponibles'] ?? 3 }} disponibles</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos y Análisis -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Gráfico de Clientes -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Clientes por Mes</h3>
            <div class="flex space-x-2">
                <button onclick="cambiarTipoGrafico('line')" class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded">Línea</button>
                <button onclick="cambiarTipoGrafico('bar')" class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">Barras</button>
            </div>
        </div>
        <canvas id="clientesChart" height="200"></canvas>
    </div>

    <!-- Gráfico de Órdenes -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Estado de Órdenes</h3>
            <button onclick="actualizarGraficoOrdenes()" class="text-xs px-2 py-1 bg-green-100 text-green-600 rounded">
                <i class="fas fa-sync-alt mr-1"></i>Actualizar
            </button>
        </div>
        <canvas id="ordenesChart" height="200"></canvas>
    </div>
</div>

<!-- Kanban Board -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">
            <i class="fas fa-columns mr-2 text-blue-600"></i>Vista Kanban - Órdenes de Servicio
        </h3>
        <div class="flex space-x-2">
            <button onclick="filtrarPorPrioridad('todas')" class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded">Todas</button>
            <button onclick="filtrarPorPrioridad('urgente')" class="text-xs px-3 py-1 bg-red-100 text-red-600 rounded">Urgente</button>
            <button onclick="filtrarPorPrioridad('alta')" class="text-xs px-3 py-1 bg-orange-100 text-orange-600 rounded">Alta</button>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4" id="kanbanBoard">
        <!-- Pendientes -->
        <div class="kanban-column">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-gray-700">
                    <i class="fas fa-clock mr-2 text-yellow-500"></i>Pendientes
                </h4>
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $resumenOrdenes['pendientes'] }}</span>
            </div>
            <div id="pendientes-column">
                <!-- Las tarjetas se cargarán dinámicamente -->
            </div>
        </div>

        <!-- En Progreso -->
        <div class="kanban-column">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-gray-700">
                    <i class="fas fa-play mr-2 text-blue-500"></i>En Progreso
                </h4>
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $resumenOrdenes['en_progreso'] }}</span>
            </div>
            <div id="progreso-column">
                <!-- Las tarjetas se cargarán dinámicamente -->
            </div>
        </div>

        <!-- Revisión -->
        <div class="kanban-column">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-gray-700">
                    <i class="fas fa-search mr-2 text-purple-500"></i>Revisión
                </h4>
                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">5</span>
            </div>
            <div id="revision-column">
                <!-- Las tarjetas se cargarán dinámicamente -->
            </div>
        </div>

        <!-- Completadas -->
        <div class="kanban-column">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-gray-700">
                    <i class="fas fa-check mr-2 text-green-500"></i>Completadas
                </h4>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ $resumenOrdenes['completadas'] }}</span>
            </div>
            <div id="completadas-column">
                <!-- Las tarjetas se cargarán dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Timeline y Mapa -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Timeline de Actividades -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-history mr-2 text-green-600"></i>Timeline de Actividades
            </h3>
            <select onchange="filtrarTimeline(this.value)" class="text-xs border border-gray-300 rounded px-2 py-1">
                <option value="hoy">Hoy</option>
                <option value="semana">Esta Semana</option>
                <option value="mes">Este Mes</option>
            </select>
        </div>
        
        <div class="timeline" id="timelineContainer">
            <!-- Los elementos del timeline se cargarán dinámicamente -->
        </div>
    </div>

    <!-- Mapa de Técnicos -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>Ubicación de Técnicos
            </h3>
            <div class="flex items-center space-x-2">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                    <span class="text-xs text-gray-600">Activo</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></div>
                    <span class="text-xs text-gray-600">Ocupado</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                    <span class="text-xs text-gray-600">No Disponible</span>
                </div>
            </div>
        </div>
        
        <div class="mapa-tecnicos" id="mapaTecnicos">
            <div class="text-center mb-4">
                <i class="fas fa-map text-4xl mb-2 opacity-20"></i>
                <p class="text-sm opacity-80">Vista Simulada - Área de Servicio</p>
            </div>
            
            <!-- Marcadores de técnicos (posicionados dinámicamente) -->
            <div class="tecnico-marker" style="top: 20%; left: 30%;" title="Carlos Rodriguez - Disponible"></div>
            <div class="tecnico-marker" style="top: 40%; left: 60%; background: #f59e0b;" title="María González - Ocupada"></div>
            <div class="tecnico-marker" style="top: 65%; left: 25%;" title="Luis Martinez - Disponible"></div>
            <div class="tecnico-marker" style="top: 30%; left: 75%; background: #ef4444;" title="Ana Hernández - No Disponible"></div>
            <div class="tecnico-marker" style="top: 55%; left: 45%;" title="Diego Sánchez - Disponible"></div>
        </div>
    </div>
</div>

<!-- Alertas y Notificaciones -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">
            <i class="fas fa-bell mr-2 text-yellow-600"></i>Alertas Recientes
        </h3>
        <button onclick="marcarTodasLeidas()" class="text-xs px-3 py-1 bg-blue-100 text-blue-600 rounded">
            Marcar todas como leídas
        </button>
    </div>
    
    <div class="space-y-3" id="alertasContainer">
        <!-- Las alertas se cargarán dinámicamente -->
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Variables globales
let clientesChart, ordenesChart;
let tipoGraficoClientes = 'line';

// Datos del servidor
const datosClientes = @json($clientesPorMes ?? []);
const datosOrdenes = @json($resumenOrdenes ?? []);

document.addEventListener('DOMContentLoaded', function() {
    inicializarGraficos();
    cargarKanban();
    cargarTimeline();
    cargarAlertas();
    
    // Actualizar cada 30 segundos
    setInterval(actualizarDashboard, 30000);
});

function inicializarGraficos() {
    // Gráfico de Clientes
    const ctxClientes = document.getElementById('clientesChart').getContext('2d');
    clientesChart = new Chart(ctxClientes, {
        type: tipoGraficoClientes,
        data: {
            labels: datosClientes.map(item => item.mes),
            datasets: [{
                label: 'Clientes Registrados',
                data: datosClientes.map(item => item.cantidad),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
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
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
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

    // Gráfico de Órdenes (Doughnut)
    const ctxOrdenes = document.getElementById('ordenesChart').getContext('2d');
    ordenesChart = new Chart(ctxOrdenes, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'En Progreso', 'Completadas', 'Canceladas'],
            datasets: [{
                data: [
                    datosOrdenes.pendientes || 0,
                    datosOrdenes.en_progreso || 0,
                    datosOrdenes.completadas || 0,
                    datosOrdenes.canceladas || 0
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#3b82f6',
                    '#10b981',
                    '#ef4444'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
}

function cambiarTipoGrafico(tipo) {
    tipoGraficoClientes = tipo;
    clientesChart.destroy();
    
    const ctx = document.getElementById('clientesChart').getContext('2d');
    clientesChart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: datosClientes.map(item => item.mes),
            datasets: [{
                label: 'Clientes Registrados',
                data: datosClientes.map(item => item.cantidad),
                borderColor: '#3b82f6',
                backgroundColor: tipo === 'bar' ? 'rgba(59, 130, 246, 0.8)' : 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: tipo === 'line',
                tension: 0.4
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
                    beginAtZero: true
                }
            }
        }
    });
}

function cargarKanban() {
    // Datos simulados para el Kanban
    const ordenesPendientes = [
        { id: 1, titulo: 'Reparación Laptop HP', cliente: 'Juan García', prioridad: 'alta', tecnico: null },
        { id: 2, titulo: 'Instalación Router', cliente: 'María Pérez', prioridad: 'media', tecnico: null },
        { id: 3, titulo: 'Mantenimiento PC', cliente: 'Carlos López', prioridad: 'baja', tecnico: null }
    ];

    const ordenesProgreso = [
        { id: 4, titulo: 'Reparación iPhone', cliente: 'Ana Torres', prioridad: 'urgente', tecnico: 'Carlos R.' },
        { id: 5, titulo: 'Configuración Red', cliente: 'Luis Martín', prioridad: 'media', tecnico: 'María G.' }
    ];

    const ordenesRevision = [
        { id: 6, titulo: 'Reparación Tablet', cliente: 'Pedro Ruiz', prioridad: 'media', tecnico: 'Diego S.' }
    ];

    const ordenesCompletadas = [
        { id: 7, titulo: 'Instalación Software', cliente: 'Carmen Jiménez', prioridad: 'baja', tecnico: 'Ana H.' },
        { id: 8, titulo: 'Limpieza PC Gaming', cliente: 'Roberto Silva', prioridad: 'alta', tecnico: 'Luis M.' }
    ];

    cargarColumnKanban('pendientes-column', ordenesPendientes);
    cargarColumnKanban('progreso-column', ordenesProgreso);
    cargarColumnKanban('revision-column', ordenesRevision);
    cargarColumnKanban('completadas-column', ordenesCompletadas);
}

function cargarColumnKanban(columnId, ordenes) {
    const column = document.getElementById(columnId);
    column.innerHTML = '';
    
    ordenes.forEach(orden => {
        const card = document.createElement('div');
        card.className = `kanban-card priority-${orden.prioridad}`;
        card.innerHTML = `
            <div class="flex items-start justify-between mb-2">
                <h5 class="text-sm font-medium text-gray-900 truncate">${orden.titulo}</h5>
                <span class="text-xs px-2 py-1 rounded-full bg-${orden.prioridad === 'urgente' ? 'red' : orden.prioridad === 'alta' ? 'orange' : orden.prioridad === 'media' ? 'yellow' : 'green'}-100 text-${orden.prioridad === 'urgente' ? 'red' : orden.prioridad === 'alta' ? 'orange' : orden.prioridad === 'media' ? 'yellow' : 'green'}-800">
                    ${orden.prioridad.toUpperCase()}
                </span>
            </div>
            <p class="text-xs text-gray-600 mb-2">${orden.cliente}</p>
            ${orden.tecnico ? `<p class="text-xs text-blue-600"><i class="fas fa-user mr-1"></i>${orden.tecnico}</p>` : '<p class="text-xs text-gray-400">Sin asignar</p>'}
        `;
        card.onclick = () => abrirDetalleOrden(orden.id);
        column.appendChild(card);
    });
}

function cargarTimeline() {
    const timeline = document.getElementById('timelineContainer');
    const actividades = [
        { tiempo: '10:30 AM', evento: 'Nueva orden creada', detalle: 'Reparación Laptop - Juan García', tipo: 'nueva' },
        { tiempo: '09:45 AM', evento: 'Orden completada', detalle: 'Instalación Software - Carmen Jiménez', tipo: 'completada' },
        { tiempo: '09:15 AM', evento: 'Técnico asignado', detalle: 'Carlos Rodriguez → Orden #2025-003', tipo: 'asignacion' },
        { tiempo: '08:30 AM', evento: 'Cliente registrado', detalle: 'Nuevo cliente: Pedro Ruiz Silva', tipo: 'cliente' }
    ];
    
    timeline.innerHTML = '';
    actividades.forEach(actividad => {
        const item = document.createElement('div');
        item.className = 'timeline-item';
        item.innerHTML = `
            <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">${actividad.evento}</p>
                        <p class="text-xs text-gray-600 mt-1">${actividad.detalle}</p>
                    </div>
                    <span class="text-xs text-gray-500">${actividad.tiempo}</span>
                </div>
            </div>
        `;
        timeline.appendChild(item);
    });
}

function cargarAlertas() {
    const alertasContainer = document.getElementById('alertasContainer');
    const alertas = [
        { tipo: 'warning', mensaje: 'Orden TS-2025-089 lleva 5 días de retraso', accion: 'Ver detalles' },
        { tipo: 'info', mensaje: 'Técnico Diego Sánchez cerca del límite de carga (95%)', accion: 'Redistribuir' },
        { tipo: 'success', mensaje: '3 órdenes completadas en las últimas 2 horas', accion: 'Ver reporte' }
    ];
    
    alertasContainer.innerHTML = '';
    alertas.forEach(alerta => {
        const item = document.createElement('div');
        item.className = `flex items-center justify-between p-3 rounded-lg border-l-4 border-${alerta.tipo === 'warning' ? 'yellow' : alerta.tipo === 'info' ? 'blue' : 'green'}-500 bg-${alerta.tipo === 'warning' ? 'yellow' : alerta.tipo === 'info' ? 'blue' : 'green'}-50`;
        item.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${alerta.tipo === 'warning' ? 'exclamation-triangle' : alerta.tipo === 'info' ? 'info-circle' : 'check-circle'} mr-3 text-${alerta.tipo === 'warning' ? 'yellow' : alerta.tipo === 'info' ? 'blue' : 'green'}-600"></i>
                <p class="text-sm text-gray-700">${alerta.mensaje}</p>
            </div>
            <button class="text-xs px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-50">${alerta.accion}</button>
        `;
        alertasContainer.appendChild(item);
    });
}

// Funciones de interacción
function actualizarDashboard() {
    // Simular actualización
    console.log('Actualizando dashboard...');
    // Aquí iría la llamada AJAX para obtener datos frescos
}

function abrirDetalleOrden(ordenId) {
    console.log('Abriendo detalles de orden:', ordenId);
    // Aquí iría la lógica para abrir modal o navegar a detalles
}

function filtrarPorPrioridad(prioridad) {
    console.log('Filtrando por prioridad:', prioridad);
    // Aquí iría la lógica de filtrado
}

function filtrarTimeline(periodo) {
    console.log('Filtrando timeline por:', periodo);
    // Aquí iría la lógica para filtrar timeline
}

function marcarTodasLeidas() {
    console.log('Marcando todas las alertas como leídas');
    // Aquí iría la lógica para marcar alertas como leídas
}

function exportarReporte() {
    console.log('Exportando reporte...');
    // Aquí iría la lógica para exportar
}
</script>
@endpush