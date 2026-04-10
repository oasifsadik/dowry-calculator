FROM php:8.2-cli

WORKDIR /app

# system dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl zip libzip-dev

# PHP extensions (NO mysql)
RUN docker-php-ext-install zip

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

# run laravel
CMD php -S 0.0.0.0:10000 -t public