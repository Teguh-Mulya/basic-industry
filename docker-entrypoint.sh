#!/bin/bash

set -e

echo "======================================"
echo "Starting Basic Industry Laravel"
echo "======================================"

cd /var/www/html

echo "Preparing Laravel storage..."

mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

chown -R www-data:www-data storage bootstrap/cache

echo "Creating storage link..."

php artisan storage:link || true

echo "Waiting for database..."

for i in {1..10}
do
    if php artisan migrate --force
    then
        echo "Database migration successful."
        break
    fi

    echo "Database not ready. Retrying in 5 seconds..."
    sleep 5
done

echo "Caching Laravel configuration..."

php artisan config:cache

echo "Laravel is ready."

exec "$@"