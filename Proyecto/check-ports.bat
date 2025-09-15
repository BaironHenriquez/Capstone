@echo off
REM Script para verificar puertos disponibles antes de iniciar el proyecto

echo Verificando puertos disponibles...
echo.

REM Verificar puerto 8080 (aplicación web)
netstat -an | findstr ":8080 " >nul
if %errorlevel%==0 (
    echo OCUPADO: Puerto 8080 esta en uso - Aplicacion web no estara disponible
) else (
    echo DISPONIBLE: Puerto 8080 disponible - Aplicacion web
)

REM Verificar puerto 8081 (phpMyAdmin)
netstat -an | findstr ":8081 " >nul
if %errorlevel%==0 (
    echo OCUPADO: Puerto 8081 esta en uso - phpMyAdmin no estara disponible
) else (
    echo DISPONIBLE: Puerto 8081 disponible - phpMyAdmin
)

REM Verificar puerto 3307 (MySQL externo)
netstat -an | findstr ":3307 " >nul
if %errorlevel%==0 (
    echo OCUPADO: Puerto 3307 esta en uso - MySQL externo no estara disponible
) else (
    echo DISPONIBLE: Puerto 3307 disponible - MySQL externo
)

REM Verificar puerto 6379 (Redis)
netstat -an | findstr ":6379 " >nul
if %errorlevel%==0 (
    echo OCUPADO: Puerto 6379 esta en uso - Redis no estara disponible
) else (
    echo DISPONIBLE: Puerto 6379 disponible - Redis
)

REM Verificar puerto 5173 (Vite)
netstat -an | findstr ":5173 " >nul
if %errorlevel%==0 (
    echo OCUPADO: Puerto 5173 esta en uso - Vite dev server no estara disponible
) else (
    echo DISPONIBLE: Puerto 5173 disponible - Vite dev server
)

echo.
echo Si algun puerto esta en uso, puedes:
echo    1. Cambiar los puertos en docker-compose.yml
echo    2. Detener el servicio que usa el puerto
echo    3. Usar el proyecto con los puertos disponibles
echo.
pause