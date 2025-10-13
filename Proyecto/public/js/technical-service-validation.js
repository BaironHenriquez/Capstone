/**
 * ==========================================
 * VALIDACIONES JAVASCRIPT - SERVICIO TÉCNICO
 * ==========================================
 * 
 * Sistema de validación en tiempo real para el formulario
 * de configuración del servicio técnico en TechService Pro.
 * 
 * @version 1.1.0
 * @author TechService Pro Team
 * @date 2024
 * @requires validation-config.js
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Elementos del formulario
    const form = document.querySelector('form[action*="setup/technical-service"]');
    const nombreInput = document.getElementById('nombre_servicio');
    const direccionInput = document.getElementById('direccion');
    const telefonoInput = document.getElementById('telefono');
    const correoInput = document.getElementById('correo');
    const rutInput = document.getElementById('rut');
    const submitButton = form?.querySelector('button[type="submit"]');

    // Verificar que ValidationConfig esté disponible
    if (typeof ValidationConfig === 'undefined') {
        console.error('❌ ValidationConfig no encontrado. Usando configuración por defecto.');
        window.ValidationConfig = {
            fieldLimits: {
                nombreServicio: { min: 3, max: 45 },
                direccion: { min: 5, max: 45 },
                telefono: { min: 8, max: 15 },
                correo: { min: 5, max: 45 },
                rut: { min: 9, max: 12 }
            },
            regex: {
                email: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
                xssBasic: /[<>]/
            }
        };
    }

    // Configuración de validaciones usando ValidationConfig
    const config = ValidationConfig.fieldLimits;

    // Funciones de validación
    const validators = {
        
        // Validar longitud de texto
        validateLength: function(value, min, max) {
            return value.length >= min && value.length <= max;
        },

        // Validar formato de email
        validateEmail: function(email) {
            const regex = ValidationConfig.regex?.email || /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        },

        // Validar formato de RUT chileno
        validateRUT: function(rut) {
            // Remover puntos y guión
            const cleanRut = rut.replace(/[.\-]/g, '');
            
            if (cleanRut.length < 8 || cleanRut.length > 9) {
                return false;
            }

            const body = cleanRut.slice(0, -1);
            const dv = cleanRut.slice(-1).toLowerCase();
            
            // Calcular dígito verificador
            let sum = 0;
            let multiplier = 2;
            
            for (let i = body.length - 1; i >= 0; i--) {
                sum += parseInt(body[i]) * multiplier;
                multiplier = multiplier === 7 ? 2 : multiplier + 1;
            }
            
            const calculatedDV = 11 - (sum % 11);
            let expectedDV;
            
            if (calculatedDV === 11) expectedDV = '0';
            else if (calculatedDV === 10) expectedDV = 'k';
            else expectedDV = calculatedDV.toString();
            
            return dv === expectedDV;
        },

        // Validar teléfono
        validatePhone: function(phone) {
            const cleanPhone = phone.replace(/[\s\-\(\)]/g, '');
            const regex = /^(\+56)?[2-9][0-9]{8,9}$/;
            return regex.test(cleanPhone);
        }
    };

    // Funciones de formateo
    const formatters = {
        
        // Formatear RUT
        formatRUT: function(value) {
            let cleanValue = value.replace(/[^0-9kK]/g, '');
            
            if (cleanValue.length > 1) {
                let rut = cleanValue.slice(0, -1);
                let dv = cleanValue.slice(-1);
                
                // Agregar puntos cada 3 dígitos
                if (rut.length > 3) {
                    rut = rut.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                
                return rut + '-' + dv.toUpperCase();
            }
            
            return cleanValue;
        },

        // Formatear teléfono
        formatPhone: function(value) {
            let cleanValue = value.replace(/[^0-9+]/g, '');
            
            // Limitar longitud
            if (cleanValue.length > 15) {
                cleanValue = cleanValue.substring(0, 15);
            }
            
            return cleanValue;
        },

        // Formatear texto (solo letras, números, espacios y caracteres especiales básicos)
        formatText: function(value) {
            return value.replace(/[<>]/g, ''); // Remover caracteres peligrosos
        }
    };

    // Funciones de UI
    const ui = {
        
        // Mostrar error en campo
        showError: function(input, message) {
            this.clearError(input);
            
            input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            input.classList.remove('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-500 text-sm mt-1 error-message';
            errorDiv.textContent = message;
            
            input.parentNode.appendChild(errorDiv);
        },

        // Limpiar error
        clearError: function(input) {
            input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            input.classList.add('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
            
            const errorMessage = input.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        },

        // Mostrar éxito
        showSuccess: function(input) {
            this.clearError(input);
            input.classList.add('border-green-500', 'focus:border-green-500', 'focus:ring-green-500');
            input.classList.remove('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
        },

        // Actualizar contador de caracteres
        updateCharCounter: function(input, current, max) {
            let counter = input.parentNode.querySelector('.char-counter');
            
            if (!counter) {
                counter = document.createElement('div');
                counter.className = 'char-counter text-xs text-gray-500 mt-1';
                input.parentNode.appendChild(counter);
            }
            
            counter.textContent = `${current}/${max} caracteres`;
            
            if (current > max * 0.9) {
                counter.classList.add('text-yellow-600');
            } else {
                counter.classList.remove('text-yellow-600');
            }
            
            if (current >= max) {
                counter.classList.add('text-red-600');
                counter.classList.remove('text-yellow-600');
            } else {
                counter.classList.remove('text-red-600');
            }
        }
    };

    // Validadores específicos para cada campo
    const fieldValidators = {
        
        nombre_servicio: function(value) {
            const errors = [];
            
            if (!value.trim()) {
                errors.push('El nombre del servicio es obligatorio.');
            } else if (!validators.validateLength(value, config.nombreServicio.min, config.nombreServicio.max)) {
                errors.push(`Debe tener entre ${config.nombreServicio.min} y ${config.nombreServicio.max} caracteres.`);
            }
            
            return errors;
        },

        direccion: function(value) {
            const errors = [];
            
            if (!value.trim()) {
                errors.push('La dirección es obligatoria.');
            } else if (!validators.validateLength(value, config.direccion.min, config.direccion.max)) {
                errors.push(`Debe tener entre ${config.direccion.min} y ${config.direccion.max} caracteres.`);
            }
            
            return errors;
        },

        telefono: function(value) {
            const errors = [];
            
            if (!value.trim()) {
                errors.push('El teléfono es obligatorio.');
            } else if (!validators.validateLength(value, config.minLength.telefono, config.maxLength)) {
                errors.push(`Debe tener entre ${config.minLength.telefono} y ${config.maxLength} caracteres.`);
            } else if (!validators.validatePhone(value)) {
                errors.push('Formato de teléfono inválido. Ej: +56912345678 o 912345678');
            }
            
            return errors;
        },

        correo: function(value) {
            const errors = [];
            
            if (!value.trim()) {
                errors.push('El correo electrónico es obligatorio.');
            } else if (!validators.validateLength(value, config.minLength.correo, config.maxLength)) {
                errors.push(`Debe tener entre ${config.minLength.correo} y ${config.maxLength} caracteres.`);
            } else if (!validators.validateEmail(value)) {
                errors.push('Formato de correo electrónico inválido.');
            }
            
            return errors;
        },

        rut: function(value) {
            const errors = [];
            
            if (!value.trim()) {
                errors.push('El RUT es obligatorio.');
            } else if (!validators.validateLength(value.replace(/[.\-]/g, ''), config.minLength.rut, 12)) {
                errors.push(`RUT debe tener entre ${config.minLength.rut} y 12 caracteres.`);
            } else if (!validators.validateRUT(value)) {
                errors.push('RUT inválido. Ej: 12.345.678-9');
            }
            
            return errors;
        }
    };

    // Configurar validaciones en tiempo real
    function setupRealTimeValidation() {
        
        // Nombre del servicio
        if (nombreInput) {
            nombreInput.addEventListener('input', function() {
                const value = formatters.formatText(this.value);
                this.value = value.substring(0, config.maxLength);
                
                const errors = fieldValidators.nombre_servicio(this.value);
                
                if (errors.length > 0) {
                    ui.showError(this, errors[0]);
                } else {
                    ui.showSuccess(this);
                }
                
                ui.updateCharCounter(this, this.value.length, config.maxLength);
            });
        }

        // Dirección
        if (direccionInput) {
            direccionInput.addEventListener('input', function() {
                const value = formatters.formatText(this.value);
                this.value = value.substring(0, config.maxLength);
                
                const errors = fieldValidators.direccion(this.value);
                
                if (errors.length > 0) {
                    ui.showError(this, errors[0]);
                } else {
                    ui.showSuccess(this);
                }
                
                ui.updateCharCounter(this, this.value.length, config.maxLength);
            });
        }

        // Teléfono
        if (telefonoInput) {
            telefonoInput.addEventListener('input', function() {
                const formatted = formatters.formatPhone(this.value);
                this.value = formatted.substring(0, config.maxLength);
                
                const errors = fieldValidators.telefono(this.value);
                
                if (errors.length > 0) {
                    ui.showError(this, errors[0]);
                } else {
                    ui.showSuccess(this);
                }
                
                ui.updateCharCounter(this, this.value.length, config.maxLength);
            });
        }

        // Correo
        if (correoInput) {
            correoInput.addEventListener('input', function() {
                this.value = this.value.substring(0, config.maxLength);
                
                const errors = fieldValidators.correo(this.value);
                
                if (errors.length > 0) {
                    ui.showError(this, errors[0]);
                } else {
                    ui.showSuccess(this);
                }
                
                ui.updateCharCounter(this, this.value.length, config.maxLength);
            });

            correoInput.addEventListener('blur', function() {
                if (this.value.trim()) {
                    const errors = fieldValidators.correo(this.value);
                    if (errors.length > 0) {
                        ui.showError(this, errors[0]);
                    } else {
                        ui.showSuccess(this);
                    }
                }
            });
        }

        // RUT
        if (rutInput) {
            rutInput.addEventListener('input', function() {
                const formatted = formatters.formatRUT(this.value);
                this.value = formatted;
                
                if (this.value.length >= config.minLength.rut) {
                    const errors = fieldValidators.rut(this.value);
                    
                    if (errors.length > 0) {
                        ui.showError(this, errors[0]);
                    } else {
                        ui.showSuccess(this);
                    }
                } else {
                    ui.clearError(this);
                }
                
                ui.updateCharCounter(this, this.value.replace(/[.\-]/g, '').length, 9);
            });

            rutInput.addEventListener('blur', function() {
                if (this.value.trim()) {
                    const errors = fieldValidators.rut(this.value);
                    if (errors.length > 0) {
                        ui.showError(this, errors[0]);
                    } else {
                        ui.showSuccess(this);
                    }
                }
            });
        }
    }

    // Validación completa del formulario
    function validateForm() {
        let isValid = true;
        const fields = [
            { input: nombreInput, validator: 'nombre_servicio' },
            { input: direccionInput, validator: 'direccion' },
            { input: telefonoInput, validator: 'telefono' },
            { input: correoInput, validator: 'correo' },
            { input: rutInput, validator: 'rut' }
        ];

        fields.forEach(field => {
            if (field.input) {
                const errors = fieldValidators[field.validator](field.input.value);
                
                if (errors.length > 0) {
                    ui.showError(field.input, errors[0]);
                    isValid = false;
                } else {
                    ui.showSuccess(field.input);
                }
            }
        });

        return isValid;
    }

    // Configurar validación en envío del formulario
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                `;
            }

            if (validateForm()) {
                // Si todo está válido, enviar el formulario
                setTimeout(() => {
                    this.submit();
                }, 500);
            } else {
                // Restaurar botón si hay errores
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = `
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Completar Configuración
                        </span>
                    `;
                }
            }
        });
    }

    // Inicializar validaciones
    setupRealTimeValidation();

    // Agregar contadores de caracteres iniciales
    [nombreInput, direccionInput, telefonoInput, correoInput].forEach(input => {
        if (input) {
            ui.updateCharCounter(input, input.value.length, config.maxLength);
        }
    });

    if (rutInput) {
        ui.updateCharCounter(rutInput, rutInput.value.replace(/[.\-]/g, '').length, 9);
    }

    console.log('✅ Validaciones del formulario de Servicio Técnico cargadas correctamente');
});