# =========================
# Stage 1: Build Frontend
# =========================
FROM node:24-alpine AS frontend

WORKDIR /app

COPY package*.json ./

RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi

COPY . .

RUN npm run build


# =========================
# Stage 2: Install Composer
# =========================
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


# =========================
# Stage 3: Laravel Runtime
# =========================
FROM php:8.2-apache

WORKDIR /var/www/html

# Install system dependencies
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


# Enable Apache rewrite
RUN a2enmod rewrite


# Configure Apache to use Laravel public directory
RUN sed -ri \
    -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

# Render uses port 10000 by default
RUN sed -ri 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' \
    /etc/apache2/sites-available/000-default.conf


# Copy Laravel application
COPY --from=vendor /app /var/www/html

# Copy compiled frontend assets
COPY --from=frontend /app/public/build /var/www/html/public/build


# Copy startup script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh


# Laravel permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache


EXPOSE 10000

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["apache2-foreground"]