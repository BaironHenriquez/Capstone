#!/bin/bash

# Script para instalar Laravel en el contenedor

echo "📦 Instalando Laravel..."

# Crear proyecto Laravel
composer create-project --prefer-dist laravel/laravel temp-laravel

# Mover archivos de Laravel al directorio actual
mv temp-laravel/* .
mv temp-laravel/.[^.]* . 2>/dev/null || true

# Eliminar directorio temporal
rm -rf temp-laravel

echo "✅ Laravel instalado correctamente!"