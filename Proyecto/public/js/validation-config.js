/**
 * ==========================================
 * CONFIGURACIÓN DE VALIDACIONES - TECHSERVICE PRO
 * ==========================================
 * 
 * Archivo de configuración centralizada para todas las validaciones
 * del sistema TechService Pro.
 * 
 * @version 1.0.0
 * @author TechService Pro Team
 * @date 2024
 */

const ValidationConfig = {
    
    // ========================================
    // CONFIGURACIÓN GENERAL
    // ========================================
    general: {
        locale: 'es-CL',
        timezone: 'America/Santiago',
        currency: 'CLP',
        debug: true // Cambia a false en producción
    },

    // ========================================
    // LÍMITES DE CARACTERES POR CAMPO
    // ========================================
    fieldLimits: {
        // Servicio Técnico
        nombreServicio: { min: 3, max: 45 },
        direccion: { min: 5, max: 45 },
        telefono: { min: 8, max: 15 },
        correo: { min: 5, max: 45 },
        rut: { min: 9, max: 12 },
        
        // Usuario
        userName: { min: 3, max: 25 },
        userEmail: { min: 5, max: 50 },
        password: { min: 8, max: 30 },
        
        // Direcciones
        street: { min: 5, max: 50 },
        city: { min: 3, max: 30 },
        state: { min: 3, max: 30 },
        
        // Generales
        description: { min: 10, max: 200 },
        comments: { min: 5, max: 500 }
    },

    // ========================================
    // EXPRESIONES REGULARES
    // ========================================
    regex: {
        // Email estándar
        email: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
        
        // RUT Chileno
        rut: /^[0-9]+[-|‐]{1}[0-9kK]{1}$/,
        rutNumbers: /^[0-9]{7,8}$/,
        
        // Teléfonos
        phoneChile: /^(\+?56)?([2-9]\d{8})$/,
        phoneInternational: /^\+?[1-9]\d{1,14}$/,
        
        // Nombres y texto
        name: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/,
        alphanumeric: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/,
        
        // Direcciones
        address: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,#\-/°]+$/,
        
        // Seguridad
        xssBasic: /[<>]/,
        sqlInjection: /('|(\\');|;|\/\*|\*\/|xp_|sp_)/i
    },

    // ========================================
    // MENSAJES DE ERROR PERSONALIZADOS
    // ========================================
    messages: {
        required: 'Este campo es obligatorio',
        
        // Longitud
        minLength: (field, min) => `${field} debe tener al menos ${min} caracteres`,
        maxLength: (field, max) => `${field} no puede tener más de ${max} caracteres`,
        exactLength: (field, length) => `${field} debe tener exactamente ${length} caracteres`,
        
        // Formato
        invalidEmail: 'Por favor ingresa un email válido',
        invalidRUT: 'RUT inválido. Formato: 12.345.678-K',
        invalidPhone: 'Teléfono inválido. Ejemplo: +56912345678',
        
        // Contenido
        invalidChars: 'Contiene caracteres no permitidos',
        xssDetected: 'Se detectaron caracteres peligrosos',
        sqlDetected: 'Se detectó contenido sospechoso',
        
        // Específicos
        rutFormat: 'RUT debe ser formato 12345678-K o 12.345.678-K',
        phoneFormat: 'Teléfono debe incluir código de país (+56)',
        
        // Estados
        processing: 'Procesando...',
        success: 'Campo válido ✓',
        checking: 'Validando...'
    },

    // ========================================
    // CONFIGURACIÓN DE UI
    // ========================================
    ui: {
        // Clases CSS
        classes: {
            valid: 'input-valid border-green-500',
            invalid: 'input-invalid border-red-500',
            warning: 'input-warning border-yellow-500',
            processing: 'input-processing border-blue-500',
            
            errorMessage: 'error-message text-red-500 text-sm mt-1',
            successMessage: 'success-message text-green-500 text-sm mt-1',
            warningMessage: 'warning-message text-yellow-500 text-sm mt-1',
            
            charCounter: 'char-counter text-xs text-gray-500 mt-1',
            charCounterWarning: 'char-counter-warning text-yellow-500',
            charCounterError: 'char-counter-error text-red-500'
        },
        
        // Animaciones
        animations: {
            duration: 300, // ms
            easing: 'ease-in-out',
            shakeDuration: 600,
            fadeInDuration: 200
        },
        
        // Timeouts
        timeouts: {
            debounce: 300, // ms para evitar validaciones excesivas
            showMessage: 3000, // ms para mostrar mensajes
            autoHide: 5000 // ms para ocultar automáticamente
        }
    },

    // ========================================
    // CONFIGURACIÓN ESPECÍFICA POR PAÍS
    // ========================================
    country: {
        chile: {
            phonePrefix: '+56',
            rutLength: { min: 9, max: 12 },
            regions: [
                'Arica y Parinacota', 'Tarapacá', 'Antofagasta', 'Atacama',
                'Coquimbo', 'Valparaíso', 'Metropolitana', 'O\'Higgins',
                'Maule', 'Ñuble', 'Biobío', 'La Araucanía', 'Los Ríos',
                'Los Lagos', 'Aysén', 'Magallanes'
            ]
        }
    },

    // ========================================
    // CONFIGURACIÓN DE SEGURIDAD
    // ========================================
    security: {
        // Lista de caracteres prohibidos
        forbiddenChars: ['<', '>', '"', "'", '&', ';', '(', ')', '{', '}'],
        
        // Lista de palabras prohibidas (básica)
        forbiddenWords: [
            'script', 'javascript', 'vbscript', 'onload', 'onerror',
            'onclick', 'onmouseover', 'eval', 'expression', 'url(',
            'select', 'union', 'insert', 'update', 'delete', 'drop'
        ],
        
        // Máximo número de intentos
        maxAttempts: 5,
        
        // Tiempo de bloqueo (ms)
        lockoutTime: 300000 // 5 minutos
    },

    // ========================================
    // FUNCIONES AUXILIARES
    // ========================================
    utils: {
        /**
         * Obtiene la configuración de límites para un campo
         * @param {string} fieldName - Nombre del campo
         * @returns {object} - Límites min/max
         */
        getFieldLimits(fieldName) {
            return this.fieldLimits[fieldName] || { min: 1, max: 255 };
        },

        /**
         * Obtiene el mensaje de error apropiado
         * @param {string} type - Tipo de error
         * @param {string} field - Nombre del campo
         * @param {any} value - Valor adicional
         * @returns {string} - Mensaje de error
         */
        getMessage(type, field, value) {
            const message = this.messages[type];
            return typeof message === 'function' ? message(field, value) : message;
        },

        /**
         * Valida si el entorno es de desarrollo
         * @returns {boolean}
         */
        isDevelopment() {
            return this.general.debug === true;
        }
    }
};

// ========================================
// EXPORTAR CONFIGURACIÓN
// ========================================

// Para uso en navegador
if (typeof window !== 'undefined') {
    window.ValidationConfig = ValidationConfig;
}

// Para uso en Node.js
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ValidationConfig;
}

// Para uso con ES6 modules (comentado para compatibilidad)
// export default ValidationConfig;

// Log de carga en desarrollo
if (ValidationConfig.utils.isDevelopment()) {
    console.log('🔧 ValidationConfig cargado correctamente');
    console.log('📋 Campos configurados:', Object.keys(ValidationConfig.fieldLimits).length);
    console.log('🔒 Reglas de seguridad activas:', ValidationConfig.security.forbiddenWords.length, 'palabras prohibidas');
}