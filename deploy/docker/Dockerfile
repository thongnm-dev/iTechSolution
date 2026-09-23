# syntax=docker/dockerfile:1

############################################
# Stage 1: Build frontend (Vue 3 + Vite)
############################################
FROM node:22-alpine AS frontend-build
ARG VITE_API_URL=/api
ENV VITE_API_URL=$VITE_API_URL
WORKDIR /app
COPY iTechSolution-frontend/package.json iTechSolution-frontend/package-lock.json ./
RUN npm ci
COPY iTechSolution-frontend/ .
RUN npm run build

############################################
# Stage 2: Install backend deps (Composer)
############################################
FROM php:8.4-cli-alpine AS backend-deps
RUN apk add --no-cache git unzip libzip-dev icu-dev oniguruma-dev \
    && docker-php-ext-install intl mbstring zip
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY iTechSolution-backend/composer.json iTechSolution-backend/composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs
COPY iTechSolution-backend/ .
RUN composer dump-autoload --optimize --no-dev --no-scripts

############################################
# Stage 3: Runtime image (Nginx + PHP-FPM)
############################################
FROM php:8.4-fpm-alpine AS app

RUN apk add --no-cache \
        nginx \
        supervisor \
        libpng-dev \
        libzip-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        icu-dev \
        oniguruma-dev \
        postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        mbstring \
        bcmath \
        exif \
        gd \
        zip \
        intl \
        opcache \
        pcntl \
    && sed -i 's/^user .*/user www-data;/' /etc/nginx/nginx.conf \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

COPY --from=backend-deps /app ./
COPY --from=frontend-build /app/dist/ ./public/

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY deploy/docker/server/nginx.conf /etc/nginx/http.d/default.conf
COPY deploy/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY deploy/docker/php/custom.ini /usr/local/etc/php/conf.d/zz-custom.ini
COPY deploy/docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
