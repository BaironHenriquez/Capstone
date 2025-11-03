/**
 * Módulo de Formularios Dinámicos
 * Maneja validaciones, campos dinámicos y envío de formularios
 */

class FormModule {
    constructor() {
        this.validationRules = {};
        this.dynamicFields = {};
        this.formData = {};
        this.init();
    }

    init() {
        this.bindEvents();
        this.initValidationRules();
        this.setupFormWatchers();
    }

    bindEvents() {
        // Eventos de validación en tiempo real
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('validate-input')) {
                this.validateField(e.target);
            }
        });

        // Eventos de envío de formularios
        document.addEventListener('submit', (e) => {
            if (e.target.classList.contains('dynamic-form')) {
                e.preventDefault();
                this.handleFormSubmit(e.target);
            }
        });

        // Eventos de campos dinámicos
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('trigger-dynamic')) {
                this.handleDynamicFieldChange(e.target);
            }
        });

        // Eventos de botones de acción
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-add-field')) {
                this.addDynamicField(e.target);
            }
            
            if (e.target.classList.contains('btn-remove-field')) {
                this.removeDynamicField(e.target);
            }

            if (e.target.classList.contains('btn-auto-fill')) {
                this.autoFillForm(e.target);
            }

            if (e.target.classList.contains('btn-save-draft')) {
                this.saveDraft(e.target);
            }

            if (e.target.classList.contains('btn-load-draft')) {
                this.loadDraft(e.target);
            }
        });

        // Verificar existencia antes de agregar addEventListener
        document.addEventListener('DOMContentLoaded', function() {
            const tipoServicioInput = document.querySelector('[name="tipo_servicio"]');
            const prioridadInput = document.querySelector('[name="prioridad"]');
            const precioInput = document.querySelector('[name="precio_presupuestado"]');
            const abonoInput = document.querySelector('[name="abono"]');

            if (tipoServicioInput) {
                tipoServicioInput.addEventListener('change', function() {
                    const btnIA = document.querySelector('.btn-recomendar-tecnico');
                    if (btnIA) {
                        btnIA.dataset.tipoServicio = this.value;
                    }
                });
            }

            if (prioridadInput) {
                prioridadInput.addEventListener('change', function() {
                    const btnIA = document.querySelector('.btn-recomendar-tecnico');
                    if (btnIA) {
                        btnIA.dataset.prioridad = this.value;
                    }
                });
            }

            if (precioInput && abonoInput) {
                function calcularSaldo() {
                    const precio = parseFloat(precioInput.value) || 0;
                    const abono = parseFloat(abonoInput.value) || 0;
                    const saldo = precio - abono;
                    console.log('Saldo calculado:', saldo);
                }

                precioInput.addEventListener('input', calcularSaldo);
                abonoInput.addEventListener('input', calcularSaldo);
            }
        });
    }

    /**
     * Inicializar reglas de validación
     */
    initValidationRules() {
        this.validationRules = {
            email: {
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Ingrese un email válido'
            },
            phone: {
                pattern: /^[+]?[\d\s\-\(\)]{8,15}$/,
                message: 'Ingrese un teléfono válido'
            },
            rut: {
                pattern: /^[\d]{1,2}\.?[\d]{3}\.?[\d]{3}[-]?[\dkK]{1}$/,
                message: 'Ingrese un RUT válido (ej: 12.345.678-9)',
                custom: this.validateRut
            },
            required: {
                test: (value) => value && value.trim() !== '',
                message: 'Este campo es obligatorio'
            },
            minLength: {
                test: (value, min) => value && value.length >= min,
                message: (min) => `Mínimo ${min} caracteres`
            },
            maxLength: {
                test: (value, max) => !value || value.length <= max,
                message: (max) => `Máximo ${max} caracteres`
            },
            numeric: {
                pattern: /^[\d]+$/,
                message: 'Solo se permiten números'
            },
            alphanumeric: {
                pattern: /^[a-zA-Z0-9\s]+$/,
                message: 'Solo se permiten letras y números'
            },
            password: {
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/,
                message: 'Contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula y un número'
            }
        };
    }

    /**
     * Validar campo individual
     */
    validateField(field) {
        const rules = field.dataset.validate?.split('|') || [];
        const value = field.value;
        let isValid = true;
        let errorMessage = '';

        // Limpiar errores previos
        this.clearFieldError(field);

        for (const rule of rules) {
            const [ruleName, ...params] = rule.split(':');
            const validationRule = this.validationRules[ruleName];

            if (!validationRule) continue;

            let ruleResult = true;

            if (validationRule.pattern) {
                ruleResult = validationRule.pattern.test(value);
            } else if (validationRule.test) {
                ruleResult = validationRule.test(value, ...params);
            } else if (validationRule.custom) {
                ruleResult = validationRule.custom(value);
            }

            if (!ruleResult) {
                isValid = false;
                errorMessage = typeof validationRule.message === 'function' 
                    ? validationRule.message(...params)
                    : validationRule.message;
                break;
            }
        }

        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.showFieldSuccess(field);
        }

        return isValid;
    }

    /**
     * Validar RUT chileno
     */
    validateRut(rut) {
        if (!rut) return false;
        
        // Limpiar RUT
        const cleanRut = rut.replace(/[.-]/g, '');
        const body = cleanRut.slice(0, -1);
        const dv = cleanRut.slice(-1).toLowerCase();
        
        if (body.length < 7) return false;
        
        // Calcular dígito verificador
        let sum = 0;
        let multiplier = 2;
        
        for (let i = body.length - 1; i >= 0; i--) {
            sum += parseInt(body[i]) * multiplier;
            multiplier = multiplier === 7 ? 2 : multiplier + 1;
        }
        
        const expectedDv = 11 - (sum % 11);
        const finalDv = expectedDv === 11 ? '0' : expectedDv === 10 ? 'k' : expectedDv.toString();
        
        return dv === finalDv;
    }

    /**
     * Mostrar error en campo
     */
    showFieldError(field, message) {
        field.classList.add('border-red-500', 'bg-red-50');
        field.classList.remove('border-green-500', 'bg-green-50');
        
        let errorElement = field.parentNode.querySelector('.field-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error text-sm text-red-600 mt-1';
            field.parentNode.appendChild(errorElement);
        }
        errorElement.textContent = message;
        
        // Agregar ícono de error
        const iconContainer = field.parentNode.querySelector('.field-icon') || this.createFieldIconContainer(field);
        iconContainer.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
    }

    /**
     * Mostrar éxito en campo
     */
    showFieldSuccess(field) {
        field.classList.add('border-green-500', 'bg-green-50');
        field.classList.remove('border-red-500', 'bg-red-50');
        
        this.clearFieldError(field);
        
        // Agregar ícono de éxito
        const iconContainer = field.parentNode.querySelector('.field-icon') || this.createFieldIconContainer(field);
        iconContainer.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
    }

    /**
     * Limpiar error de campo
     */
    clearFieldError(field) {
        field.classList.remove('border-red-500', 'bg-red-50', 'border-green-500', 'bg-green-50');
        
        const errorElement = field.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
        
        const iconContainer = field.parentNode.querySelector('.field-icon');
        if (iconContainer) {
            iconContainer.innerHTML = '';
        }
    }

    /**
     * Crear contenedor de ícono de campo
     */
    createFieldIconContainer(field) {
        const container = document.createElement('div');
        container.className = 'field-icon absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none';
        
        // Hacer el campo padre relativo si no lo es
        if (!field.parentNode.classList.contains('relative')) {
            field.parentNode.classList.add('relative');
        }
        
        field.parentNode.appendChild(container);
        return container;
    }

    /**
     * Manejar envío de formulario
     */
    async handleFormSubmit(form) {
        const formData = new FormData(form);
        const formId = form.id || 'form';
        
        // Validar todos los campos
        const inputs = form.querySelectorAll('.validate-input');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            this.showFormError(form, 'Por favor corrija los errores antes de continuar');
            return;
        }

        // Mostrar loading
        this.showFormLoading(form);

        try {
            const response = await fetch(form.action || window.location.pathname, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            const result = await response.json();

            if (response.ok) {
                this.showFormSuccess(form, result.message || 'Datos guardados exitosamente');
                
                // Limpiar formulario si es necesario
                if (form.dataset.clearOnSuccess === 'true') {
                    form.reset();
                    this.clearAllFieldStates(form);
                }
                
                // Redireccionar si es necesario
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1500);
                }
                
                // Ejecutar callback personalizado
                if (form.dataset.onSuccess) {
                    window[form.dataset.onSuccess](result);
                }
                
            } else {
                throw new Error(result.message || 'Error al procesar el formulario');
            }
            
        } catch (error) {
            console.error('Error en formulario:', error);
            this.showFormError(form, error.message || 'Error al enviar el formulario');
        } finally {
            this.hideFormLoading(form);
        }
    }

    /**
     * Manejar cambio en campos dinámicos
     */
    handleDynamicFieldChange(field) {
        const targetSelector = field.dataset.target;
        const targetContainer = document.querySelector(targetSelector);
        
        if (!targetContainer) return;
        
        const selectedValue = field.value;
        const fieldType = field.dataset.dynamicType;
        
        switch (fieldType) {
            case 'servicioTecnico':
                this.loadServicioTecnicoFields(selectedValue, targetContainer);
                break;
            case 'tipoEquipo':
                this.loadTipoEquipoFields(selectedValue, targetContainer);
                break;
            case 'prioridad':
                this.loadPrioridadFields(selectedValue, targetContainer);
                break;
            default:
                this.loadGenericFields(selectedValue, targetContainer, fieldType);
        }
    }

    /**
     * Cargar campos específicos del servicio técnico
     */
    loadServicioTecnicoFields(servicioId, container) {
        const servicioFields = {
            '1': { // Reparación
                marca: { type: 'select', required: true, options: ['HP', 'Dell', 'Lenovo', 'Asus', 'Acer'] },
                modelo: { type: 'text', required: true, placeholder: 'Modelo del equipo' },
                descripcionFalla: { type: 'textarea', required: true, placeholder: 'Describa la falla detalladamente' },
                garantia: { type: 'checkbox', label: 'Equipo en garantía' }
            },
            '2': { // Mantenimiento
                tipoMantenimiento: { type: 'select', required: true, options: ['Preventivo', 'Correctivo', 'Predictivo'] },
                ultimoMantenimiento: { type: 'date', required: false, label: 'Último mantenimiento' },
                componentesRevisar: { type: 'checkbox-group', options: ['Hardware', 'Software', 'Limpieza', 'Actualización'] }
            },
            '3': { // Instalación
                tipoInstalacion: { type: 'select', required: true, options: ['Software', 'Hardware', 'Red', 'Sistema Operativo'] },
                licencias: { type: 'checkbox', label: 'Cliente proporciona licencias' },
                configuracionEspecial: { type: 'textarea', placeholder: 'Configuraciones especiales requeridas' }
            }
        };
        
        this.renderDynamicFields(container, servicioFields[servicioId] || {});
    }

    /**
     * Renderizar campos dinámicos
     */
    renderDynamicFields(container, fields) {
        container.innerHTML = '';
        
        Object.entries(fields).forEach(([fieldName, fieldConfig]) => {
            const fieldContainer = document.createElement('div');
            fieldContainer.className = 'mb-4';
            
            const fieldHTML = this.generateFieldHTML(fieldName, fieldConfig);
            fieldContainer.innerHTML = fieldHTML;
            
            container.appendChild(fieldContainer);
        });
        
        // Re-inicializar eventos para los nuevos campos
        this.initializeDynamicFieldEvents(container);
    }

    /**
     * Generar HTML para campo dinámico
     */
    generateFieldHTML(fieldName, config) {
        const required = config.required ? 'required' : '';
        const validateClass = config.required ? 'validate-input' : '';
        const validateRules = config.required ? 'data-validate="required"' : '';
        
        switch (config.type) {
            case 'select':
                return `
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ${config.label || fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}
                        ${config.required ? '<span class="text-red-500">*</span>' : ''}
                    </label>
                    <select name="${fieldName}" class="${validateClass} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" ${required} ${validateRules}>
                        <option value="">Seleccione una opción</option>
                        ${config.options.map(option => `<option value="${option}">${option}</option>`).join('')}
                    </select>
                `;
                
            case 'textarea':
                return `
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ${config.label || fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}
                        ${config.required ? '<span class="text-red-500">*</span>' : ''}
                    </label>
                    <textarea name="${fieldName}" class="${validateClass} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                             rows="3" ${required} ${validateRules} placeholder="${config.placeholder || ''}"></textarea>
                `;
                
            case 'checkbox':
                return `
                    <label class="flex items-center">
                        <input type="checkbox" name="${fieldName}" value="1" class="mr-2">
                        <span class="text-sm text-gray-700">${config.label || fieldName}</span>
                    </label>
                `;
                
            case 'checkbox-group':
                return `
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ${config.label || fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}
                    </label>
                    <div class="space-y-2">
                        ${config.options.map(option => `
                            <label class="flex items-center">
                                <input type="checkbox" name="${fieldName}[]" value="${option}" class="mr-2">
                                <span class="text-sm text-gray-700">${option}</span>
                            </label>
                        `).join('')}
                    </div>
                `;
                
            case 'date':
                return `
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ${config.label || fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}
                        ${config.required ? '<span class="text-red-500">*</span>' : ''}
                    </label>
                    <input type="date" name="${fieldName}" class="${validateClass} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           ${required} ${validateRules}>
                `;
                
            default: // text input
                return `
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ${config.label || fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}
                        ${config.required ? '<span class="text-red-500">*</span>' : ''}
                    </label>
                    <input type="text" name="${fieldName}" class="${validateClass} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           ${required} ${validateRules} placeholder="${config.placeholder || ''}">
                `;
        }
    }

    /**
     * Inicializar eventos para campos dinámicos
     */
    initializeDynamicFieldEvents(container) {
        const inputs = container.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                if (input.classList.contains('validate-input')) {
                    this.validateField(input);
                }
            });
        });
    }

    /**
     * Auto-llenar formulario
     */
    autoFillForm(button) {
        const formId = button.dataset.formId;
        const dataType = button.dataset.fillType;
        
        const sampleData = {
            cliente: {
                nombre: 'Juan Carlos',
                apellido: 'García Pérez',
                correo: 'juan.garcia@email.com',
                telefono: '+56 9 8765 4321',
                direccion: 'Av. Los Leones 1234, Las Condes',
                rut: '12.345.678-9'
            },
            tecnico: {
                nombre: 'María Elena',
                apellido: 'Rodríguez Silva',
                correo: 'maria.rodriguez@techservice.com',
                telefono: '+56 9 1234 5678',
                especialidad: 'Reparación de laptops',
                experiencia: '5'
            },
            orden: {
                descripcion: 'Reparación de laptop HP Pavilion que no enciende',
                prioridad: 'alta',
                fecha_estimada: this.getDateString(7) // 7 días desde hoy
            }
        };
        
        const data = sampleData[dataType];
        if (!data) return;
        
        Object.entries(data).forEach(([field, value]) => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.value = value;
                this.validateField(input);
            }
        });
        
        this.showNotification('Formulario auto-llenado con datos de ejemplo', 'success');
    }

    /**
     * Guardar borrador
     */
    saveDraft(button) {
        const form = button.closest('form');
        const formData = new FormData(form);
        const draftData = {};
        
        for (let [key, value] of formData.entries()) {
            draftData[key] = value;
        }
        
        const draftKey = `draft_${form.id || 'form'}_${Date.now()}`;
        localStorage.setItem(draftKey, JSON.stringify(draftData));
        
        this.showNotification('Borrador guardado', 'success');
    }

    /**
     * Cargar borrador
     */
    loadDraft(button) {
        const form = button.closest('form');
        const formId = form.id || 'form';
        
        // Buscar borradores para este formulario
        const drafts = Object.keys(localStorage)
            .filter(key => key.startsWith(`draft_${formId}`))
            .map(key => ({
                key,
                data: JSON.parse(localStorage.getItem(key)),
                timestamp: parseInt(key.split('_').pop())
            }))
            .sort((a, b) => b.timestamp - a.timestamp);
        
        if (drafts.length === 0) {
            this.showNotification('No hay borradores guardados', 'warning');
            return;
        }
        
        // Cargar el borrador más reciente
        const latestDraft = drafts[0];
        Object.entries(latestDraft.data).forEach(([field, value]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.value = value;
                this.validateField(input);
            }
        });
        
        this.showNotification('Borrador cargado', 'success');
    }

    /**
     * Configurar observadores de formulario
     */
    setupFormWatchers() {
        // Auto-guardar cada 30 segundos
        setInterval(() => {
            const forms = document.querySelectorAll('.auto-save-form');
            forms.forEach(form => {
                this.autoSaveDraft(form);
            });
        }, 30000);
    }

    /**
     * Auto-guardar borrador
     */
    autoSaveDraft(form) {
        const formData = new FormData(form);
        const hasData = Array.from(formData.values()).some(value => value.trim() !== '');
        
        if (hasData) {
            const draftData = {};
            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }
            
            const draftKey = `autosave_${form.id || 'form'}`;
            localStorage.setItem(draftKey, JSON.stringify(draftData));
        }
    }

    /**
     * Mostrar estado de carga en formulario
     */
    showFormLoading(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';
        }
    }

    /**
     * Ocultar estado de carga en formulario
     */
    hideFormLoading(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = submitBtn.dataset.originalText || 'Enviar';
        }
    }

    /**
     * Mostrar error en formulario
     */
    showFormError(form, message) {
        this.showFormMessage(form, message, 'error');
    }

    /**
     * Mostrar éxito en formulario
     */
    showFormSuccess(form, message) {
        this.showFormMessage(form, message, 'success');
    }

    /**
     * Mostrar mensaje en formulario
     */
    showFormMessage(form, message, type) {
        let messageContainer = form.querySelector('.form-message');
        if (!messageContainer) {
            messageContainer = document.createElement('div');
            messageContainer.className = 'form-message mb-4 p-4 rounded-md';
            form.prepend(messageContainer);
        }
        
        messageContainer.className = `form-message mb-4 p-4 rounded-md ${
            type === 'error' ? 'bg-red-100 text-red-700 border border-red-300' :
            'bg-green-100 text-green-700 border border-green-300'
        }`;
        
        messageContainer.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} mr-2"></i>
                ${message}
            </div>
        `;
        
        setTimeout(() => {
            messageContainer.remove();
        }, 5000);
    }

    /**
     * Limpiar estados de todos los campos
     */
    clearAllFieldStates(form) {
        const inputs = form.querySelectorAll('.validate-input');
        inputs.forEach(input => {
            this.clearFieldError(input);
        });
    }

    /**
     * Obtener fecha string
     */
    getDateString(daysFromNow = 0) {
        const date = new Date();
        date.setDate(date.getDate() + daysFromNow);
        return date.toISOString().split('T')[0];
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
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.FormModule = new FormModule();
});