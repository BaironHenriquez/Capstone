/**
 * Módulo de Funcionalidades de IA
 * Maneja recomendaciones, alertas predictivas y optimización
 */

class IAModule {
    constructor() {
        this.baseUrl = '/ia';
        this.isLoading = false;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadInitialData();
    }

    bindEvents() {
        // Botones de recomendación de técnicos
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-recomendar-tecnico')) {
                this.recomendarTecnico(e.target);
            }
            
            if (e.target.classList.contains('btn-priorizar-ordenes')) {
                this.priorizarOrdenes();
            }
            
            if (e.target.classList.contains('btn-alertas-ia')) {
                this.mostrarAlertasPredictivas();
            }
        });

        // Auto-refresh de alertas cada 2 minutos
        setInterval(() => {
            this.actualizarAlertasPredictivas();
        }, 120000);
    }

    async loadInitialData() {
        try {
            await this.actualizarAlertasPredictivas();
        } catch (error) {
            console.log('Error cargando datos iniciales de IA:', error);
        }
    }

    /**
     * Recomendar técnico basado en criterios de IA
     */
    async recomendarTecnico(button) {
        if (this.isLoading) return;

        const ordenId = button.dataset.ordenId;
        const tipoServicio = button.dataset.tipoServicio;
        const prioridad = button.dataset.prioridad || 'media';

        this.setLoadingState(button, true);

        try {
            const response = await fetch(`${this.baseUrl}/recomendar-tecnico`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    orden_id: ordenId,
                    tipo_servicio: tipoServicio,
                    prioridad: prioridad
                })
            });

            const data = await response.json();
            
            if (response.ok) {
                this.mostrarRecomendacionesTecnico(data);
            } else {
                throw new Error(data.message || 'Error al obtener recomendaciones');
            }
        } catch (error) {
            this.showError('Error al obtener recomendaciones de técnicos: ' + error.message);
        } finally {
            this.setLoadingState(button, false);
        }
    }

    /**
     * Mostrar modal con recomendaciones de técnicos
     */
    mostrarRecomendacionesTecnico(data) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-robot mr-2 text-blue-600"></i>
                        Recomendaciones de IA
                    </h3>
                    <button class="text-gray-400 hover:text-gray-600" onclick="this.closest('.fixed').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    ${data.recomendaciones.map((tecnico, index) => `
                        <div class="border rounded-lg p-4 ${index === 0 ? 'border-blue-500 bg-blue-50' : 'border-gray-200'}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    ${index === 0 ? '<i class="fas fa-crown text-yellow-500 mr-2"></i>' : ''}
                                    <h4 class="font-medium text-gray-900">${tecnico.nombre}</h4>
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        Score IA: ${tecnico.score_ia}%
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-600">⭐ ${tecnico.calificacion}</div>
                                    <div class="text-xs text-gray-500">Carga: ${tecnico.carga_trabajo}%</div>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">Especialidad:</span> ${tecnico.especialidad}
                            </div>
                            
                            <div class="text-sm text-gray-600 mb-3">
                                <span class="font-medium">Tiempo estimado:</span> ${tecnico.tiempo_estimado}
                            </div>
                            
                            <div class="text-sm text-blue-600 bg-blue-100 p-2 rounded">
                                💡 <strong>IA sugiere:</strong> ${tecnico.razon_recomendacion}
                            </div>
                            
                            <div class="mt-3 flex space-x-2">
                                <button class="btn-asignar-tecnico bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700" 
                                        data-tecnico-id="${tecnico.id}">
                                    Asignar Técnico
                                </button>
                                <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-200">
                                    Ver Perfil
                                </button>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div class="mt-4 p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-600">
                        <strong>Criterios aplicados:</strong> 
                        ${data.criterios_aplicados.factores_considerados.join(', ')}
                    </p>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Bind eventos de asignación
        modal.querySelectorAll('.btn-asignar-tecnico').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.asignarTecnico(e.target.dataset.tecnicoId);
                modal.remove();
            });
        });
    }

    /**
     * Priorizar órdenes usando algoritmo de IA
     */
    async priorizarOrdenes() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        
        try {
            const response = await fetch(`${this.baseUrl}/priorizar-ordenes`);
            const data = await response.json();
            
            if (response.ok) {
                this.mostrarOrdenesPrivorizadas(data);
            } else {
                throw new Error(data.message || 'Error al priorizar órdenes');
            }
        } catch (error) {
            this.showError('Error en la priorización automática: ' + error.message);
        } finally {
            this.isLoading = false;
        }
    }

    /**
     * Mostrar órdenes priorizadas por IA
     */
    mostrarOrdenesPrivorizadas(data) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-96 overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-brain mr-2 text-purple-600"></i>
                        Priorización Automática por IA
                    </h3>
                    <button class="text-gray-400 hover:text-gray-600" onclick="this.closest('.fixed').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="mb-4 p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center text-green-800">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="font-medium">Optimización completada</span>
                    </div>
                    <div class="text-sm text-green-700 mt-1">
                        Tiempo total reducido en ${data.optimizacion.tiempo_total_reducido} | 
                        Satisfacción estimada: ${data.optimizacion.satisfaccion_cliente_estimada}
                    </div>
                </div>
                
                <div class="space-y-3">
                    ${data.ordenes_priorizadas.map((orden, index) => `
                        <div class="flex items-center justify-between p-4 border rounded-lg ${
                            orden.prioridad_ia === 'urgente' ? 'border-red-300 bg-red-50' :
                            orden.prioridad_ia === 'alta' ? 'border-orange-300 bg-orange-50' :
                            'border-gray-200 bg-white'
                        }">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold">
                                        ${orden.posicion_cola}
                                    </span>
                                    <div>
                                        <h4 class="font-medium text-gray-900">${orden.id}</h4>
                                        <p class="text-sm text-gray-600">${orden.descripcion}</p>
                                        <p class="text-xs text-gray-500">${orden.cliente}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <div class="text-sm font-medium">
                                    ${orden.prioridad_original} → 
                                    <span class="text-${
                                        orden.prioridad_ia === 'urgente' ? 'red' :
                                        orden.prioridad_ia === 'alta' ? 'orange' :
                                        'blue'
                                    }-600 font-bold">${orden.prioridad_ia}</span>
                                </div>
                                <div class="text-xs text-gray-500">Score: ${orden.score_prioridad}</div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900">${orden.tiempo_sugerido}</div>
                                <div class="text-xs text-gray-500">${orden.tiempo_estimado_atencion}</div>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Algoritmo: ${data.algoritmo_usado}
                    </div>
                    <div class="space-x-2">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Aplicar Priorización
                        </button>
                        <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                            Exportar Reporte
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
    }

    /**
     * Obtener y mostrar alertas predictivas
     */
    async mostrarAlertasPredictivas() {
        try {
            const response = await fetch(`${this.baseUrl}/alertas-predictivas`);
            const data = await response.json();
            
            if (response.ok) {
                this.renderAlertasPredictivas(data);
            } else {
                throw new Error(data.message || 'Error al obtener alertas');
            }
        } catch (error) {
            this.showError('Error al cargar alertas predictivas: ' + error.message);
        }
    }

    /**
     * Renderizar alertas en el dashboard
     */
    renderAlertasPredictivas(data) {
        const container = document.getElementById('alertas-ia-container');
        if (!container) return;

        container.innerHTML = `
            <div class="space-y-4">
                ${data.alertas.map(alerta => `
                    <div class="border-l-4 border-${
                        alerta.severidad === 'alta' ? 'red' :
                        alerta.severidad === 'media' ? 'yellow' : 'blue'
                    }-500 bg-${
                        alerta.severidad === 'alta' ? 'red' :
                        alerta.severidad === 'media' ? 'yellow' : 'blue'
                    }-50 p-4 rounded-r-lg">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">
                                    <i class="fas fa-${
                                        alerta.tipo === 'sobrecarga_tecnico' ? 'user-clock' :
                                        alerta.tipo === 'demanda_pico' ? 'chart-line' : 'exclamation-triangle'
                                    } mr-2"></i>
                                    ${alerta.mensaje}
                                </h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    Probabilidad: ${alerta.probabilidad}% | Predicción: ${alerta.tiempo_prediccion}
                                </p>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-700 font-medium">Acciones sugeridas:</p>
                                    <ul class="text-sm text-gray-600 list-disc list-inside">
                                        ${alerta.acciones_sugeridas.map(accion => `<li>${accion}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-${
                                    alerta.severidad === 'alta' ? 'red' :
                                    alerta.severidad === 'media' ? 'yellow' : 'blue'
                                }-100 text-${
                                    alerta.severidad === 'alta' ? 'red' :
                                    alerta.severidad === 'media' ? 'yellow' : 'blue'
                                }-800">
                                    ${alerta.severidad.toUpperCase()}
                                </span>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }

    /**
     * Actualizar alertas predictivas automáticamente
     */
    async actualizarAlertasPredictivas() {
        try {
            const response = await fetch(`${this.baseUrl}/alertas-predictivas`);
            const data = await response.json();
            
            if (response.ok) {
                this.renderAlertasPredictivas(data);
                this.updateAlertBadge(data.alertas.length);
            }
        } catch (error) {
            console.log('Error actualizando alertas:', error);
        }
    }

    /**
     * Actualizar badge de alertas en la navegación
     */
    updateAlertBadge(count) {
        const badge = document.querySelector('.alert-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline' : 'none';
        }
    }

    /**
     * Asignar técnico a orden
     */
    async asignarTecnico(tecnicoId) {
        // Esta funcionalidad se implementaría según la lógica específica
        this.showSuccess(`Técnico asignado correctamente`);
    }

    /**
     * Establecer estado de carga
     */
    setLoadingState(element, loading) {
        if (loading) {
            element.disabled = true;
            element.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Cargando...';
        } else {
            element.disabled = false;
            element.innerHTML = element.dataset.originalText || 'IA Recomendar';
        }
        this.isLoading = loading;
    }

    /**
     * Mostrar mensaje de error
     */
    showError(message) {
        this.showToast(message, 'error');
    }

    /**
     * Mostrar mensaje de éxito
     */
    showSuccess(message) {
        this.showToast(message, 'success');
    }

    /**
     * Mostrar toast notification
     */
    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
            type === 'error' ? 'bg-red-600' :
            type === 'success' ? 'bg-green-600' : 'bg-blue-600'
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${
                    type === 'error' ? 'exclamation-circle' :
                    type === 'success' ? 'check-circle' : 'info-circle'
                } mr-2"></i>
                ${message}
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
}

// Inicializar módulo cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.IAModule = new IAModule();
});