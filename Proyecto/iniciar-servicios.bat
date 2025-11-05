@echo off
echo ========================================
echo   INICIANDO SERVICIOS LARAVEL (SIN DOCKER)
echo ========================================
echo.

REM Verificar si existe el archivo .env
if not exist ".env" (
    echo [ERROR] Archivo .env no encontrado
    echo Por favor, copia .env.example a .env y configura tus credenciales
    pause
    exit /b 1
)

REM Iniciar servidor Laravel en una nueva ventana
echo [1/2] Iniciando servidor Laravel en http://localhost:8080...
start "Laravel Server" cmd /k "php artisan serve --host=localhost --port=8080"
timeout /t 2 /nobreak > nul

REM Iniciar Vite dev server en una nueva ventana
echo [2/2] Iniciando Vite dev server en http://localhost:5173...
start "Vite Dev Server" cmd /k "npm run dev"
timeout /t 2 /nobreak > nul

echo.
echo ========================================
echo   SERVICIOS INICIADOS CORRECTAMENTE
echo ========================================
echo.
echo Laravel:  http://localhost:8080
echo Vite:     http://localhost:5173
echo.
echo Para detener los servicios, cierra las ventanas de comandos
echo o ejecuta: detener-servicios.bat
echo.
pause
