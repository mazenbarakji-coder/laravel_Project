# ==============================
# Stage 1: PHP base with extensions
# ==============================
FROM php:8.1-fpm-alpine AS base

RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    icu-dev \
    libzip-dev \
    mariadb-client \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        zip \
        intl \
        mysqli \
        pdo_mysql \
        opcache \
        mbstring \
        bcmath \
    && apk del .build-deps \
    && docker-php-ext-enable opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ==============================
# Stage 2: Build Laravel app
# ==============================
FROM base AS builder

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader

COPY . .

RUN php artisan config:clear \
    && php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true

# ==============================
# Stage 3: Production image
# ==============================
FROM php:8.1-fpm-alpine AS production

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl

WORKDIR /var/www/html

COPY --from=builder /var/www/html /var/www/html

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# PHP config
RUN echo "upload_max_filesize=200M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=200M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/uploads.ini

# PHP-FPM socket
RUN sed -i 's|127.0.0.1:9000|/var/run/php-fpm.sock|' /usr/local/etc/php-fpm.d/www.conf

# Nginx config
RUN printf 'server {\n\
    listen 80;\n\
    root /var/www/html/public;\n\
    index index.php;\n\
    location / { try_files $uri $uri/ /index.php?$query_string; }\n\
    location ~ \\.php$ {\n\
        fastcgi_pass unix:/var/run/php-fpm.sock;\n\
        fastcgi_index index.php;\n\
        include fastcgi_params;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
    }\n\
}' > /etc/nginx/http.d/default.conf

# Supervisor
RUN printf '[supervisord]\nnodaemon=true\n\n\
[program:php-fpm]\ncommand=php-fpm\n\n\
[program:nginx]\ncommand=nginx -g "daemon off;"\n' \
> /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]
