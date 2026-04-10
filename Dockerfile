FROM php:8.2-cli

WORKDIR /app

# system dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev default-mysql-client

# PHP extensions (IMPORTANT FIX)
RUN docker-php-ext-install pdo pdo_mysql zip

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# install dependencies
RUN composer install --no-dev --optimize-autoloader

# permissions fix
RUN chmod -R 777 storage bootstrap/cache

# expose port
EXPOSE 10000

# start server
CMD php artisan serve --host=0.0.0.0 --port=10000