# 🚀 Scripts de Gestión - Proyecto Capstone

Este directorio contiene varios scripts para facilitar la gestión del proyecto Capstone Laravel.

## 📋 Scripts Disponibles

### 🔧 Configuración Inicial
- **`init-existing.bat`** - Inicialización completa del proyecto (primera vez)
  - Instala todas las dependencias
  - Configura base de datos
  - Instala SDKs de terceros
  - Configura Tailwind CSS

### ⚡ Gestión Rápida de Servicios
- **`iniciar-servicios.bat`** - Inicia todos los contenedores Docker
- **`detener-servicios.bat`** - Detiene todos los contenedores Docker
- **`verificar-estado.bat`** - Verifica el estado de todos los servicios

### 🎨 Desarrollo Frontend
- **`dev-frontend.bat`** - Inicia el servidor de desarrollo Vite

## 🌐 URLs y Puertos

| Servicio | URL | Puerto | Descripción |
|----------|-----|--------|-------------|
| Laravel App | http://localhost:8080 | 8080 | Aplicación principal |
| Vite Dev Server | http://localhost:5173 | 5173 | Desarrollo frontend |
| phpMyAdmin | http://localhost:8081 | 8081 | Admin base de datos |
| MySQL | localhost:3307 | 3307 | Base de datos |
| Redis | localhost:6379 | 6379 | Cache y sesiones |

## 📝 Credenciales de Base de Datos

- **Base de datos**: `capstone_laravel`
- **Usuario**: `capstone_user`
- **Password**: `capstone_password_2025`
- **Host externo**: `localhost:3307`

## 🚀 Flujo de Trabajo Recomendado

### Primera vez (configuración inicial):
```bash
# 1. Ejecutar inicialización completa
init-existing.bat
```

### Uso diario:
```bash
# 1. Iniciar servicios
iniciar-servicios.bat

# 2. Iniciar desarrollo frontend (en otra terminal)
dev-frontend.bat

# 3. Al terminar, detener servicios
detener-servicios.bat
```

### Verificación de problemas:
```bash
# Verificar estado de servicios
verificar-estado.bat
```

## 🛠️ Comandos Docker Útiles

```bash
# Ver logs de todos los servicios
docker-compose -f docker-compose.existing.yml logs -f

# Ver logs de un servicio específico
docker-compose -f docker-compose.existing.yml logs -f app

# Reiniciar un servicio específico
docker-compose -f docker-compose.existing.yml restart app

# Ejecutar comandos en contenedores
docker-compose -f docker-compose.existing.yml exec app php artisan migrate
docker-compose -f docker-compose.existing.yml exec node npm install
```

## 🔍 Solución de Problemas

### Si los servicios no inician:
1. Verificar que Docker Desktop esté ejecutándose
2. Ejecutar `verificar-estado.bat`
3. Revisar logs: `docker-compose -f docker-compose.existing.yml logs`

### Si hay conflictos de puertos:
1. Verificar puertos en uso con `verificar-estado.bat`
2. Detener servicios conflictivos
3. Reiniciar con `iniciar-servicios.bat`

### Si Vite no funciona:
1. Verificar que los servicios estén corriendo
2. Ejecutar `dev-frontend.bat`
3. Acceder a http://localhost:5173

## 📦 Tecnologías Incluidas

- **Laravel** - Framework PHP
- **Vite** - Build tool para frontend
- **Tailwind CSS** - Framework CSS
- **MySQL** - Base de datos
- **Redis** - Cache y sesiones
- **Nginx** - Servidor web
- **Node.js** - Runtime para herramientas frontend
- **PayPal SDK** - Integración de pagos
- **Bunny SDK** - CDN y storage