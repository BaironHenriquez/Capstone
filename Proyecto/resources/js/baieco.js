// Baieco - Sistema de Gestión de Órdenes de Servicio
// JavaScript para funcionalidades e interacciones

document.addEventListener('DOMContentLoaded', function() {
    
    // Configuración de la aplicación
    const config = {
        animationDuration: 300,
        scrollOffset: 100,
        typingSpeed: 50,
        counterSpeed: 2000
    };

    // Intersection Observer para animaciones al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observar todos los elementos con animación en scroll
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Navegación suave
    function initSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // Efecto navbar al hacer scroll
    function handleNavbarScroll() {
        const navbar = document.querySelector('nav');
        const scrolled = window.pageYOffset;
        
        if (scrolled > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }

    // Animación de contador
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = config.counterSpeed;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    counter.textContent = target + (counter.getAttribute('data-suffix') || '');
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current) + (counter.getAttribute('data-suffix') || '');
                }
            }, 16);
        });
    }

    // Animación de escritura
    function typeWriter(element, text, speed = config.typingSpeed) {
        let i = 0;
        element.innerHTML = '';
        
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }

    // Efectos hover para tarjetas de características
    function initFeatureCardEffects() {
        const cards = document.querySelectorAll('.feature-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
                this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.05)';
            });
        });
    }

    // Formulario de consulta de órdenes
    function initOrderLookupForm() {
        const form = document.getElementById('order-lookup-form');
        const input = document.getElementById('order-code');
        const button = form?.querySelector('button[type="submit"]');
        
        if (!form || !input || !button) return;

        // Validación en tiempo real - aceptar múltiples formatos
        input.addEventListener('input', function() {
            const value = this.value.toUpperCase().trim();
            this.value = value;
            
            // Formatos aceptados: BA-YYYY-NNN, TS-YYYY-NNNN, o similar
            const isValid = /^[A-Z]{2,3}-\d{4}-\d{3,4}$/.test(value) || value === '';
            
            if (isValid || value === '') {
                this.classList.remove('border-red-500', 'ring-red-500');
                this.classList.add('border-green-500', 'ring-green-500');
                button.disabled = false;
            } else {
                this.classList.remove('border-green-500', 'ring-green-500');
                this.classList.add('border-red-500', 'ring-red-500');
                button.disabled = value.length > 0; // Solo deshabilitar si hay texto inválido
            }
        });

        // Permitir el envío normal del formulario
        form.addEventListener('submit', function(e) {
            const orderCode = input.value.trim();
            
            if (!orderCode) {
                e.preventDefault();
                alert('Por favor ingresa un código de orden');
                return;
            }
            
            // Validar formato antes de enviar
            if (!/^[A-Z]{2,3}-\d{4}-\d{3,4}$/.test(orderCode)) {
                e.preventDefault();
                alert('Formato inválido. Usa: TS-2025-3956 o BA-2025-001');
                return;
            }
            
            // Dejar que el formulario se envíe normalmente (no preventDefault)
            button.disabled = true;
            button.innerHTML = '<div class="loading-spinner inline-block mr-2"></div> Buscando...';
        });
    }

    // Búsqueda de orden
    function searchOrder(orderCode) {
        const button = document.querySelector('#order-lookup-form button[type="submit"]');
        const originalText = button.innerHTML;
        
        // Mostrar loading
        button.innerHTML = `
            <div class="loading-spinner inline-block mr-2"></div>
            Buscando...
        `;
        button.disabled = true;

        // Simular búsqueda (reemplazar con llamada real a la API)
        setTimeout(() => {
            const mockOrder = {
                code: orderCode,
                status: 'En reparación',
                device: 'iPhone 12 Pro',
                description: 'Cambio de pantalla',
                date: '2025-09-20',
                technician: 'TechFix Solutions',
                estimatedCompletion: '2025-09-25'
            };
            
            showOrderResult(mockOrder);
            
            // Restaurar botón
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    }

    // Mostrar resultado de la orden
    function showOrderResult(order) {
        const resultContainer = document.getElementById('order-result');
        
        if (!resultContainer) return;

        const statusColors = {
            'Recibido': 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'En diagnóstico': 'bg-blue-100 text-blue-800 border-blue-200',
            'En reparación': 'bg-orange-100 text-orange-800 border-orange-200',
            'Completado': 'bg-green-100 text-green-800 border-green-200',
            'Entregado': 'bg-gray-100 text-gray-800 border-gray-200'
        };

        const statusColor = statusColors[order.status] || 'bg-gray-100 text-gray-800 border-gray-200';

        resultContainer.innerHTML = `
            <div class="bg-white rounded-2xl p-8 shadow-large border animate-scale-in">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-baieco-primary">Orden Encontrada</h3>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold border ${statusColor}">
                        ${order.status}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Información del Equipo</h4>
                        <p class="text-gray-600"><strong>Código:</strong> ${order.code}</p>
                        <p class="text-gray-600"><strong>Dispositivo:</strong> ${order.device}</p>
                        <p class="text-gray-600"><strong>Descripción:</strong> ${order.description}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Detalles del Servicio</h4>
                        <p class="text-gray-600"><strong>Taller:</strong> ${order.technician}</p>
                        <p class="text-gray-600"><strong>Fecha ingreso:</strong> ${order.date}</p>
                        <p class="text-gray-600"><strong>Entrega estimada:</strong> ${order.estimatedCompletion}</p>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Última actualización: Hace 2 horas</span>
                        <button onclick="printOrder()" class="text-baieco-secondary hover:text-baieco-primary transition-colors duration-300">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Imprimir
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        resultContainer.classList.remove('hidden');
        resultContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Formulario de demo
    function initDemoForm() {
        const demoModal = document.getElementById('demo-modal');
        const demoForm = document.getElementById('demo-form');
        const openDemoButtons = document.querySelectorAll('[data-action="open-demo"]');
        const closeDemoButton = document.getElementById('close-demo');

        openDemoButtons.forEach(button => {
            button.addEventListener('click', () => {
                demoModal.classList.remove('hidden');
                demoModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });

        closeDemoButton?.addEventListener('click', () => {
            demoModal.classList.add('hidden');
            demoModal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        });

        // Cerrar modal al hacer clic fuera
        demoModal?.addEventListener('click', (e) => {
            if (e.target === demoModal) {
                demoModal.classList.add('hidden');
                demoModal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        });

        // Envío del formulario de demo
        demoForm?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simular envío
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = `
                <div class="loading-spinner inline-block mr-2"></div>
                Enviando...
            `;
            submitButton.disabled = true;
            
            setTimeout(() => {
                BaiecoNotifications.show('¡Demo solicitada con éxito! Te contactaremos pronto.', 'success');
                demoModal.classList.add('hidden');
                demoModal.classList.remove('flex');
                document.body.style.overflow = 'auto';
                this.reset();
                
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 2000);
        });
    }

    // Sistema de notificaciones
    window.BaiecoNotifications = {
        show: function(message, type = 'info', duration = 5000) {
            const notification = document.createElement('div');
            const typeClasses = {
                success: 'bg-baieco-success',
                error: 'bg-red-500',
                warning: 'bg-baieco-warning',
                info: 'bg-baieco-secondary'
            };
            
            const icons = {
                success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
                error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
                warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>',
                info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            };
            
            notification.className = `fixed top-20 right-4 ${typeClasses[type]} text-white px-6 py-4 rounded-xl shadow-large z-50 animate-slide-in-right`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${icons[type]}
                    </svg>
                    <span>${message}</span>
                    <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('animate-slide-out');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, duration);
        }
    };

    // Función global para imprimir orden
    window.printOrder = function() {
        window.print();
    };

    // Inicializar funcionalidades cuando el DOM esté listo
    function init() {
        initSmoothScrolling();
        initFeatureCardEffects();
        initOrderLookupForm();
        initDemoForm();
        
        // Eventos de scroll
        window.addEventListener('scroll', handleNavbarScroll);
        
        // Inicializar contadores cuando entren en vista
        const statsSection = document.querySelector('#estadisticas');
        if (statsSection) {
            const statsObserver = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(statsSection);
                }
            });
            statsObserver.observe(statsSection);
        }
        
        // Animación de escritura para el título hero
        const heroTitle = document.querySelector('.hero-title .typing-text');
        if (heroTitle) {
            const text = heroTitle.textContent;
            heroTitle.textContent = '';
            setTimeout(() => {
                typeWriter(heroTitle, text);
            }, 1000);
        }
    }

    // Inicializar todo
    init();
    
    // Manejar mensajes de éxito de Laravel
    const successMessage = document.querySelector('#success-alert');
    if (successMessage) {
        setTimeout(() => {
            successMessage.classList.add('animate-slide-out');
        }, 5000);
    }
});

// Utilitarios adicionales
window.BaiecoUtils = {
    // Formatear código de orden
    formatOrderCode: function(code) {
        return code.toUpperCase().replace(/[^A-Z0-9-]/g, '');
    },
    
    // Validar email
    validateEmail: function(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },
    
    // Formatear fecha
    formatDate: function(date) {
        return new Date(date).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
};