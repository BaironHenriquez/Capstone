# Sistema de Gestión de Órdenes de Servicio Técnico - Capstone

Proyecto Laravel 11 completo con sistema de gestión de órdenes de servicio técnico, incluyendo autenticación, suscripciones, pagos con PayPal, gestión de técnicos y clientes, dashboard administrativo y sistema de notificaciones.

## 📋 Requisitos

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## 🏗️ Servicios y Tecnologías Incluidas

- **Laravel 11** (PHP 8.2 + Composer)
- **MySQL 8.0** (Base de datos con configuración específica del proyecto)
- **Redis** (Cache y sesiones)
- **Nginx** (Servidor web)
- **Node.js 18** (Frontend/NPM)
- **phpMyAdmin** (Administración de BD)
- **Tailwind CSS v3.4.17** (Framework CSS con configuración personalizada)
- **PayPal SDK v8.4.2** (Integración completa de pagos)
- **Bunny.net SDK v0.0.31** (CDN y servicios multimedia)
- **Font Awesome** (Iconografía)
- **Chart.js** (Gráficos y visualización de datos)

## 🚀 Funcionalidades Principales

- **Sistema de Autenticación:** Login/registro con validaciones completas
- **Gestión de Suscripciones:** Sistema completo de planes y pagos con PayPal
- **Procesamiento de Pagos:** Integración completa con PayPal SDK v8.4.2
- **Dashboard Administrativo:** Panel de control con métricas, estadísticas y gráficos
- **Gestión de Técnicos:** CRUD completo para técnicos de servicio con panel administrativo (crear, editar, listar, suspender/activar, eliminar), gestión de especialidades, asignaciones automáticas y estadísticas
- **Gestión de Clientes:** CRUD completo para clientes con panel administrativo (crear, editar, listar, activar/desactivar, eliminar), relación cliente-órdenes, historial completo, filtrado avanzado y estadísticas detalladas
- **Gestión de Equipos y Marcas:** Sistema completo de catálogo de equipos y marcas con asociaciones cliente-equipo, seguimiento de garantías, mantenimiento programado, especificaciones técnicas y estadísticas de servicio
- **Órdenes de Servicio:** Creación, seguimiento y gestión completa del flujo
- **Sistema de Roles:** Diferenciación completa entre admin, técnico y cliente
- **Notificaciones:** Sistema de alertas y comunicación en tiempo real
- **Reportes:** Generación de informes y estadísticas avanzadas

## 🚀 Inicio Rápido para Colaboradores

### Si CLONASTE este repositorio desde GitHub:

```powershell
# Solo necesitas ejecutar este comando:
.\init-existing.bat
```

**Esto configurará automáticamente:**
- Docker y todos los contenedores
- MySQL con base de datos `capstone_laravel`
- Laravel 11 con todas las dependencias
- Tailwind CSS v3.4.17 completamente configurado
- PayPal SDK v8.4.2 y Bunny.net SDK v0.0.31
- Migraciones de base de datos ejecutadas
- Seeder de datos de prueba
- Optimización de cache y configuración

### Configuración de Base de Datos Incluida

**Base de Datos:**
- Base de datos: `capstone_laravel`
- Usuario: `capstone_user`
- Contraseña: `capstone_password_2025`
- Base de datos de testing: `capstone_laravel_testing`

**SDKs de Terceros:**
- PayPal SDK v8.4.2 (@paypal/sdk-js) para procesamiento completo de pagos
- Bunny.net SDK v0.0.31 (bunnynet) para CDN y servicios multimedia

## 🌐 URLs Disponibles

- **Aplicación Laravel:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081
  - Usuario: `capstone_user`
  - Contraseña: `capstone_password_2025`
  - Host de BD: `db` (puerto interno 3306, externo 3307)
- **Vite Dev Server:** http://localhost:5173

## 🎨 Desarrollo Frontend con Tailwind CSS

### Configuración Personalizada Incluida:

- **Tailwind CSS v3.4.17** con configuración optimizada
- **@tailwindcss/forms** para mejor estilizado de formularios
- **Paletas de colores duales:**
  - Paleta Capstone: `capstone-50` a `capstone-900` (azules corporativos)
  - Paleta Tech: `tech-50` a `tech-900` (grises tecnológicos)
- **Fuente personalizada:** Inter configurada
- **Autoprefixer** para compatibilidad con navegadores

Para trabajar con Tailwind CSS en modo desarrollo:

```powershell
# Iniciar servidor de desarrollo con hot reload
docker-compose -f docker-compose.existing.yml exec node npm run dev
```

### SDKs Integrados

#### PayPal SDK v8.4.2

```javascript
// Ejemplo de uso del SDK de PayPal
import { loadScript } from '@paypal/sdk-js';

loadScript({
    'client-id': 'your-paypal-client-id'
}).then((paypal) => {
    // Usar PayPal SDK
});
```

#### Bunny.net SDK v0.0.31

```javascript
// Ejemplo de uso del SDK de Bunny.net
import BunnySDK from 'bunnynet';

const bunny = new BunnySDK({
    apiKey: 'your-bunny-api-key'
});
```

### Ejemplo de uso en templates Blade:

```html
<div class="bg-capstone-500 text-white p-6 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-4">Sistema de Gestión de Órdenes</h1>
    <p class="text-capstone-50">Desarrollado con Laravel 11, Tailwind CSS, PayPal y Bunny.net</p>
</div>
```

## 🔧 Comandos Útiles para Desarrollo

### Comandos Básicos de Docker

```powershell
# Iniciar servicios
docker-compose -f docker-compose.existing.yml up -d

# Detener servicios
docker-compose -f docker-compose.existing.yml down

# Ver logs
docker-compose -f docker-compose.existing.yml logs -f

# Reiniciar servicios
docker-compose -f docker-compose.existing.yml restart
```

### Comandos de Laravel

```powershell
# Ejecutar comandos Artisan
docker-compose -f docker-compose.existing.yml exec app php artisan [comando]

# Ejemplos comunes:
docker-compose -f docker-compose.existing.yml exec app php artisan migrate
docker-compose -f docker-compose.existing.yml exec app php artisan make:controller HomeController
docker-compose -f docker-compose.existing.yml exec app php artisan cache:clear

# Acceder al contenedor
docker-compose -f docker-compose.existing.yml exec app bash
```

### Comandos de Frontend

```powershell
# Instalar nuevas dependencias de NPM
docker-compose -f docker-compose.existing.yml exec node npm install [paquete]

# Compilar assets para producción
docker-compose -f docker-compose.existing.yml exec node npm run build

# Modo desarrollo con hot reload
docker-compose -f docker-compose.existing.yml exec node npm run dev

# Instalar SDKs adicionales
docker-compose -f docker-compose.existing.yml exec node npm install [nombre-del-sdk]
```

### Comandos de Base de Datos

```powershell
# Ejecutar migraciones
docker-compose -f docker-compose.existing.yml exec app php artisan migrate

# Rollback de migraciones
docker-compose -f docker-compose.existing.yml exec app php artisan migrate:rollback

# Ejecutar seeders
docker-compose -f docker-compose.existing.yml exec app php artisan db:seed

# Limpiar y recrear base de datos
docker-compose -f docker-compose.existing.yml exec app php artisan migrate:fresh --seed
```

## 🏗️ Estructura del Proyecto

```
Proyecto/
├── docker-compose.existing.yml     # Configuración Docker principal
├── Dockerfile.existing             # Imagen Docker optimizada
├── init-existing.bat               # Script de inicialización único
├── tailwind.config.js              # Configuración Tailwind CSS con paletas duales
├── postcss.config.js               # Configuración PostCSS
├── package.json                    # Dependencias Node.js (incluye SDKs actualizados)
├── vite.config.js                  # Configuración Vite
├── .env.example                    # Variables de entorno
├── resources/
│   ├── css/app.css                 # CSS principal con Tailwind
│   ├── js/app.js                   # JavaScript principal
│   └── views/                      # Templates Blade organizados por módulos
│       ├── administrador/          # Vistas administrativas
│       ├── auth/                   # Autenticación y registro
│       ├── clientes/               # Gestión de clientes
│       ├── dashboard/              # Dashboards generales
│       ├── layouts/                # Layouts base
│       ├── ordenes/                # Órdenes de servicio
│       ├── paypal/                 # Integración PayPal
│       ├── setup/                  # Configuración inicial
      ├── subscription/           # Sistema de suscripciones
      ├── tecnico/                # Panel técnico
      ├── tecnicos/               # Gestión de técnicos
      └── equipos-marcas/         # Gestión de equipos y marcas
└── docker-compose/
    ├── nginx/app.conf              # Configuración Nginx
    └── mysql/
        ├── my.cnf                  # Configuración MySQL
        └── init.sql                # Script inicialización BD
```

## 📊 Módulos del Sistema

### Dashboard Administrativo
- **Ubicación:** `resources/views/administrador/`
- **Funcionalidades:** Métricas, estadísticas, gráficos con Chart.js
- **Acceso:** http://localhost:8080/dashboard-admin

### Gestión de Técnicos
- **Ubicación:** `resources/views/tecnicos/`
- **Controller:** `app/Http/Controllers/GestionTecnicosController.php`
- **Funcionalidades:** 
  - Panel administrativo completo con estadísticas (técnicos activos, suspendidos, especialidades)
  - Crear nuevos técnicos con información personal, contacto y especialidades
  - Editar información existente de técnicos
  - Suspender/activar técnicos (toggle de estado)
  - Eliminar técnicos del sistema
  - Búsqueda por nombre, especialidad y estado
  - Filtrado avanzado por múltiples criterios
  - Paginación y ordenamiento
  - Validación completa de formularios
  - Interfaz responsive con Tailwind CSS
- **Rutas:** `/admin/gestion-tecnicos/*` (requiere autenticación de administrador)
- **Acceso:** http://localhost:8080/admin/gestion-tecnicos
- **Credenciales de prueba:** admin@baieco.cl / admin123

### Gestión de Clientes
- **Ubicación:** `resources/views/clientes/`
- **Controller:** `app/Http/Controllers/GestionClientesController.php`
- **Funcionalidades:**
  - Panel administrativo completo con estadísticas (clientes activos, VIP, con órdenes)
  - Crear nuevos clientes con información personal, empresa y configuración
  - Editar información completa de clientes existentes
  - Ver detalles completos del cliente con historial de órdenes
  - Activar/desactivar clientes (toggle de estado)
  - Eliminar clientes del sistema (con validación de órdenes activas)
  - Búsqueda por nombre, email, RUT, empresa
  - Filtrado por estado, tipo de cliente y servicio técnico
  - Relación completa cliente → órdenes de servicio
  - Estadísticas por cliente (órdenes totales, completadas, pendientes, valor gastado)
  - Paginación, ordenamiento y filtros avanzados
  - Validación completa con formateo automático de RUT
  - Interfaz responsive con cards informativas
  - Panel lateral con información y acciones rápidas
- **Rutas:** `/admin/gestion-clientes/*` (requiere autenticación de administrador)
- **Acceso:** http://localhost:8080/admin/gestion-clientes
- **Credenciales de prueba:** admin@baieco.cl / admin123

### Gestión de Equipos y Marcas
- **Ubicación:** `resources/views/equipos-marcas/`
- **Controller:** `app/Http/Controllers/GestionEquiposMarcasController.php`
- **Funcionalidades:**
  - Dashboard principal con estadísticas completas (equipos, marcas, asociaciones, garantías)
  - **Gestión de Marcas:** CRUD completo con carga de logos, popularidad y estado
  - **Gestión de Equipos:** CRUD completo con imágenes, especificaciones técnicas, precios y garantías
  - **Asociaciones Cliente-Equipo:** Vincular equipos con clientes incluyendo número de serie y fechas
  - Seguimiento automático de garantías (activa, por vencer, vencida)
  - Control de mantenimiento programado y alertas
  - Búsqueda avanzada por marca, modelo, especificaciones y cliente
  - Filtrado por estado, precio, garantía y mantenimiento
  - Estadísticas detalladas de servicios por equipo y popularidad de marcas
  - Historial completo de servicios por equipo-cliente
  - Cálculo automático de costos totales de servicio
  - Validación completa de formularios con carga de archivos
  - Interfaz responsive con tarjetas informativas y estados visuales
  - Sistema de badges para estados (activo, mantenimiento, garantía)
- **Modelos:** `Marca`, `Equipo`, `ClienteEquipo` con relaciones completas
- **Rutas:** `/admin/gestion-equipos-marcas/*`, `/admin/marcas/*`, `/admin/equipos/*`, `/admin/cliente-equipos/*`
- **Acceso:** http://localhost:8080/admin/gestion-equipos-marcas
- **Credenciales de prueba:** admin@baieco.cl / admin123

### Sistema de Autenticación
- **Ubicación:** `resources/views/auth/`
- **Funcionalidades:** Login, registro, recuperación de contraseña
- **Middleware:** Autenticación y autorización por roles

### Gestión de Suscripciones
- **Ubicación:** `resources/views/subscription/`
- **Funcionalidades:** Planes, pagos con PayPal, renovaciones
- **SDK:** PayPal v8.4.2 integrado

### Órdenes de Servicio
- **Ubicación:** `resources/views/ordenes/`
- **Funcionalidades:** Creación, seguimiento, asignación a técnicos
- **Estados:** Pendiente, En proceso, Completada, Cancelada

## 🔧 Scripts Adicionales Disponibles

```powershell
# Verificar puertos ocupados
.\check-ports.bat

# Desarrollo frontend rápido
.\dev-frontend.bat

# Inicialización inteligente (detecta automáticamente el tipo de proyecto)
.\init-smart.bat

# Scripts de optimización (si están disponibles)
.\optimizar-rendimiento.bat
```

## 🗃️ Configuración de Base de Datos

Las credenciales de la base de datos están en el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=capstone_laravel
DB_USERNAME=capstone_user
DB_PASSWORD=capstone_password_2025
```

**Conexión externa (para herramientas como MySQL Workbench):**
- Host: `localhost`
- Puerto: `3307`
- Base de datos: `capstone_laravel`
- Usuario: `capstone_user`
- Contraseña: `capstone_password_2025`

## 🛠️ Variables de Entorno para SDKs

Agregar al archivo `.env` las configuraciones de los SDKs:

```env
# PayPal Configuration
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_MODE=sandbox # o 'live' para producción

# Bunny.net Configuration
BUNNY_API_KEY=your_bunny_api_key
BUNNY_STORAGE_ZONE=your_storage_zone
BUNNY_CDN_HOSTNAME=your_cdn_hostname
```

## 🔄 Mantener el Proyecto Actualizado

```powershell
# Actualizar dependencias PHP
docker-compose -f docker-compose.existing.yml exec app composer update

# Actualizar dependencias Node.js (incluye SDKs)
docker-compose -f docker-compose.existing.yml exec node npm update

# Reconstruir contenedores si hay cambios en Docker
docker-compose -f docker-compose.existing.yml up -d --build
```

## 🐛 Solución de Problemas Comunes

### Error de permisos en Windows

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

### Puertos ocupados

```powershell
# Verificar puertos en uso
netstat -an | findstr ":8080\|:8081\|:3307"

# Si están ocupados, cambiar en docker-compose.existing.yml
```

### Contenedores no inician correctamente

```powershell
# Ver logs detallados
docker-compose -f docker-compose.existing.yml logs -f

# Reiniciar desde cero
docker-compose -f docker-compose.existing.yml down -v
.\init-existing.bat
```

### Problemas con Tailwind CSS

```powershell
# Recompilar assets
docker-compose -f docker-compose.existing.yml exec node npm run build

# Limpiar cache de Vite
docker-compose -f docker-compose.existing.yml exec node rm -rf node_modules/.vite

# Reinstalar dependencias
docker-compose -f docker-compose.existing.yml exec node npm install
```

## 👥 Instrucciones para Nuevos Colaboradores

1. **Clonar el repositorio:**
   ```powershell
   git clone [url-repositorio-capstone]
   cd [directorio-proyecto]
   ```

2. **Verificar Docker:**
   ```powershell
   docker --version
   docker-compose --version
   ```

3. **Ejecutar script de inicialización:**
   ```powershell
   .\init-existing.bat
   ```

4. **Verificar instalación:**
   - Abrir http://localhost:8080 (debe mostrar Laravel)
   - Abrir http://localhost:8081 (debe mostrar phpMyAdmin)

5. **Comenzar desarrollo:**
   ```powershell
   # Para frontend con Tailwind CSS
   docker-compose -f docker-compose.existing.yml exec node npm run dev
   ```

## 📚 Documentación Adicional

**Recursos útiles:**
- [Laravel 11](https://laravel.com/docs/11.x)
- [Tailwind CSS v3.4](https://tailwindcss.com/docs)
- [PayPal SDK](https://developer.paypal.com/sdk/js/)
- [Bunny.net](https://docs.bunny.net/)
- [Docker](https://docs.docker.com/)
- [Chart.js](https://www.chartjs.org/)

## 🆘 Soporte

Para problemas específicos del proyecto Capstone:

1. **Verificar logs:** `docker-compose -f docker-compose.existing.yml logs -f`
2. **Reiniciar servicios:** `docker-compose -f docker-compose.existing.yml restart`
3. **Limpiar y reiniciar:** `docker-compose -f docker-compose.existing.yml down -v && .\init-existing.bat`

---

> **Nota:** Este proyecto utiliza tecnologías actualizadas. Las versiones de los SDKs y dependencias mencionadas en este README reflejan el estado actual del proyecto, no versiones futuras o desactualizadas.