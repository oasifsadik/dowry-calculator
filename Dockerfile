FROM php:8.2-cli

WORKDIR /app

# system dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl zip libzip-dev

# PHP extensions
RUN docker-php-ext-install zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# install dependencies
RUN composer install --no-dev --optimize-autoloader

# create sqlite database file (IMPORTANT)
RUN mkdir -p database && touch database/database.sqlite

# fix permissions (VERY IMPORTANT)
RUN chmod -R 777 storage bootstrap/cache database

# optimize laravel (safe for production)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# expose port
EXPOSE 10000

# start server
CMD php -S 0.0.0.0:10000 -t public