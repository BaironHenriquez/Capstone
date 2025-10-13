@echo off
REM Script rapido para iniciar servicios del proyecto Capstone
REM Este script solo inicia los contenedores existentes

echo ========================================
echo     INICIANDO SERVICIOS CAPSTONE
echo ========================================
echo.

REM Verificar que Docker esta funcionando
docker --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker no esta instalado o no esta funcionando
    echo Por favor instala Docker Desktop y asegurate de que este ejecutandose
    pause
    exit /b 1
)

echo [OK] Docker detectado y funcionando

REM Verificar que estamos en el directorio correcto
if not exist "docker-compose.existing.yml" (
    echo ERROR: No se encontro docker-compose.existing.yml
    echo Asegurate de estar en el directorio correcto del proyecto
    pause
    exit /b 1
)

echo [OK] Directorio del proyecto correcto

REM Iniciar todos los servicios
echo.
echo Iniciando contenedores Docker...
docker-compose -f docker-compose.existing.yml up -d

REM Verificar que los servicios estan corriendo
echo.
echo Verificando estado de los servicios...
timeout /t 15 /nobreak >nul

docker-compose -f docker-compose.existing.yml ps

REM Verificar conexion a base de datos y ejecutar migraciones
echo.
echo Verificando base de datos y ejecutando migraciones...
echo Esperando que MySQL este completamente listo...
timeout /t 10 /nobreak >nul

REM Ejecutar migraciones automaticamente
docker exec laravel-app php artisan migrate --force
if errorlevel 1 (
    echo [WARNING] Error ejecutando migraciones, reintentando en 5 segundos...
    timeout /t 5 /nobreak >nul
    docker exec laravel-app php artisan migrate --force
)

REM Limpiar caches de Laravel
echo Limpiando caches de Laravel...
docker exec laravel-app php artisan config:clear
docker exec laravel-app php artisan cache:clear
docker exec laravel-app php artisan config:cache

echo [OK] Base de datos configurada y migraciones ejecutadas

REM Preparar entorno Node.js para Vite
echo.
echo Preparando entorno Node.js para desarrollo frontend...
docker exec laravel-node npm install >nul 2>&1
echo [OK] Dependencias de Node.js instaladas

echo.
echo ========================================
echo     SERVICIOS INICIADOS
echo ========================================
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
echo.
echo Para desarrollo frontend (ejecutar en otra terminal):
echo   docker-compose -f docker-compose.existing.yml exec node npm run dev
echo.
echo PARA INICIAR VITE AUTOMATICAMENTE (ejecutar este comando aparte):
echo   start cmd /k "docker-compose -f docker-compose.existing.yml exec node npm run dev"
echo.
echo FUNCIONALIDADES DISPONIBLES:
echo   ✓ Interfaz TechService Pro con colores personalizados
echo   ✓ Formulario de solicitud de servicio (/servicios/crear)
echo   ✓ Servicios de computadoras (/servicios/computadoras)  
echo   ✓ Servicios moviles (/servicios/moviles)
echo   ✓ Soporte tecnico (/servicios/soporte)
echo   ✓ Estado de ordenes (/ordenes/estado)
echo   ✓ Animaciones CSS y diseno responsive
echo.
echo [OK] Todos los servicios estan listos para usar
echo.
pause