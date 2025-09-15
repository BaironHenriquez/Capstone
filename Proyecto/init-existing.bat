@echo off
REM Script principal para repositorios clonados del proyecto Capstone Laravel
REM Este es el UNICO script que necesitas ejecutar despues de clonar

echo ========================================
echo   INICIALIZACION PROYECTO CAPSTONE
echo ========================================
echo.

REM Verificar que Laravel existe
if not exist "artisan" (
    echo ERROR: No se encontro Laravel en este directorio
    echo Este script es para repositorios que YA TIENEN Laravel
    echo Verifica que estas en el directorio correcto
    pause
    exit /b 1
)

echo [OK] Laravel detectado en el repositorio

REM Verificar que Docker esta funcionando
docker --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker no esta instalado o no esta funcionando
    echo Por favor instala Docker Desktop y asegurate de que este ejecutandose
    pause
    exit /b 1
)

echo [OK] Docker detectado y funcionando

REM Copiar archivo de entorno
if not exist .env (
    copy .env.example .env
    echo [OK] Archivo .env creado desde .env.example
) else (
    echo [OK] Archivo .env ya existe
)

REM Parar contenedores previos si existen
echo.
echo Deteniendo contenedores existentes (si los hay)...
docker-compose -f docker-compose.existing.yml down >nul 2>&1

REM Construir e iniciar contenedores
echo.
echo ========================================
echo   CONSTRUYENDO ENTORNO DOCKER
echo ========================================
docker-compose -f docker-compose.existing.yml up -d --build

REM Esperar a que los servicios estén listos
echo.
echo Esperando a que los servicios esten listos...
echo (Esto puede tomar 1-2 minutos la primera vez)
timeout /t 45 /nobreak

REM Verificar que el contenedor app este funcionando
docker-compose -f docker-compose.existing.yml ps app | findstr "Up" >nul
if errorlevel 1 (
    echo ERROR: El contenedor de Laravel no esta funcionando correctamente
    echo Revisando logs...
    docker-compose -f docker-compose.existing.yml logs app
    pause
    exit /b 1
)

echo [OK] Contenedores de Docker iniciados correctamente

REM Instalar dependencias de Composer
echo.
echo ========================================
echo   INSTALANDO DEPENDENCIAS PHP
echo ========================================
docker-compose -f docker-compose.existing.yml exec app composer install --optimize-autoloader --no-dev

REM Verificar y generar clave de aplicacion si es necesario
echo.
echo Verificando configuracion de Laravel...
docker-compose -f docker-compose.existing.yml exec app php artisan config:clear >nul 2>&1
docker-compose -f docker-compose.existing.yml exec app php artisan key:generate --force

REM Esperar a que MySQL este completamente listo
echo.
echo Esperando a que MySQL este completamente inicializado...
timeout /t 30 /nobreak

REM Ejecutar migraciones
echo.
echo ========================================
echo   CONFIGURANDO BASE DE DATOS
echo ========================================
docker-compose -f docker-compose.existing.yml exec app php artisan migrate --force

REM Crear enlace simbolico para storage
echo.
echo Configurando almacenamiento...
docker-compose -f docker-compose.existing.yml exec app php artisan storage:link

REM Instalar y configurar Tailwind CSS
echo.
echo ========================================
echo   INSTALANDO TAILWIND CSS Y VITE
echo ========================================
echo Instalando dependencias de Node.js...
docker-compose -f docker-compose.existing.yml exec node npm install

echo Instalando Tailwind CSS y dependencias...
docker-compose -f docker-compose.existing.yml exec node npm install -D tailwindcss postcss autoprefixer @tailwindcss/forms

echo Configurando Tailwind CSS con colores personalizados...
echo Ya configurado en tailwind.config.js con paleta tecnica personalizada

REM Instalar SDKs de terceros
echo.
echo ========================================
echo   INSTALANDO SDKS DE TERCEROS
echo ========================================
echo Instalando SDK de PayPal...
docker-compose -f docker-compose.existing.yml exec node npm install @paypal/paypal-js

echo Instalando SDK de Bunny.net...
docker-compose -f docker-compose.existing.yml exec node npm install bunny-sdk

echo [OK] SDKs de PayPal y Bunny.net instalados correctamente

REM Limpiar y optimizar cache de Laravel
echo.
echo ========================================
echo   OPTIMIZANDO CONFIGURACION
echo ========================================
docker-compose -f docker-compose.existing.yml exec app composer dump-autoload
docker-compose -f docker-compose.existing.yml exec app php artisan config:clear
docker-compose -f docker-compose.existing.yml exec app php artisan route:clear
docker-compose -f docker-compose.existing.yml exec app php artisan view:clear

REM Construir assets de produccion con Vite
echo.
echo Construyendo assets de produccion con Vite...
docker-compose -f docker-compose.existing.yml exec node npm run build

echo.
echo ========================================
echo   CONFIGURACION COMPLETADA
echo ========================================
echo.
echo [OK] Proyecto Capstone inicializado correctamente
echo.
echo URLS DISPONIBLES:
echo   - Aplicacion Laravel: http://localhost:8080
echo   - Vite Dev Server:    http://localhost:5173
echo   - phpMyAdmin:         http://localhost:8081
echo.
echo CREDENCIALES DE BASE DE DATOS:
echo   - Base de datos: capstone_laravel
echo   - Usuario:       capstone_user
echo   - Password:      capstone_password_2025
echo   - Host externo:  localhost:3307
echo.
echo PUERTOS CONFIGURADOS:
echo   - Laravel (Nginx):   8080
echo   - Vite Dev Server:   5173
echo   - phpMyAdmin:        8081
echo   - MySQL:             3307
echo   - Redis:             6379
echo.
echo COMANDOS UTILES:
echo   - Ver logs:           docker-compose -f docker-compose.existing.yml logs -f
echo   - Detener servicios:  docker-compose -f docker-compose.existing.yml down
echo   - Reiniciar:          docker-compose -f docker-compose.existing.yml restart
echo   - Limpiar cache:      docker-compose -f docker-compose.existing.yml exec app php artisan config:clear
echo.
echo PARA DESARROLLO FRONTEND (ejecutar en terminal separada):
echo   docker-compose -f docker-compose.existing.yml exec node npm run dev
echo.
echo FUNCIONALIDADES IMPLEMENTADAS:
echo   ✓ Paleta de colores personalizada TechService Pro
echo   ✓ Animaciones CSS con Tailwind
echo   ✓ Interfaz completa de servicio tecnico
echo   ✓ Formularios de solicitud de servicio
echo   ✓ Sistema de estado de ordenes
echo   ✓ Vistas especializadas: computadoras, moviles, soporte
echo   ✓ Diseno responsive y moderno
echo.
echo NOTAS IMPORTANTES:
echo   - Los assets estan construidos para produccion
echo   - Para desarrollo con hot-reload ejecuta 'npm run dev' por separado
echo   - Todas las rutas del servicio tecnico estan configuradas
echo   - La interfaz usa colores: dark-blue, electric-blue, success-green, etc.
echo.
pause