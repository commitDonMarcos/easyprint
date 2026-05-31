#!/bin/bash
set -e

if [ ! -f .env ]; then
    echo "APP_KEY=" > .env
    php artisan key:generate --force
fi

php artisan storage:link --force 2>/dev/null || true

(
    sleep 2
    php artisan migrate --force 2>/dev/null || true
) &

php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
