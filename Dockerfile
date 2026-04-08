# --- ETAPA 1: COMPILACIÓN ---
FROM node:22-alpine AS build-stage

# Instalamos PHP con TODO lo necesario para XML/DOM
RUN apk add --no-cache \
    php83 \
    php83-common \
    php83-composer \
    php83-dom \
    php83-xml \
    php83-xmlreader \
    php83-xmlwriter \
    php83-simplexml \
    php83-phar \
    php83-mbstring \
    php83-tokenizer \
    php83-ctype \
    php83-session

# Truco para asegurar que 'php' apunte a 'php83' en Alpine
RUN ln -sf /usr/bin/php83 /usr/bin/php

WORKDIR /app
COPY . .

# 1. Instalar dependencias de PHP (necesario para Ziggy)
# Usamos --no-scripts primero para evitar que falle el discover antes de tener las extensiones
RUN composer install --no-dev --ignore-platform-reqs --no-scripts
RUN php artisan package:discover --ansi

# 2. Generar archivo de Ziggy
RUN php artisan ziggy:generate

# 3. Instalar JS y Compilar
RUN npm install
RUN npm run build

# --- ETAPA 2: SERVIDOR FINAL ---
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html
COPY . .

COPY --from=build-stage /app/vendor ./vendor
COPY --from=build-stage /app/public/build ./public/build

ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

EXPOSE 80
