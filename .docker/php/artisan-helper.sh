#!/bin/bash

# Script helper para ejecutar comandos de Artisan como www-data
# Uso: artisan-helper.sh <comando>

if [ "$#" -eq 0 ]; then
    echo "❌ Error: Debes proporcionar un comando"
    echo "Uso: artisan-helper.sh <comando>"
    echo "Ejemplo: artisan-helper.sh php artisan make:model Post"
    exit 1
fi

echo "🚀 Ejecutando como www-data: $@"
exec su -s /bin/bash www-data -c "cd /var/www/html && $@"
