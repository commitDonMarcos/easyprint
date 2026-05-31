#!/bin/bash
set -e

if [ ! -f .env ]; then
    echo "APP_KEY=" > .env
    php artisan key:generate --force 2>/dev/null || true
fi

php artisan storage:link --force 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true
php artisan migrate --force 2>/dev/null || true

PORT="${PORT:-8000}"
php artisan serve --host=0.0.0.0 --port="$PORT"
