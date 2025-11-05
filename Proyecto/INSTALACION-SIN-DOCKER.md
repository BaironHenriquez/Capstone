# 🚀 Guía de Instalación - Proyecto Capstone (Sin Docker)

Este proyecto Laravel ahora se ejecuta en un entorno local sin Docker. Sigue estos pasos para configurar y ejecutar el proyecto en tu máquina.

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu sistema:

1. **PHP 8.2 o superior**
   - Descarga: https://www.php.net/downloads
   - Verifica: `php --version`

2. **Composer**
   - Descarga: https://getcomposer.org/
   - Verifica: `composer --version`

3. **Node.js y NPM** (v18 o superior)
   - Descarga: https://nodejs.org/
   - Verifica: `node --version` y `npm --version`

4. **MySQL** (v8.0 o superior)
   - XAMPP: https://www.apachefriends.org/
   - MySQL: https://dev.mysql.com/downloads/installer/
   - Verifica que MySQL esté corriendo en el puerto 3306 o 3307

5. **Git**
   - Descarga: https://git-scm.com/
   - Verifica: `git --version`

## 🔧 Instalación Rápida

### Opción 1: Usando el Script de Instalación (Recomendado)

1. Abre una terminal en el directorio del proyecto
2. Ejecuta el script de instalación:
   ```bash
   instalar-proyecto.bat
   ```
3. Sigue las instrucciones en pantalla

### Opción 2: Instalación Manual

1. **Clonar el repositorio** (si aún no lo has hecho):
   ```bash
   git clone https://github.com/BaironHenriquez/Capstone.git
   cd Capstone/Proyecto
   ```

2. **Instalar dependencias de PHP**:
   ```bash
   composer install
   ```

3. **Instalar dependencias de JavaScript**:
   ```bash
   npm install
   ```

4. **Configurar variables de entorno**:
   ```bash
   copy .env.example .env
   ```

5. **Generar la clave de la aplicación**:
   ```bash
   php artisan key:generate
   ```

6. **Configurar la base de datos**:
   - Abre el archivo `.env`
   - Actualiza las siguientes líneas con tus credenciales:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=capstone
   DB_USERNAME=root
   DB_PASSWORD=tu_contraseña_aquí
   ```

7. **Crear la base de datos** (si no existe):
   ```sql
   CREATE DATABASE capstone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

8. **Ejecutar migraciones**:
   ```bash
   php artisan migrate
   ```

9. **Ejecutar seeders** (opcional, para datos de prueba):
   ```bash
   php artisan db:seed
   ```

## 🚀 Iniciar el Proyecto

### Opción 1: Usando Scripts (Recomendado)

**Iniciar servicios:**
```bash
iniciar-servicios.bat
```
Esto abrirá dos ventanas:
- Servidor Laravel: http://localhost:8080
- Vite Dev Server: http://localhost:5173

**Detener servicios:**
```bash
detener-servicios.bat
```

**Verificar estado:**
```bash
verificar-estado.bat
```

### Opción 2: Manual

Necesitarás abrir **dos terminales**:

**Terminal 1 - Servidor Laravel:**
```bash
php artisan serve --host=localhost --port=8080
```

**Terminal 2 - Vite Dev Server:**
```bash
npm run dev
```

Luego accede a: http://localhost:8080

## 🗄️ Gestión de Base de Datos

### Ejecutar Migraciones
```bash
php artisan migrate
```

### Revertir Migraciones
```bash
php artisan migrate:rollback
```

### Refrescar Base de Datos (⚠️ Cuidado: Borra todos los datos)
```bash
php artisan migrate:fresh
```

### Ejecutar Seeders
```bash
# Todos los seeders
php artisan db:seed

# Seeder específico
php artisan db:seed --class=TecnicoSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=ClienteSeeder
```

## 🔨 Comandos Útiles

### Limpiar Caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimizar para Producción
```bash
php artisan optimize
composer install --optimize-autoloader --no-dev
npm run build
```

### Ver Rutas
```bash
php artisan route:list
```

### Crear Controlador
```bash
php artisan make:controller NombreController
```

### Crear Modelo
```bash
php artisan make:model NombreModelo -m
```

### Crear Migración
```bash
php artisan make:migration nombre_de_la_migracion
```

## 🐛 Solución de Problemas

### Error: "SQLSTATE[HY000] [1045] Access denied"
**Solución:** Verifica las credenciales de MySQL en el archivo `.env`

### Error: "Vite manifest not found"
**Solución:** Ejecuta `npm run build` o asegúrate de que `npm run dev` esté corriendo

### Error: "Class 'ZipArchive' not found"
**Solución:** Habilita la extensión `php_zip` en tu `php.ini`

### El puerto 8080 está ocupado
**Solución:** Usa otro puerto:
```bash
php artisan serve --port=8000
```
Y actualiza `APP_URL=http://localhost:8000` en `.env`

### MySQL no inicia
**Solución:** 
- Verifica que no haya otro proceso usando el puerto 3306
- Inicia MySQL desde XAMPP Control Panel o el administrador de servicios de Windows

## 📁 Estructura del Proyecto

```
Proyecto/
├── app/                    # Lógica de la aplicación
│   ├── Http/
│   │   ├── Controllers/   # Controladores
│   │   └── Middleware/    # Middleware
│   └── Models/            # Modelos Eloquent
├── config/                # Archivos de configuración
├── database/
│   ├── migrations/        # Migraciones de BD
│   └── seeders/          # Seeders
├── public/               # Archivos públicos
│   ├── css/
│   └── js/
├── resources/
│   ├── views/            # Plantillas Blade
│   ├── css/
│   └── js/
├── routes/               # Definición de rutas
│   └── web.php
├── .env                  # Variables de entorno (no versionado)
├── .env.example          # Plantilla de variables
└── composer.json         # Dependencias PHP
```

## 🔐 Credenciales por Defecto

### Usuarios de Prueba (después de ejecutar seeders)

**Administrador:**
- Email: admin@techservice.cl
- Password: password

**Técnicos:**
- Email: carlos.rodriguez@techservice.cl / Password: password123
- Email: maria.garcia@techservice.cl / Password: password123
- Email: ana.herrera@techservice.cl / Password: password123

## 📝 Notas Importantes

1. **Entorno de Desarrollo:** Este proyecto está configurado para desarrollo local sin Docker
2. **Base de Datos:** Asegúrate de que MySQL esté corriendo antes de iniciar el proyecto
3. **Puerto:** El servidor Laravel usa el puerto 8080 por defecto
4. **Vite:** El dev server de Vite usa el puerto 5173
5. **Hot Reload:** Los cambios en archivos frontend se reflejan automáticamente con Vite

## 🤝 Contribuir

1. Crea un branch para tu feature: `git checkout -b feature/nueva-funcionalidad`
2. Haz commit de tus cambios: `git commit -m 'Agregar nueva funcionalidad'`
3. Push al branch: `git push origin feature/nueva-funcionalidad`
4. Abre un Pull Request

## 📧 Soporte

Si encuentras problemas, contacta al equipo de desarrollo o abre un issue en el repositorio.

---
**Última actualización:** Noviembre 2025
