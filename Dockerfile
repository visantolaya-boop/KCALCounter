# --- ETAPA 1: COMPILACIÓN (Node + PHP para Ziggy) ---
FROM node:22-alpine AS build-stage

# Instalamos PHP y las extensiones mínimas necesarias (incluyendo DOM y XML)
RUN apk add --no-cache \
    php83 \
    php83-phar \
    php83-openssl \
    php83-mbstring \
    php83-tokenizer \
    php83-ctype \
    php83-xml \
    php83-simplexml \
    php83-dom \
    php83-xmlwriter \
    php83-session \
    composer

WORKDIR /app
COPY . .

# 1. Instalar dependencias de PHP (necesario para Ziggy)
RUN composer install --no-dev --ignore-platform-reqs

# 2. Generar archivo de Ziggy
RUN php artisan ziggy:generate

# 3. Instalar dependencias de JS y Compilar
RUN npm install
RUN npm run build

# --- ETAPA 2: SERVIDOR FINAL ---
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html
COPY . .

# Copiamos lo que compilamos arriba
COPY --from=build-stage /app/vendor ./vendor
COPY --from=build-stage /app/public/build ./public/build

ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

EXPOSE 80
