FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev \
    libxml2-dev libzip-dev zip unzip \
    sqlite3 libsqlite3-dev

RUN docker-php-ext-install \
    pdo pdo_mysql pdo_sqlite \
    mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

RUN composer install --optimize-autoloader --no-dev --no-interaction

COPY --chown=www-data:www-data . /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN cp .env.example .env \
    && php artisan key:generate \
    && touch /var/www/database/database.sqlite \
    && php artisan migrate --force

EXPOSE 9000
CMD ["php-fpm"]
