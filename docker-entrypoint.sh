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
# LARAVEL CONFIGURATION
# ============================================================
echo "Caching Laravel configuration..."

php artisan config:cache

echo "Laravel configuration cached."


# ============================================================
# DATABASE
# ============================================================
echo "Checking database connection..."

if php artisan migrate:status > /dev/null 2>&1; then

    echo "Database connection successful."

    echo "Running migrations..."

    php artisan migrate --force

    echo "Database migration successful."

else

    echo "WARNING: Database is not connected."

    echo "Laravel will start without running migrations."

fi


# ============================================================
# START APPLICATION
# ============================================================
echo "======================================"
echo "Laravel is ready."
echo "Starting Laravel server on port $PORT"
echo "======================================"


exec php artisan serve \
    --host=0.0.0.0 \
    --port="$PORT"