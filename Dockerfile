# ======================
#  Build Vite assets
# ======================
FROM node:20-alpine AS nodebuilder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# ======================
#  PHP Application
# ======================
FROM php:8.2-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    git unzip curl \
    libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev \
    oniguruma-dev libxml2-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app source
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy built Vite assets
COPY --from=nodebuilder /app/public/build ./public/build

# Optimize Laravel
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

CMD php artisan serve --host=0.0.0.0 --port=${PORT}