FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libsqlite3-dev sqlite3 \
    python3 python3-pip python3-venv \
    nodejs npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install Python dependencies untuk K-Means
RUN python3 -m venv /var/www/python/venv && \
    /var/www/python/venv/bin/pip install numpy scikit-learn pandas

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Buat SQLite database
RUN mkdir -p database && touch database/database.sqlite

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
RUN chmod 664 /var/www/database/database.sqlite

EXPOSE 9000
CMD ["php-fpm"]