#!/bin/bash

set -e

echo "======================================"
echo "Starting Basic Industry Laravel"
echo "======================================"

cd /var/www/html


# ============================================================
# RAILWAY PORT
# ============================================================
PORT=${PORT:-8080}

echo "Using PORT: $PORT"


# ============================================================
# APACHE PORT
# ============================================================
echo "Configuring Apache port..."

sed -ri "s/^Listen [0-9]+/Listen ${PORT}/" \
    /etc/apache2/ports.conf

sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf


# ============================================================
# LARAVEL STORAGE
# ============================================================
echo "Preparing Laravel storage..."

mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache


# ============================================================
# PERMISSION
# ============================================================
echo "Setting Laravel permissions..."

chown -R www-data:www-data \
    storage \
    bootstrap/cache


# ============================================================
# STORAGE LINK
# ============================================================
echo "Checking storage link..."

if [ -L public/storage ]; then

    echo "Storage link already exists."

elif [ -e public/storage ]; then

    echo "public/storage exists but is not a symbolic link."

else

    echo "Creating storage link..."

    php artisan storage:link || true

fi


# ============================================================
# DATABASE CONNECTION
# ============================================================
echo "Waiting for database..."

MAX_ATTEMPTS=30
ATTEMPT=1

while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do

    if php artisan migrate:status > /dev/null 2>&1; then

        echo "Database connection successful."

        break

    fi

    echo "Database is not ready."
    echo "Attempt $ATTEMPT/$MAX_ATTEMPTS..."

    ATTEMPT=$((ATTEMPT + 1))

    sleep 3

done


# ============================================================
# DATABASE MIGRATION
# ============================================================
if [ $ATTEMPT -le $MAX_ATTEMPTS ]; then

    echo "Running database migrations..."

    php artisan migrate --force

    echo "Database migration successful."

else

    echo "WARNING: Database connection failed."

fi


# ============================================================
# LARAVEL CONFIG CACHE
# ============================================================
echo "Caching Laravel configuration..."

php artisan config:cache

echo "Laravel is ready."


# ============================================================
# APACHE CONFIG CHECK
# ============================================================
echo "Checking Apache configuration..."

apache2ctl -t


# ============================================================
# START APACHE
# ============================================================
echo "Starting Apache..."

exec "$@"