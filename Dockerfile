# ============================================================
# Stage 1: Node — Build Vite assets
# ============================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# 1. MODIFIKASI: Blokir unduhan Cypress agar memori VPS tidak penuh (ENOSPC)
ENV CYPRESS_INSTALL_BINARY=0

COPY package.json package-lock.json* ./

# 2. MODIFIKASI: Gunakan npm ci dengan flag --no-audit agar lebih cepat
RUN npm ci --no-audit --no-fund

COPY . .
RUN npm run build

# ============================================================
# Stage 2: Python deps — Pre-build venv
# ============================================================
FROM python:3.11-slim AS python-builder

WORKDIR /venv

RUN python3 -m venv /venv
RUN /venv/bin/pip install --upgrade pip --no-cache-dir && \
    /venv/bin/pip install --no-cache-dir \
        "jaraco.context>=6.1.0" \
        "wheel>=0.46.2" \
        numpy \
        scikit-learn \
        pandas

# ============================================================
# Stage 3: PHP — Final production image
# ============================================================
FROM php:8.3-fpm

# System dependencies PHP
RUN apt-get update && apt-get install -y \
    git curl \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip \
    libsqlite3-dev sqlite3 \
    python3 \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo pdo_sqlite pdo_mysql \
    mbstring exif pcntl bcmath gd zip

# Composer dari official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Python venv dari stage python-builder
COPY --from=python-builder /venv /var/www/python/venv

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --no-dev

COPY . .

RUN composer dump-autoload --optimize

# Copy hasil Vite build dari stage node-builder
COPY --from=node-builder /app/public/build ./public/build

# Setup SQLite database file
RUN mkdir -p database && touch database/database.sqlite

# 3. MODIFIKASI: Tambahkan public/build ke dalam aturan chown & chmod 
# agar NGINX tidak memunculkan error 403 Forbidden saat membaca file statis
RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache \
        /var/www/database \
        /var/www/public/build && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/build && \
    chmod 664 /var/www/database/database.sqlite

USER www-data

EXPOSE 9000
CMD ["php-fpm"]