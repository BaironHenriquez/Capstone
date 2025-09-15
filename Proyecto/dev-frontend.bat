@echo off
REM Script para instalar y ejecutar Vite (desarrollo frontend)

echo Instalando dependencias de Node.js...
docker-compose exec node npm install

echo Iniciando servidor de desarrollo Vite...
echo ADVERTENCIA: Este comando mantendra el servidor en funcionamiento.
echo    Presiona Ctrl+C para detenerlo.
echo.
docker-compose exec node npm run dev