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

REM Matar cualquier proceso de Vite existente
echo.
echo Deteniendo procesos de Vite existentes...
docker-compose -f docker-compose.existing.yml exec node pkill -f vite 2>nul || echo No hay procesos de Vite ejecutandose

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