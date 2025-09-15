@echo off
REM Script para detener todos los servicios del proyecto Capstone

echo ========================================
echo    DETENIENDO SERVICIOS CAPSTONE
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

echo Deteniendo todos los contenedores...
docker-compose -f docker-compose.existing.yml down

echo.
echo [OK] Todos los servicios han sido detenidos
echo.
echo Para volver a iniciar los servicios, ejecuta: iniciar-servicios.bat
echo.
pause