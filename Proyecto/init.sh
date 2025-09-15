#!/bin/bash

# Script para inicializar el proyecto Laravel

echo "🚀 Iniciando el proyecto Laravel..."

# Copiar archivo de entorno
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Archivo .env creado"
fi

# Construir e iniciar contenedores
echo "🐳 Construyendo e iniciando contenedores Docker..."
docker-compose up -d --build

# Esperar a que los servicios estén listos
echo "⏳ Esperando a que los servicios estén listos..."
sleep 30

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de Composer..."
docker-compose exec app composer install

# Generar clave de aplicación
echo "🔑 Generando clave de aplicación..."
docker-compose exec app php artisan key:generate

# Ejecutar migraciones
echo "🗃️ Ejecutando migraciones de base de datos..."
docker-compose exec app php artisan migrate

# Crear enlace simbólico para storage
echo "🔗 Creando enlace simbólico para storage..."
docker-compose exec app php artisan storage:link

# Instalar dependencias de Node.js
echo "📦 Instalando dependencias de Node.js..."
docker-compose exec node npm install

# Construir assets
echo "🎨 Construyendo assets..."
docker-compose exec node npm run build

echo "✅ ¡Proyecto inicializado correctamente!"
echo "🌐 La aplicación está disponible en: http://localhost:8080"
echo "🗄️ phpMyAdmin está disponible en: http://localhost:8081"