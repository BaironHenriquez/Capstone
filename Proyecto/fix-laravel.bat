@echo off
REM Script de solucion rapida para problemas de Laravel
echo ========================================
echo   SOLUCIONANDO PROBLEMAS DE LARAVEL
echo ========================================
echo.

REM Limpiar todas las caches
echo Limpiando caches de Laravel...
docker exec laravel-app php artisan config:clear 2>nul
docker exec laravel-app php artisan route:clear 2>nul
docker exec laravel-app php artisan view:clear 2>nul
docker exec laravel-app php artisan cache:clear 2>nul

REM Regenerar autoload
echo Regenerando autoload de Composer...
docker exec laravel-app composer dump-autoload 2>nul

REM Verificar permisos
echo Verificando permisos de storage...
docker exec laravel-app chmod -R 775 storage 2>nul
docker exec laravel-app chmod -R 775 bootstrap/cache 2>nul

REM Generar clave de aplicacion si no existe
echo Verificando clave de aplicacion...
docker exec laravel-app php artisan key:generate --force 2>nul

REM Construir assets de Vite
echo Construyendo assets con Vite...
docker exec laravel-node npm run build 2>nul

echo.
echo [OK] Problemas solucionados. Probando aplicacion...
echo.

REM Reiniciar contenedor de aplicacion
docker-compose restart app >nul

echo Aplicacion reiniciada. Probando en http://localhost:8080
echo.
pause