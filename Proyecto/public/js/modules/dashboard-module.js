/**
 * Módulo Dashboard Interactivo
 * Maneja gráficos, Kanban, timeline y actualizaciones en tiempo real
 */

class DashboardModule {
    constructor() {
        this.charts = {};
        this.updateInterval = 30000; // 30 segundos
        this.kanbanData = {};
        this.timelineData = [];
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeCharts();
        this.loadKanbanData();
        this.loadTimelineData();
        this.startAutoUpdate();
    }

    bindEvents() {
        // Eventos de filtros
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('dashboard-filter')) {
                this.handleFilterChange(e.target);
            }
        });

        // Eventos de botones
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-refresh-dashboard')) {
                this.refreshAllData();
            }
            
            if (e.target.classList.contains('btn-export-dashboard')) {
                this.exportDashboard();
            }
            
            if (e.target.classList.contains('kanban-card')) {
                this.handleKanbanCardClick(e.target);
            }
        });

        // Drag & Drop para Kanban
        this.initKanbanDragDrop();
    }

    /**
     * Inicializar gráficos con Chart.js
     */
    initializeCharts() {
        this.initClientesChart();
        this.initOrdenesChart();
        this.initTecnicosChart();
        this.initIngresosMensual();
    }

    initClientesChart() {
        const ctx = document.getElementById('clientesChart');
        if (!ctx) return;

        this.charts.clientes = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Nuevos Clientes',
                    data: [12, 19, 8, 15, 25, 22],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
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
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                onHover: (event, activeElements) => {
                    event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                }
            }
        });
    }

    initOrdenesChart() {
        const ctx = document.getElementById('ordenesChart');
        if (!ctx) return;

        this.charts.ordenes = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'En Progreso', 'Completadas', 'Canceladas'],
                datasets: [{
                    data: [23, 45, 88, 5],
                    backgroundColor: [
                        '#f59e0b',
                        '#3b82f6',
                        '#10b981',
                        '#ef4444'
                    ],
                    borderWidth: 3,
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
                },
                cutout: '60%',
                onHover: (event, activeElements) => {
                    event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                }
            }
        });
    }

    initTecnicosChart() {
        const ctx = document.getElementById('tecnicosChart');
        if (!ctx) return;

        this.charts.tecnicos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Carlos R.', 'María G.', 'Ana H.', 'Luis M.', 'Diego S.'],
                datasets: [{
                    label: 'Carga de Trabajo (%)',
                    data: [85, 65, 95, 70, 55],
                    backgroundColor: [
                        '#ef4444',
                        '#f59e0b',
                        '#ef4444',
                        '#f59e0b',
                        '#10b981'
                    ],
                    borderRadius: 4
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
                        max: 100,
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
    }

    initIngresosMensual() {
        const ctx = document.getElementById('ingresosChart');
        if (!ctx) return;

        this.charts.ingresos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
                datasets: [{
                    label: 'Ingresos ($)',
                    data: [4500, 5200, 4800, 6100],
                    backgroundColor: '#10b981',
                    borderRadius: 6
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
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Cargar datos del Kanban
     */
    loadKanbanData() {
        // Datos simulados del Kanban
        this.kanbanData = {
            pendientes: [
                { id: 1, titulo: 'Reparación Laptop HP', cliente: 'Juan García', prioridad: 'alta', urgencia: 2 },
                { id: 2, titulo: 'Instalación Router', cliente: 'María Pérez', prioridad: 'media', urgencia: 1 },
                { id: 3, titulo: 'Mantenimiento PC', cliente: 'Carlos López', prioridad: 'baja', urgencia: 0 }
            ],
            progreso: [
                { id: 4, titulo: 'Reparación iPhone', cliente: 'Ana Torres', prioridad: 'urgente', tecnico: 'Carlos R.', progreso: 65 },
                { id: 5, titulo: 'Configuración Red', cliente: 'Luis Martín', prioridad: 'media', tecnico: 'María G.', progreso: 30 }
            ],
            revision: [
                { id: 6, titulo: 'Reparación Tablet', cliente: 'Pedro Ruiz', prioridad: 'media', tecnico: 'Diego S.', completado: true }
            ],
            completadas: [
                { id: 7, titulo: 'Instalación Software', cliente: 'Carmen Jiménez', tecnico: 'Ana H.', fechaCompletado: '2025-10-12' },
                { id: 8, titulo: 'Limpieza PC Gaming', cliente: 'Roberto Silva', tecnico: 'Luis M.', fechaCompletado: '2025-10-13' }
            ]
        };

        this.renderKanban();
    }

    /**
     * Renderizar tablero Kanban
     */
    renderKanban() {
        Object.keys(this.kanbanData).forEach(estado => {
            const container = document.getElementById(`${estado}-column`);
            if (!container) return;

            container.innerHTML = '';
            
            this.kanbanData[estado].forEach(orden => {
                const card = this.createKanbanCard(orden, estado);
                container.appendChild(card);
            });
        });

        this.updateKanbanCounters();
    }

    /**
     * Crear tarjeta Kanban
     */
    createKanbanCard(orden, estado) {
        const card = document.createElement('div');
        card.className = `kanban-card priority-${orden.prioridad || 'media'} cursor-pointer transform transition-all duration-200 hover:scale-105`;
        card.draggable = true;
        card.dataset.ordenId = orden.id;
        card.dataset.estado = estado;

        const priorityColors = {
            urgente: 'bg-red-100 text-red-800 border-red-500',
            alta: 'bg-orange-100 text-orange-800 border-orange-500',
            media: 'bg-yellow-100 text-yellow-800 border-yellow-500',
            baja: 'bg-green-100 text-green-800 border-green-500'
        };

        card.innerHTML = `
            <div class="flex items-start justify-between mb-2">
                <h5 class="text-sm font-medium text-gray-900 truncate flex-1">${orden.titulo}</h5>
                <span class="text-xs px-2 py-1 rounded-full ml-2 ${priorityColors[orden.prioridad] || priorityColors.media}">
                    ${(orden.prioridad || 'media').toUpperCase()}
                </span>
            </div>
            
            <p class="text-xs text-gray-600 mb-2">${orden.cliente}</p>
            
            ${orden.tecnico ? `
                <div class="flex items-center text-xs text-blue-600 mb-2">
                    <i class="fas fa-user mr-1"></i>${orden.tecnico}
                </div>
            ` : '<p class="text-xs text-gray-400 mb-2">Sin asignar</p>'}
            
            ${orden.progreso ? `
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: ${orden.progreso}%"></div>
                </div>
                <p class="text-xs text-gray-500">Progreso: ${orden.progreso}%</p>
            ` : ''}
            
            ${orden.fechaCompletado ? `
                <p class="text-xs text-green-600">
                    <i class="fas fa-check mr-1"></i>Completado: ${orden.fechaCompletado}
                </p>
            ` : ''}
            
            ${orden.urgencia !== undefined ? `
                <div class="flex items-center mt-2">
                    ${Array.from({length: 3}, (_, i) => `
                        <i class="fas fa-exclamation text-xs ${i < orden.urgencia ? 'text-red-500' : 'text-gray-300'}"></i>
                    `).join('')}
                </div>
            ` : ''}
        `;

        return card;
    }

    /**
     * Actualizar contadores del Kanban
     */
    updateKanbanCounters() {
        Object.keys(this.kanbanData).forEach(estado => {
            const badge = document.querySelector(`#kanban-${estado} .count-badge`);
            if (badge) {
                badge.textContent = this.kanbanData[estado].length;
            }
        });
    }

    /**
     * Inicializar Drag & Drop para Kanban
     */
    initKanbanDragDrop() {
        let draggedElement = null;

        document.addEventListener('dragstart', (e) => {
            if (e.target.classList.contains('kanban-card')) {
                draggedElement = e.target;
                e.target.style.opacity = '0.5';
            }
        });

        document.addEventListener('dragend', (e) => {
            if (e.target.classList.contains('kanban-card')) {
                e.target.style.opacity = '1';
                draggedElement = null;
            }
        });

        document.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        document.addEventListener('drop', (e) => {
            e.preventDefault();
            
            const dropZone = e.target.closest('.kanban-column');
            if (dropZone && draggedElement) {
                const newEstado = dropZone.id.replace('-column', '');
                const oldEstado = draggedElement.dataset.estado;
                const ordenId = parseInt(draggedElement.dataset.ordenId);
                
                if (newEstado !== oldEstado) {
                    this.moveKanbanCard(ordenId, oldEstado, newEstado);
                }
            }
        });
    }

    /**
     * Mover tarjeta en Kanban
     */
    moveKanbanCard(ordenId, fromEstado, toEstado) {
        const ordenIndex = this.kanbanData[fromEstado].findIndex(o => o.id === ordenId);
        if (ordenIndex !== -1) {
            const orden = this.kanbanData[fromEstado].splice(ordenIndex, 1)[0];
            this.kanbanData[toEstado].push(orden);
            
            this.renderKanban();
            this.showNotification(`Orden ${ordenId} movida a ${toEstado}`, 'success');
            
            // Aquí se haría la llamada al backend para actualizar el estado
            this.updateOrdenEstado(ordenId, toEstado);
        }
    }

    /**
     * Cargar datos del timeline
     */
    loadTimelineData() {
        this.timelineData = [
            {
                tiempo: '10:30 AM',
                evento: 'Nueva orden creada',
                detalle: 'Reparación Laptop - Juan García',
                tipo: 'nueva',
                icon: 'plus-circle',
                color: 'blue'
            },
            {
                tiempo: '10:15 AM',
                evento: 'IA recomienda técnico',
                detalle: 'Carlos Rodriguez recomendado para orden TS-2025-003',
                tipo: 'ia',
                icon: 'robot',
                color: 'purple'
            },
            {
                tiempo: '09:45 AM',
                evento: 'Orden completada',
                detalle: 'Instalación Software - Carmen Jiménez',
                tipo: 'completada',
                icon: 'check-circle',
                color: 'green'
            },
            {
                tiempo: '09:30 AM',
                evento: 'Alerta predictiva',
                detalle: 'Diego Sánchez cerca del límite de carga',
                tipo: 'alerta',
                icon: 'exclamation-triangle',
                color: 'yellow'
            },
            {
                tiempo: '09:15 AM',
                evento: 'Técnico asignado',
                detalle: 'Carlos Rodriguez → Orden #TS-2025-003',
                tipo: 'asignacion',
                icon: 'user-cog',
                color: 'indigo'
            }
        ];

        this.renderTimeline();
    }

    /**
     * Renderizar timeline
     */
    renderTimeline() {
        const container = document.getElementById('timelineContainer');
        if (!container) return;

        container.innerHTML = this.timelineData.map(item => `
            <div class="timeline-item relative">
                <div class="timeline-marker absolute -left-2 w-4 h-4 bg-${item.color}-500 rounded-full border-2 border-white shadow-md"></div>
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-${item.icon} text-${item.color}-600 mr-2"></i>
                                <p class="text-sm font-medium text-gray-900">${item.evento}</p>
                            </div>
                            <p class="text-xs text-gray-600">${item.detalle}</p>
                        </div>
                        <span class="text-xs text-gray-500 font-medium">${item.tiempo}</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    /**
     * Manejar clic en tarjeta Kanban
     */
    handleKanbanCardClick(card) {
        const ordenId = card.dataset.ordenId;
        this.showOrdenDetails(ordenId);
    }

    /**
     * Mostrar detalles de orden
     */
    showOrdenDetails(ordenId) {
        // Simular datos de la orden
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Orden TS-2025-${ordenId.toString().padStart(3, '0')}</h3>
                    <button class="text-gray-400 hover:text-gray-600" onclick="this.closest('.fixed').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <p><strong>Cliente:</strong> Juan García</p>
                    <p><strong>Descripción:</strong> Reparación de laptop HP que no enciende</p>
                    <p><strong>Estado:</strong> <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Pendiente</span></p>
                    <p><strong>Prioridad:</strong> <span class="px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">Alta</span></p>
                </div>
                <div class="mt-6 flex space-x-3">
                    <button class="btn-recomendar-tecnico bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" 
                            data-orden-id="${ordenId}" data-tipo-servicio="reparacion" data-prioridad="alta">
                        <i class="fas fa-robot mr-2"></i>IA Recomendar
                    </button>
                    <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                        Editar
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
    }

    /**
     * Actualizar estado de orden (llamada al backend)
     */
    async updateOrdenEstado(ordenId, nuevoEstado) {
        try {
            const response = await fetch(`/ordenes/${ordenId}/cambiar-estado`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    estado: nuevoEstado
                })
            });

            if (!response.ok) {
                throw new Error('Error al actualizar el estado');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error al actualizar el estado', 'error');
        }
    }

    /**
     * Refrescar todos los datos del dashboard
     */
    async refreshAllData() {
        this.showNotification('Actualizando dashboard...', 'info');
        
        try {
            // Simular actualización de datos
            await this.sleep(1000);
            
            // Actualizar gráficos con nuevos datos
            this.updateChartData();
            
            // Recargar Kanban y Timeline
            this.loadKanbanData();
            this.loadTimelineData();
            
            this.showNotification('Dashboard actualizado', 'success');
        } catch (error) {
            this.showNotification('Error al actualizar dashboard', 'error');
        }
    }

    /**
     * Actualizar datos de gráficos
     */
    updateChartData() {
        // Generar datos aleatorios para simular cambios
        if (this.charts.clientes) {
            const newData = Array.from({length: 6}, () => Math.floor(Math.random() * 30) + 5);
            this.charts.clientes.data.datasets[0].data = newData;
            this.charts.clientes.update();
        }

        if (this.charts.ordenes) {
            const newData = [
                Math.floor(Math.random() * 20) + 10,
                Math.floor(Math.random() * 30) + 20,
                Math.floor(Math.random() * 50) + 50,
                Math.floor(Math.random() * 10) + 1
            ];
            this.charts.ordenes.data.datasets[0].data = newData;
            this.charts.ordenes.update();
        }
    }

    /**
     * Iniciar actualizaciones automáticas
     */
    startAutoUpdate() {
        setInterval(() => {
            this.refreshAllData();
        }, this.updateInterval);
    }

    /**
     * Exportar dashboard
     */
    exportarDashboard() {
        this.showNotification('Generando reporte...', 'info');
        
        // Simular exportación
        setTimeout(() => {
            this.showNotification('Reporte descargado exitosamente', 'success');
        }, 2000);
    }

    /**
     * Mostrar notificación
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white shadow-lg z-50 ${
            type === 'error' ? 'bg-red-600' :
            type === 'success' ? 'bg-green-600' :
            type === 'warning' ? 'bg-yellow-600' : 'bg-blue-600'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${
                    type === 'error' ? 'exclamation-circle' :
                    type === 'success' ? 'check-circle' :
                    type === 'warning' ? 'exclamation-triangle' : 'info-circle'
                } mr-2"></i>
                ${message}
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 4000);
    }

    /**
     * Utilidad para sleep
     */
    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    /**
     * Manejar cambios en filtros
     */
    handleFilterChange(filter) {
        const filterType = filter.dataset.filterType;
        const filterValue = filter.value;
        
        console.log(`Aplicando filtro ${filterType}:`, filterValue);
        
        // Implementar lógica de filtrado según el tipo
        switch(filterType) {
            case 'periodo':
                this.filterByPeriod(filterValue);
                break;
            case 'tecnico':
                this.filterByTecnico(filterValue);
                break;
            case 'prioridad':
                this.filterByPrioridad(filterValue);
                break;
        }
    }

    filterByPeriod(period) {
        // Implementar filtrado por período
        console.log('Filtrando por período:', period);
    }

    filterByTecnico(tecnico) {
        // Implementar filtrado por técnico
        console.log('Filtrando por técnico:', tecnico);
    }

    filterByPrioridad(prioridad) {
        // Implementar filtrado por prioridad
        console.log('Filtrando por prioridad:', prioridad);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.DashboardModule = new DashboardModule();
});