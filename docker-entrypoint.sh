#!/bin/bash

set -e

echo "======================================"
echo "Basic Industry - Railway"
echo "======================================"

cd /var/www/html

# Railway provides the PORT environment variable.
PORT=${PORT:-8080}

echo "Using PORT: $PORT"

# Configure Apache to listen on Railway PORT
sed -ri "s/^Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf

sed -ri \
    "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

# Prepare Laravel storage directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Set permissions
chown -R www-data:www-data \
    storage \
    bootstrap/cache

# Create storage symbolic link
php artisan storage:link || true

echo "Laravel application is ready."

exec "$@"