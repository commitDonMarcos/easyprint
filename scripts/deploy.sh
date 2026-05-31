#!/bin/bash
set -e

echo "🚀 EasyPrint Production Deployment"
echo "=================================="

# Environment checks
if [ "$APP_ENV" = "local" ]; then
    echo "❌ Cannot run deployment script in local environment"
    exit 1
fi

echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Installing Node dependencies..."
npm ci --production

echo "🔨 Building frontend assets..."
npm run build

echo "⚙️  Running migrations..."
php artisan migrate --force

echo "🔧 Caching config..."
php artisan config:cache

echo "🔧 Caching routes..."
php artisan route:cache

echo "🔧 Caching views..."
php artisan view:cache

echo "🔧 Optimizing framework..."
php artisan optimize

echo "📁 Creating storage link..."
php artisan storage:link --force

echo "✅ Deployment complete!"
