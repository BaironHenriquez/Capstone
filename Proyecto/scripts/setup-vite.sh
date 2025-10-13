#!/bin/bash
# Script para configurar Vite correctamente

echo "Configurando Vite para desarrollo..."

# Instalar dependencias
npm install

# Limpiar cache de Vite
rm -rf node_modules/.vite 2>/dev/null || true

# Asegurar que los directorios de assets existan
mkdir -p public/build
mkdir -p resources/css
mkdir -p resources/js

# Verificar archivos requeridos
if [ ! -f "resources/css/app.css" ]; then
    echo "Creando resources/css/app.css..."
    echo "/* App CSS */" > resources/css/app.css
fi

if [ ! -f "resources/js/app.js" ]; then
    echo "Creando resources/js/app.js..."
    echo "// App JS" > resources/js/app.js
fi

# Crear archivos baieco si no existen
if [ ! -f "resources/css/baieco.css" ]; then
    echo "Creando resources/css/baieco.css..."
    touch resources/css/baieco.css
fi

if [ ! -f "resources/js/baieco.js" ]; then
    echo "Creando resources/js/baieco.js..."
    touch resources/js/baieco.js
fi

echo "Configuración de Vite completada"