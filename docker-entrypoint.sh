#!/bin/bash

set -e

echo "======================================"
echo "Starting Basic Industry Laravel"
echo "======================================"

cd /var/www/html


# ============================================================
# Railway PORT
# ============================================================
PORT=${PORT:-8080}

echo "Using PORT: $PORT"


# ============================================================
# Configure Apache Port
# ============================================================
echo "Configuring Apache..."

sed -ri "s/^Listen [0-9]+/Listen ${PORT}/" \
    /etc/apache2/ports.conf

sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf


# ============================================================
# Laravel Storage
# ============================================================
echo "Preparing Laravel storage..."

mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache


# ============================================================
# Permission
# ============================================================
echo "Setting Laravel permissions..."

chown -R www-data:www-data \
    storage \
    bootstrap/cache


# ============================================================
# Storage Link
# ============================================================
echo "Checking storage link..."

if [ ! -L public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link || true
else
    echo "Storage link already exists."
fi


# ============================================================
# Database Migration
# ============================================================
echo "Waiting for database..."


MAX_ATTEMPTS=30
ATTEMPT=1

while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do

    if php artisan migrate:status > /dev/null 2>&1; then
        echo "Database connection successful."
        break
    fi

    echo "Database is not ready. Attempt $ATTEMPT/$MAX_ATTEMPTS..."

    ATTEMPT=$((ATTEMPT + 1))

    sleep 3

done


# ============================================================
# Run Migration
# ============================================================
if [ $ATTEMPT -le $MAX_ATTEMPTS ]; then

    echo "Running database migrations..."

    php artisan migrate --force

    echo "Database migration successful."

else

    echo "WARNING: Database is not available."

fi


# ============================================================
# Laravel Configuration Cache
# ============================================================
echo "Caching Laravel configuration..."

php artisan config:cache

echo "Laravel is ready."


# ============================================================
# Start Apache
# ============================================================
exec "$@"