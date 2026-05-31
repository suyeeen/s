FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip libsqlite3-dev sqlite3 \
    python3 python3-pip python3-venv \
    nodejs npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install Python dependencies dulu sebelum COPY project
# Biar ter-cache dan tidak download ulang setiap build
RUN python3 -m venv /var/www/python/venv
RUN /var/www/python/venv/bin/pip install --upgrade pip && \
  /var/www/python/venv/bin/pip install --no-cache-dir numpy scikit-learn pandas

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN npm install && npm run build

RUN mkdir -p database && touch database/database.sqlite

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
RUN chmod 664 /var/www/database/database.sqlite
USER www-data

EXPOSE 9000
CMD ["php-fpm"]