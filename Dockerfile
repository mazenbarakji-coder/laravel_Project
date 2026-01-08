FROM php:8.2-cli-alpine

RUN apk add --no-cache \
    git curl \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    oniguruma-dev icu-dev libzip-dev mariadb-client \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip intl mysqli pdo_mysql mbstring bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && php artisan key:generate --force || true \
    && php artisan config:clear

EXPOSE 8080

ENTRYPOINT ["sh","-c","php artisan serve --host=0.0.0.0 --port=$PORT"]