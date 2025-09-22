// JavaScript para funcionalidad de autenticación - Baieco
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar efectos y funcionalidades
    initAuthEffects();
    initFormValidation();
    initDemoCredentials();
    createParticles();
});

/**
 * Inicializar efectos visuales de la página de login
 */
function initAuthEffects() {
    // Animación de entrada del formulario
    const form = document.querySelector('.glass-form');
    if (form) {
        form.style.opacity = '0';
        form.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            form.style.transition = 'all 0.8s ease';
            form.style.opacity = '1';
            form.style.transform = 'translateY(0)';
        }, 100);
    }

    // Efecto de focus mejorado en inputs
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    });
}

/**
 * Validación mejorada del formulario
 */
function initFormValidation() {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email-address');
    const passwordInput = document.getElementById('password');
    const submitButton = form.querySelector('button[type="submit"]');

    // Validación en tiempo real del email
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            validateEmail(this);
        });
    }

    // Validación de contraseña
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            validatePassword(this);
        });
    }

    // Manejo del envío del formulario
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                showLoadingState(submitButton);
                simulateLogin();
            }
        });
    }
}

/**
 * Validar formato de email
 */
function validateEmail(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(input.value);
    
    input.classList.toggle('input-error', !isValid && input.value.length > 0);
    
    return isValid || input.value.length === 0;
}

/**
 * Validar contraseña
 */
function validatePassword(input) {
    const isValid = input.value.length >= 3; // Mínimo 3 caracteres para demo
    
    input.classList.toggle('input-error', !isValid && input.value.length > 0);
    
    return isValid || input.value.length === 0;
}

/**
 * Validar formulario completo
 */
function validateForm() {
    const email = document.getElementById('email-address');
    const password = document.getElementById('password');
    
    const emailValid = validateEmail(email);
    const passwordValid = validatePassword(password);
    
    if (!emailValid || !passwordValid) {
        showNotification('Por favor, revisa los campos marcados en rojo', 'error');
        return false;
    }
    
    if (email.value === '' || password.value === '') {
        showNotification('Por favor, completa todos los campos', 'warning');
        return false;
    }
    
    return true;
}

/**
 * Mostrar estado de carga en el botón
 */
function showLoadingState(button) {
    const originalText = button.innerHTML;
    const spinner = '<div class="loading-spinner"></div>';
    
    button.innerHTML = `${spinner} Iniciando sesión...`;
    button.disabled = true;
    
    // Mostrar spinner
    const spinnerElement = button.querySelector('.loading-spinner');
    if (spinnerElement) {
        spinnerElement.style.display = 'inline-block';
    }
    
    // Restaurar estado después de simular login
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    }, 2000);
}

/**
 * Simular proceso de login
 */
function simulateLogin() {
    const email = document.getElementById('email-address').value;
    const password = document.getElementById('password').value;
    
    // Simular delay de servidor
    setTimeout(() => {
        // Verificar credenciales demo
        if (isDemoCredentials(email, password)) {
            showNotification('¡Bienvenido a Baieco! Redirigiendo al dashboard...', 'success');
            setTimeout(() => {
                window.location.href = '/dashboard'; // Cambiar por la ruta correcta
            }, 1500);
        } else {
            showNotification('Credenciales incorrectas. Intenta con las credenciales demo.', 'error');
        }
    }, 2000);
}

/**
 * Verificar si son credenciales demo
 */
function isDemoCredentials(email, password) {
    const demoCredentials = [
        { email: 'admin@baieco.cl', password: 'admin123' },
        { email: 'tecnico@techfixpro.cl', password: 'tecnico123' },
        { email: 'demo@baieco.cl', password: '123456' },
        { email: 'pedro@repairzone.cl', password: 'demo123' }
    ];
    
    return demoCredentials.some(cred => 
        cred.email.toLowerCase() === email.toLowerCase() && 
        cred.password === password
    );
}

/**
 * Inicializar funcionalidad de credenciales demo
 */
function initDemoCredentials() {
    // Botón para rellenar credenciales demo
    const demoButtons = document.querySelectorAll('[data-demo-user]');
    demoButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userType = this.dataset.demoUser;
            fillDemoCredentials(userType);
        });
    });
}

/**
 * Rellenar campos con credenciales demo
 */
function fillDemoCredentials(userType) {
    const credentials = {
        admin: { email: 'admin@baieco.cl', password: 'admin123' },
        tecnico: { email: 'tecnico@techfixpro.cl', password: 'tecnico123' },
        demo: { email: 'demo@baieco.cl', password: '123456' }
    };
    
    const cred = credentials[userType];
    if (cred) {
        document.getElementById('email-address').value = cred.email;
        document.getElementById('password').value = cred.password;
        
        // Animación de llenado
        const inputs = [document.getElementById('email-address'), document.getElementById('password')];
        inputs.forEach((input, index) => {
            setTimeout(() => {
                input.style.background = '#e0f2fe';
                setTimeout(() => {
                    input.style.background = '';
                }, 500);
            }, index * 200);
        });
        
        showNotification(`Credenciales de ${userType} cargadas`, 'info');
    }
}

/**
 * Sistema de notificaciones
 */
function showNotification(message, type = 'info') {
    // Remover notificación existente
    const existing = document.querySelector('.auth-notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `auth-notification fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${getNotificationClasses(type)}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${getNotificationIcon(type)}</span>
            <span>${message}</span>
            <button class="ml-4 text-current opacity-70 hover:opacity-100" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animación de entrada
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
        notification.style.opacity = '1';
    }, 10);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

/**
 * Obtener clases CSS para tipos de notificación
 */
function getNotificationClasses(type) {
    const classes = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        warning: 'bg-yellow-500 text-black',
        info: 'bg-blue-500 text-white'
    };
    return classes[type] + ' transform translate-x-full opacity-0 transition-all duration-300';
}

/**
 * Obtener icono para tipos de notificación
 */
function getNotificationIcon(type) {
    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };
    return icons[type] || 'ℹ';
}

/**
 * Crear partículas flotantes de fondo
 */
function createParticles() {
    const particlesContainer = document.querySelector('.particles');
    if (!particlesContainer) return;
    
    for (let i = 0; i < 3; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 6 + 's';
        particle.style.animationDuration = (6 + Math.random() * 4) + 's';
        particlesContainer.appendChild(particle);
    }
}

/**
 * Efectos de teclado
 */
document.addEventListener('keydown', function(e) {
    // Enter para enviar formulario
    if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
        const form = document.querySelector('form');
        if (form) {
            form.requestSubmit();
        }
    }
    
    // Escape para limpiar formulario
    if (e.key === 'Escape') {
        clearForm();
    }
});

/**
 * Limpiar formulario
 */
function clearForm() {
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
        input.value = '';
        input.classList.remove('input-error');
    });
    showNotification('Formulario limpiado', 'info');
}

/**
 * Detectar modo oscuro del sistema
 */
function detectDarkMode() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark-mode');
    }
}

// Inicializar detección de modo oscuro
detectDarkMode();

// Listener para cambios en el modo oscuro
if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', detectDarkMode);
}