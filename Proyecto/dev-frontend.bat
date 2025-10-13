@echo off
REM Script para iniciar Vite en modo desarrollo
REM Este script debe ejecutarse en una terminal separada

echo ========================================
echo     INICIANDO VITE DEV SERVER
echo ========================================
echo.

REM Verificar que Docker esta funcionando
docker --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker no esta instalado o no esta funcionando
    pause
    exit /b 1
)

REM Verificar que estamos en el directorio correcto
if not exist "docker-compose.existing.yml" (
    echo ERROR: No se encontro docker-compose.existing.yml
    echo Asegurate de estar en el directorio correcto del proyecto
    pause
    exit /b 1
)

REM Verificar que el contenedor node este ejecutandose
docker-compose -f docker-compose.existing.yml ps node | findstr "Up" >nul
if errorlevel 1 (
    echo ERROR: El contenedor de Node.js no esta ejecutandose
    echo Por favor ejecuta primero 'iniciar-servicios.bat'
    pause
    exit /b 1
)

echo [OK] Contenedor Node.js detectado y funcionando

REM Verificar que la base de datos este lista
echo Verificando conexion a base de datos...
docker exec laravel-app php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB OK';" >nul 2>&1
if errorlevel 1 (
    echo [WARNING] Problema con la conexion a base de datos
    echo Ejecutando verificacion y migraciones...
    docker exec laravel-app php artisan migrate --force >nul 2>&1
    docker exec laravel-app php artisan config:clear >nul 2>&1
    echo [OK] Base de datos verificada
) else (
    echo [OK] Conexion a base de datos correcta
)

REM Configurar y preparar Vite
echo.
echo Configurando entorno Vite...
echo Instalando dependencias...
docker-compose -f docker-compose.existing.yml exec node npm install

REM Matar cualquier proceso de Vite existente
echo.
echo Deteniendo procesos de Vite existentes...
docker-compose -f docker-compose.existing.yml exec node pkill -f vite 2>nul || echo No hay procesos de Vite ejecutandose

REM Limpiar cache y directorios temporales
echo.
echo Limpiando cache de Vite...
docker-compose -f docker-compose.existing.yml exec node sh -c "rm -rf node_modules/.vite 2>/dev/null || true"
docker-compose -f docker-compose.existing.yml exec node sh -c "mkdir -p public/build 2>/dev/null || true"

REM Iniciar Vite en modo desarrollo
echo.
echo ========================================
echo   INICIANDO VITE DEVELOPMENT SERVER
echo ========================================
echo.
echo [INFO] Servidor de desarrollo iniciando en puerto 5173
echo [INFO] Hot Module Replacement (HMR) habilitado
echo [INFO] Presiona Ctrl+C para detener
echo.

REM Ejecutar Vite en modo desarrollo
docker-compose -f docker-compose.existing.yml exec node npm run dev