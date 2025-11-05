# Sistema de Gestión de Órdenes de Servicio Técnico - Capstone

Proyecto Laravel 11 completo con sistema de gestión de órdenes de servicio técnico, incluyendo autenticación, suscripciones, pagos con PayPal, gestión de técnicos y clientes, dashboard administrativo y sistema de notificaciones.

## 📋 Requisitos

- **PHP 8.2 o superior**
- **Composer**
- **Node.js 18 o superior**
- **MySQL 8.0 o superior**
- **NPM**

> **Nota:** Este proyecto ya no utiliza Docker. Para la guía completa de instalación sin Docker, consulta [INSTALACION-SIN-DOCKER.md](INSTALACION-SIN-DOCKER.md)

## 🏗️ Servicios y Tecnologías Incluidas

- **Laravel 11** (PHP 8.2 + Composer)
- **MySQL 8.0** (Base de datos local)
- **Tailwind CSS v3.4.17** (Framework CSS con configuración personalizada)
- **Vite** (Build tool y dev server)
- **PayPal SDK v8.4.2** (Integración completa de pagos)
- **Bunny.net SDK v0.0.31** (CDN y servicios multimedia)
- **Font Awesome** (Iconografía)
- **Chart.js** (Gráficos y visualización de datos)

## 🚀 Funcionalidades Principales

- **Sistema de Autenticación:** Login/registro con validaciones completas
- **Gestión de Suscripciones:** Sistema completo de planes y pagos con PayPal
- **Procesamiento de Pagos:** Integración completa con PayPal SDK v8.4.2
- **Dashboard Administrativo:** Panel de control con métricas, estadísticas y gráficos
- **Gestión de Técnicos:** CRUD completo con datos reales, filtros avanzados y estadísticas
- **Gestión de Clientes:** CRUD completo con historial y relación cliente-órdenes
- **Gestión de Equipos y Marcas:** Sistema completo de catálogo con seguimiento
- **Órdenes de Servicio:** Creación, seguimiento y gestión completa del flujo
- **Sistema de Roles:** Diferenciación completa entre admin, técnico y trabajador
- **Notificaciones:** Sistema de alertas y comunicación en tiempo real
- **Reportes:** Generación de informes y estadísticas avanzadas

## 🚀 Inicio Rápido

### Instalación Automática (Recomendado)

```powershell
# Ejecuta el script de instalación:
.\instalar-proyecto.bat
```

**Esto configurará automáticamente:**
- Dependencias de Composer y NPM
- Archivo .env con configuración local
- Key de la aplicación
- Opción para ejecutar migraciones
### Instalación Manual

Para instrucciones detalladas de instalación manual, consulta [INSTALACION-SIN-DOCKER.md](INSTALACION-SIN-DOCKER.md)

```bash
# 1. Instalar dependencias
composer install
npm install

# 2. Configurar entorno
copy .env.example .env
php artisan key:generate

# 3. Configurar base de datos en .env
# DB_HOST=localhost
# DB_PORT=3306
# DB_DATABASE=capstone
# DB_USERNAME=root
# DB_PASSWORD=tu_contraseña

# 4. Ejecutar migraciones
php artisan migrate

# 5. Ejecutar seeders (opcional)
php artisan db:seed
```

## 🌐 URLs Disponibles

- **Aplicación Laravel:** http://localhost:8080
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
- **Vite** como build tool y dev server

Para trabajar con Tailwind CSS en modo desarrollo:

```powershell
# Iniciar servidor de desarrollo con hot reload
npm run dev
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

### Iniciar/Detener Servicios

```powershell
# Iniciar servicios (Laravel + Vite)
.\iniciar-servicios.bat

# Detener servicios
.\detener-servicios.bat

# Verificar estado de servicios
.\verificar-estado.bat
```

### Comandos Básicos de Laravel

```powershell
# Iniciar servidor de desarrollo
php artisan serve --host=localhost --port=8080
```powershell
# Iniciar servidor de desarrollo
php artisan serve --host=localhost --port=8080

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Crear controlador
php artisan make:controller NombreController

# Crear modelo con migración
php artisan make:model NombreModelo -m

# Ver rutas
php artisan route:list
```

### Comandos de Base de Datos

```powershell
# Ejecutar migraciones
php artisan migrate

# Rollback de migraciones
php artisan migrate:rollback

# Ejecutar seeders
php artisan db:seed

# Seeder específico
php artisan db:seed --class=TecnicoSeeder

# Limpiar y recrear base de datos
php artisan migrate:fresh --seed
```

### Comandos de Frontend

```powershell
# Iniciar dev server con hot reload
npm run dev

# Compilar assets para producción
npm run build

# Instalar nuevas dependencias
npm install [paquete]
```

## 🏗️ Estructura del Proyecto

```
Proyecto/
├── instalar-proyecto.bat          # Script de instalación
├── iniciar-servicios.bat          # Script para iniciar servicios
├── detener-servicios.bat          # Script para detener servicios
├── verificar-estado.bat           # Script para verificar estado
├── tailwind.config.js             # Configuración Tailwind CSS con paletas duales
├── postcss.config.js              # Configuración PostCSS
├── package.json                   # Dependencias Node.js (incluye SDKs)
├── vite.config.js                 # Configuración Vite
├── .env.example                   # Variables de entorno
├── resources/
│   ├── css/app.css                # CSS principal con Tailwind
│   ├── js/app.js                  # JavaScript principal
│   └── views/                     # Templates Blade organizados por módulos
│       ├── administrador/         # Vistas administrativas
│       ├── auth/                  # Autenticación y registro
│       ├── clientes/              # Gestión de clientes
│       ├── dashboard/             # Dashboards generales
│       ├── layouts/               # Layouts base
│       ├── ordenes/               # Órdenes de servicio
│       ├── paypal/                # Integración PayPal
│       ├── setup/                 # Configuración inicial
│       ├── subscription/          # Sistema de suscripciones
│       ├── tecnico/               # Panel técnico
│       └── tecnicos/              # Gestión de técnicos
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Controladores del sistema
│   │   └── Middleware/            # Middleware personalizado
│   └── Models/                    # Modelos Eloquent
├── database/
│   ├── migrations/                # Migraciones de base de datos
│   └── seeders/                   # Seeders de datos
└── public/
    ├── css/                       # CSS compilado
    └── js/                        # JavaScript compilado
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
  - Panel administrativo completo con estadísticas (clientes activos, inactivos, con órdenes)
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