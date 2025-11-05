@echo off
echo ========================================
echo   DETENIENDO SERVICIOS LARAVEL
echo ========================================
echo.

REM Detener procesos de PHP Artisan Server
echo [1/2] Deteniendo servidor Laravel...
taskkill /FI "WINDOWTITLE eq Laravel Server*" /T /F 2>nul
if %errorlevel% equ 0 (
    echo     [OK] Servidor Laravel detenido
) else (
    echo     [INFO] No se encontro proceso de Laravel Server
)

REM Detener procesos de Vite
echo [2/2] Deteniendo Vite dev server...
taskkill /FI "WINDOWTITLE eq Vite Dev Server*" /T /F 2>nul
if %errorlevel% equ 0 (
    echo     [OK] Vite dev server detenido
) else (
    echo     [INFO] No se encontro proceso de Vite
)

echo.
echo ========================================
echo   SERVICIOS DETENIDOS
echo ========================================
echo.
pause
