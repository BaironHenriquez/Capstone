@echo off
REM Script para verificar el estado de los servicios del proyecto Capstone

echo ========================================
echo   ESTADO DE SERVICIOS CAPSTONE
echo ========================================
echo.

REM Verificar que Docker esta funcionando
docker --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker no esta instalado o no esta funcionando
    exit /b 1
)

REM Verificar que estamos en el directorio correcto
if not exist "docker-compose.existing.yml" (
    echo ERROR: No se encontro docker-compose.existing.yml
    echo Asegurate de estar en el directorio correcto del proyecto
    exit /b 1
)

echo Estado de los contenedores:
echo.
docker-compose -f docker-compose.existing.yml ps

echo.
echo ========================================
echo   URLS Y PUERTOS DISPONIBLES
echo ========================================
echo.
echo URLS DISPONIBLES:
echo   - Aplicacion Laravel: http://localhost:8080
echo   - Vite Dev Server:    http://localhost:5173
echo   - phpMyAdmin:         http://localhost:8081
echo.
echo PUERTOS CONFIGURADOS:
echo   - Laravel (Nginx):   8080
echo   - Vite Dev Server:   5173
echo   - phpMyAdmin:        8081
echo   - MySQL:             3307
echo   - Redis:             6379
echo.

REM Verificar puertos en uso
echo Verificando puertos en uso:
netstat -an | findstr ":8080"
netstat -an | findstr ":5173"
netstat -an | findstr ":8081"
netstat -an | findstr ":3307"
netstat -an | findstr ":6379"

echo.
pause