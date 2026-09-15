# ============================================================
# STAGE 1 - FRONTEND
# ============================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./

RUN if [ -f package-lock.json ]; then \
        npm ci; \
    else \
        npm install; \
    fi

COPY . .

RUN npm run build


# ============================================================
# STAGE 2 - COMPOSER
# ============================================================
FROM composer:2.8 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer dump-autoload \
    --optimize \
    --no-dev


# ============================================================
# STAGE 3 - LARAVEL
# ============================================================
FROM php:8.2-cli

WORKDIR /var/www/html


# ============================================================
# INSTALL PHP EXTENSIONS
# ============================================================
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# ============================================================
# COPY LARAVEL
# ============================================================
COPY --from=vendor /app /var/www/html


# ============================================================
# COPY FRONTEND BUILD
# ============================================================
COPY --from=frontend /app/public/build /var/www/html/public/build


# ============================================================
# CREATE STORAGE DIRECTORIES
# ============================================================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache


# ============================================================
# PERMISSION
# ============================================================
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache


# ============================================================
# ENTRYPOINT
# ============================================================
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh


# ============================================================
# RAILWAY PORT
# ============================================================
EXPOSE 8080


# ============================================================
# START
# ============================================================
ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]