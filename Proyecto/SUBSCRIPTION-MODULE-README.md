# Módulo de Suscripción y Autenticación Social - TechService Pro

Este módulo implementa un sistema completo de autenticación con Google OAuth y suscripciones a través de PayPal para el sistema TechService Pro.

## 🚀 Características

### Autenticación Social
- **Google OAuth**: Los usuarios pueden registrarse e iniciar sesión usando su cuenta de Google
- **Período de prueba**: 7 días gratuitos para nuevos usuarios
- **Gestión de sesiones**: Control completo del estado de autenticación

### Sistema de Suscripciones
- **Planes flexibles**: Básico ($29/mes) y Profesional ($59/mes)
- **Procesamiento con PayPal**: Integración completa con PayPal REST API
- **Control de acceso**: Middleware para restringir funciones según suscripción
- **Gestión automática**: Renovaciones y cancelaciones

## 🏗️ Arquitectura del Sistema

### Modelos
- **User**: Extendido con campos OAuth y relaciones de suscripción
- **Subscription**: Gestión de planes, estados y fechas
- **Payment**: Registro de transacciones y estados de pago

### Controladores
- **SocialAuthController**: Manejo de OAuth con Google
- **SubscriptionController**: Gestión de planes y suscripciones
- **PayPalController**: Procesamiento de pagos y webhooks

### Middleware
- **CheckSubscription**: Verifica suscripciones activas y períodos de prueba

## 📁 Estructura de Archivos

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── SocialAuthController.php
│   │   ├── SubscriptionController.php
│   │   └── PayPalController.php
│   └── Middleware/
│       └── CheckSubscription.php
├── Models/
│   ├── User.php (extendido)
│   ├── Subscription.php
│   └── Payment.php
├── Config/
│   └── paypal.php
└── Database/
    └── Migrations/
        ├── add_oauth_fields_to_users_table.php
        ├── create_subscriptions_table.php
        └── create_payments_table.php

resources/views/
├── auth/
│   └── social-auth.blade.php
└── subscription/
    ├── plans.blade.php
    ├── checkout.blade.php
    ├── success.blade.php
    ├── no-subscription.blade.php
    └── paypal/
        └── approve.blade.php
```

## 🔧 Configuración

### Variables de Entorno (.env)

```bash
# Google OAuth Configuration
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8080/auth/google/callback

# PayPal SDK Configuration
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_MODE=sandbox
PAYPAL_WEBHOOK_ID=your_webhook_id
```

### Configuración de Google OAuth

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto o selecciona uno existente
3. Habilita la Google+ API
4. Crea credenciales OAuth 2.0
5. Configura las URLs de redirección autorizadas:
   - `http://localhost:8080/auth/google/callback`
   - `https://tu-dominio.com/auth/google/callback`

### Configuración de PayPal

1. Ve a [PayPal Developer](https://developer.paypal.com/)
2. Crea una aplicación en el modo sandbox
3. Obtén el Client ID y Client Secret
4. Configura los webhooks para eventos de pago

## 🛠️ Instalación

### 1. Instalar Dependencias

```bash
composer require laravel/socialite paypal/rest-api-sdk-php
```

### 2. Ejecutar Migraciones

```bash
php artisan migrate
```

### 3. Configurar Servicios OAuth

```bash
php artisan config:cache
```

## 🚦 Rutas del Sistema

### Autenticación Social
- `GET /auth/social` - Página de autenticación social
- `GET /auth/google` - Redirección a Google OAuth
- `GET /auth/google/callback` - Callback de Google OAuth

### Gestión de Suscripciones
- `GET /subscription/plans` - Mostrar planes disponibles
- `GET /subscription/checkout/{plan}` - Página de checkout
- `GET /subscription/show` - Detalles de suscripción actual
- `POST /subscription/cancel` - Cancelar suscripción

### Procesamiento de Pagos
- `POST /paypal/create-payment` - Crear pago en PayPal
- `GET /paypal/approve` - Procesar aprobación de pago
- `GET /paypal/execute` - Ejecutar pago aprobado
- `GET /paypal/success` - Página de éxito
- `GET /paypal/cancel` - Página de cancelación

## 🎨 Diseño UI/UX

Todas las vistas están diseñadas con **Tailwind CSS** siguiendo los principios de:

- **Responsivo**: Funciona en dispositivos móviles y desktop
- **Moderno**: Gradientes, animaciones y efectos visuales
- **Accesible**: Colores contrastantes y navegación clara
- **Intuitivo**: Flujo de usuario lógico y comprensible

### Características de Diseño
- Gradientes de colores atractivos
- Animaciones suaves y micro-interacciones
- Iconos SVG escalables
- Cards con efectos de vidrio y sombras
- Sistema de colores consistente
- Tipografía jerárquica clara

## 🔒 Seguridad y Control de Acceso

### Middleware de Suscripción
El middleware `CheckSubscription` verifica:
- Si el usuario está autenticado
- Si tiene una suscripción activa
- Si está en período de prueba (7 días)
- Redirecciona a la página de planes si es necesario

### Validaciones de Pago
- Verificación de estados de pago con PayPal
- Prevención de pagos duplicados
- Manejo seguro de webhooks
- Validación de montos y planes

## 📊 Estados del Sistema

### Estados de Suscripción
- `active`: Suscripción activa y vigente
- `inactive`: Suscripción cancelada o expirada
- `pending`: Pago en proceso
- `trial`: Período de prueba (primeros 7 días)

### Estados de Pago
- `pending`: Pago iniciado, esperando confirmación
- `completed`: Pago procesado exitosamente
- `failed`: Pago rechazado o fallido
- `cancelled`: Pago cancelado por el usuario

## 🚀 Flujo de Usuario

### 1. Registro Inicial
1. Usuario hace clic en "Crear cuenta de servicio técnico"
2. Redirección a Google OAuth
3. Autorización en Google
4. Creación/vinculación de cuenta
5. Inicio de período de prueba de 7 días

### 2. Selección de Plan
1. Después de 7 días, se muestra página de planes
2. Usuario selecciona plan (Básico o Profesional)
3. Redirección a checkout con datos precargados

### 3. Proceso de Pago
1. Formulario de checkout con integración PayPal
2. Redirección a PayPal para autorización
3. Confirmación y procesamiento de pago
4. Activación automática de suscripción
5. Página de éxito con próximos pasos

## 🔄 Integración con Sistema Principal

### Página Principal (welcome-new.blade.php)
Se agregó el botón principal:
```html
<a href="{{ route('auth.social') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600...">
    Crear cuenta de servicio técnico
</a>
```

### Protección de Rutas
Las rutas del dashboard requieren middleware `subscription`:
```php
Route::middleware(['auth', 'subscription'])->get('/dashboard', [DashboardController::class, 'index']);
```

## 🧪 Testing y Desarrollo

### Modo Sandbox PayPal
El sistema está configurado para usar el sandbox de PayPal, permitiendo:
- Pagos de prueba sin dinero real
- Testing de flujos completos
- Depuración de webhooks

### Cuentas de Prueba Google OAuth
Para desarrollo local, configura URLs de callback apropiadas en Google Cloud Console.

## 📈 Métricas y Analytics

El sistema registra:
- Conversiones de prueba a pago
- Tasas de cancelación
- Métodos de pago preferidos
- Patrones de uso por plan

## 🔧 Mantenimiento

### Tareas Periódicas
- Verificar suscripciones expiradas
- Procesar renovaciones automáticas
- Limpiar datos de pagos fallidos
- Actualizar tokens OAuth

### Monitoreo
- Estados de webhooks PayPal
- Logs de autenticación OAuth
- Métricas de conversión
- Errores de integración

## 📞 Soporte

Para configuración avanzada o problemas:
- Documentación Laravel Socialite: https://laravel.com/docs/socialite
- PayPal REST API: https://developer.paypal.com/docs/api/
- Tailwind CSS: https://tailwindcss.com/docs

---

**Creado para TechService Pro** - Sistema de gestión integral para talleres de servicio técnico.