@echo off
echo ========================================
echo   INSTALACION INICIAL DEL PROYECTO
echo ========================================
echo.

REM Verificar si existe composer
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Composer no esta instalado
    echo Por favor, instala Composer desde: https://getcomposer.org/
    pause
    exit /b 1
)

REM Verificar si existe node
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Node.js no esta instalado
    echo Por favor, instala Node.js desde: https://nodejs.org/
    pause
    exit /b 1
)

REM Instalar dependencias de Composer
echo [1/5] Instalando dependencias de Composer...
call composer install
if %errorlevel% neq 0 (
    echo [ERROR] Fallo la instalacion de dependencias de Composer
    pause
    exit /b 1
)
echo     [OK] Dependencias de Composer instaladas
echo.

REM Instalar dependencias de NPM
echo [2/5] Instalando dependencias de NPM...
call npm install
if %errorlevel% neq 0 (
    echo [ERROR] Fallo la instalacion de dependencias de NPM
    pause
    exit /b 1
)
echo     [OK] Dependencias de NPM instaladas
echo.

REM Copiar archivo .env
echo [3/5] Configurando archivo .env...
if not exist ".env" (
    copy .env.example .env
    echo     [OK] Archivo .env creado
) else (
    echo     [INFO] Archivo .env ya existe
)
echo.

REM Generar key de la aplicacion
echo [4/5] Generando key de la aplicacion...
php artisan key:generate
echo     [OK] Key generada
echo.

REM Ejecutar migraciones
echo [5/5] Deseas ejecutar las migraciones de base de datos? (S/N)
set /p MIGRATE="> "
if /i "%MIGRATE%"=="S" (
    php artisan migrate
    if %errorlevel% equ 0 (
        echo     [OK] Migraciones ejecutadas
    ) else (
        echo     [ERROR] Fallo la ejecucion de migraciones
        echo     Verifica tu conexion a la base de datos en el archivo .env
    )
) else (
    echo     [INFO] Migraciones omitidas
)
echo.

echo ========================================
echo   INSTALACION COMPLETADA
echo ========================================
echo.
echo Pasos siguientes:
echo 1. Configura tu base de datos en el archivo .env
echo 2. Ejecuta: php artisan migrate (si aun no lo hiciste)
echo 3. Ejecuta: iniciar-servicios.bat para iniciar el proyecto
echo.
pause
