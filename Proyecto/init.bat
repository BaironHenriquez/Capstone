@echo off
REM Script para inicializar el proyecto Laravel en Windows

echo Iniciando el proyecto Laravel...

REM Verificar puertos disponibles
echo Verificando puertos criticos...
netstat -an | findstr ":8080 " >nul
if %errorlevel%==0 (
    echo ADVERTENCIA: Puerto 8080 en uso - La aplicacion web podria no estar disponible
)
netstat -an | findstr ":3307 " >nul
if %errorlevel%==0 (
    echo ADVERTENCIA: Puerto 3307 en uso - MySQL externo podria no estar disponible
)

REM Copiar archivo de entorno
if not exist .env (
    copy .env.example .env
    echo Archivo .env creado
)

REM Parar contenedores si están ejecutándose
echo Deteniendo contenedores existentes...
docker-compose down

REM Construir e iniciar contenedores
echo Construyendo e iniciando contenedores Docker...
docker-compose up -d --build

REM Esperar a que los servicios estén listos
echo Esperando a que los servicios esten listos...
timeout /t 40 /nobreak

REM Verificar si Laravel ya está instalado
docker-compose exec app test -f artisan
if errorlevel 1 (
    echo Instalando Laravel...
    docker-compose exec app composer create-project --prefer-dist laravel/laravel temp-laravel
    docker-compose exec app bash -c "shopt -s dotglob && mv temp-laravel/* . && mv temp-laravel/.* . 2>/dev/null || true && rmdir temp-laravel"
    echo Laravel instalado correctamente
) else (
    echo Laravel ya esta instalado
)

REM Instalar/actualizar dependencias de Composer
echo Instalando dependencias de Composer...
docker-compose exec app composer install --optimize-autoloader

REM Generar clave de aplicación
echo Generando clave de aplicacion...
docker-compose exec app php artisan key:generate

REM Ejecutar migraciones
echo Ejecutando migraciones de base de datos...
docker-compose exec app php artisan migrate --force

REM Crear enlace simbólico para storage
echo Creando enlace simbolico para storage...
docker-compose exec app php artisan storage:link

REM Limpiar cache
echo Limpiando cache...
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

echo Proyecto inicializado correctamente!
echo La aplicacion esta disponible en: http://localhost:8080
echo phpMyAdmin esta disponible en: http://localhost:8081
echo.
echo Para instalar dependencias de Node.js y ejecutar Vite:
echo    docker-compose exec node npm install
echo    docker-compose exec node npm run dev
pause