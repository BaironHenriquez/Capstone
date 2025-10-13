@echo off
echo ====================================
echo   OPTIMIZANDO RENDIMIENTO LARAVEL
echo ====================================

echo.
echo [1/6] Limpiando caches anteriores...
docker exec laravel-app php artisan optimize:clear

echo.
echo [2/6] Cacheando configuracion...
docker exec laravel-app php artisan config:cache

echo.
echo [3/6] Cacheando rutas...
docker exec laravel-app php artisan route:cache

echo.
echo [4/6] Cacheando vistas...
docker exec laravel-app php artisan view:cache

echo.
echo [5/6] Optimizando autoloader...
docker exec laravel-app composer dump-autoload --optimize

echo.
echo [6/6] Reiniciando PHP-FPM para aplicar OPcache...
docker restart laravel-app

echo.
echo ====================================
echo   OPTIMIZACION COMPLETADA!
echo ====================================
echo.
echo Beneficios aplicados:
echo - Cache de configuracion activado
echo - Cache de rutas optimizado
echo - Vistas precompiladas
echo - Autoloader optimizado
echo - OPcache habilitado
echo.
echo Tu aplicacion deberia cargar mas rapido ahora.

pause