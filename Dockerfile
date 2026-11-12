# Stage 1: build frontend with Node
FROM node:18 AS nodebuilder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources resources
COPY vite.config.js .
RUN npm run build

# Stage 2: final image with PHP
FROM php:8.2-cli

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libpq-dev \
    curl \
    wget \
    procps \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app source
COPY . /var/www/html

# Copy built frontend from node stage
COPY --from=nodebuilder /app/public /var/www/html/public

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Ensure storage and cache are writable
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Expose port for the built-in PHP server
EXPOSE 8080

# Default start command (development-friendly). For production, consider using php-fpm + nginx.
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
