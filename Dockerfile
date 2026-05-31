FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip ca-certificates gnupg \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts 2>/dev/null; exit 0

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm run build 2>/dev/null; exit 0

RUN mkdir -p storage/logs storage/framework/cache/data \
    storage/framework/sessions storage/framework/views \
    storage/framework/testing bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN echo "APP_KEY=" > .env

EXPOSE $PORT

CMD php artisan serve --host=0.0.0.0 --port=$PORT
