#!/bin/bash
set -e

echo "=== EasyPrint Entrypoint ==="

if [ ! -f .env ]; then
    echo "Creating .env with APP_KEY..."
    echo "APP_KEY=" > .env
    php artisan key:generate --force
fi

echo "Linking storage..."
php artisan storage:link --force

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Starting server on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
