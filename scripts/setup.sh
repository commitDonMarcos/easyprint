#!/bin/bash
set -e

echo "================================================"
echo "  EasyPrint - Production Setup Script"
echo "================================================"
echo ""

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
if [ "$(echo "$PHP_VERSION < 8.2" | bc)" -eq 1 ]; then
    echo "❌ PHP 8.2+ required (found $PHP_VERSION)"
    exit 1
fi
echo "✅ PHP $PHP_VERSION"

# Check Node.js
if ! command -v node &> /dev/null; then
    echo "❌ Node.js not found"
    exit 1
fi
echo "✅ Node.js $(node --version)"

# Check Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer not found"
    exit 1
fi
echo "✅ Composer $(composer --version | head -1)"

echo ""
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist

echo ""
echo "🔑 Generating app key..."
php artisan key:generate --force

echo ""
echo "📦 Installing Node dependencies..."
npm ci

echo ""
echo "🔨 Building frontend assets..."
npm run build

echo ""
echo "📁 Creating storage link..."
php artisan storage:link --force

echo ""
echo "🗄️  Running database migrations..."
php artisan migrate --force

echo ""
echo "🌱 Seeding database..."
php artisan db:seed --force

echo ""
echo "⚙️  Caching for production..."
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo ""
echo "================================================"
echo "  ✅ EasyPrint is ready for production!"
echo "================================================"
echo ""
echo "Start the dev server:"
echo "  php artisan serve"
echo ""
echo "Or deploy to Railway:"
echo "  railway up"
echo ""
