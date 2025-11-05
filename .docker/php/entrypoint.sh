#!/bin/bash
set -e

# Arreglar permisos de archivos críticos para Laravel
echo "🔧 Ajustando permisos de archivos..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Asegurar que www-data pueda leer archivos de la aplicación
find /var/www/html/app -type d -exec chmod 755 {} \; 2>/dev/null || true
find /var/www/html/app -type f -exec chmod 644 {} \; 2>/dev/null || true
find /var/www/html/resources -type d -exec chmod 755 {} \; 2>/dev/null || true
find /var/www/html/resources -type f -exec chmod 644 {} \; 2>/dev/null || true

echo "✅ Permisos ajustados"

# Ejecutar el comando original (Apache + Vite)
exec "$@"
