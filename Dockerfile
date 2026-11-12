# syntax=docker/dockerfile:1
# Production image for Render (runtime: docker). Apache + mod_php, Laravel 12, PHP 8.2.

# ---- Stage 1: build front-end assets (Vite 7 needs Node >= 20.19) ----
FROM node:22-bookworm-slim AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# ---- Stage 2: PHP runtime ----
FROM php:8.2-apache-bookworm

# System libs + PHP extensions (mbstring, curl, openssl, fileinfo, etc. ship with the base image)
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev libzip-dev unzip \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql opcache bcmath zip \
    && apt-get purge -y --auto-remove libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP production settings + Apache vhost that serves /public on $PORT
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && a2enmod rewrite headers \
    && sed -i 's/^Listen 80$/Listen ${PORT}/' /etc/apache2/ports.conf \
    && echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername \
    && sed -ri 's/^ServerTokens .*/ServerTokens Prod/; s/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

# Install PHP dependencies first (cached layer while composer.lock is unchanged)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --no-scripts --no-autoloader

# Application code + built assets
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --no-dev --optimize \
    && php artisan package:discover --ansi \
    && mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions \
                storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && sed -i 's/\r$//' docker/start.sh && chmod +x docker/start.sh

# Render injects PORT at runtime (default 10000); 8080 is the local fallback.
ENV PORT=8080
EXPOSE 8080

CMD ["docker/start.sh"]
