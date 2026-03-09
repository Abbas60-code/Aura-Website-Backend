FROM php:8.2-cli

# MySQL ke liye zaroori libraries install karein
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /app
COPY . /app

# Composer install karein
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Pehle migrate karega, fir server start karega
CMD php artisan migrate:fresh --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}