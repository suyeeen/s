FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev libsqlite3-dev sqlite3 \
    python3 python3-pip python3-venv \
    nodejs npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN python3 -m venv /var/www/python/venv && \
    /var/www/python/venv/bin/pip install numpy scikit-learn pandas

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN mkdir -p database && touch database/database.sqlite

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
RUN chmod 664 /var/www/database/database.sqlite

EXPOSE 9000
CMD ["php-fpm"]