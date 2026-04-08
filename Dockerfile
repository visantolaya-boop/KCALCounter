# ETAPA 1: Compilar assets con Node 22
FROM node:22-alpine AS build-stage
WORKDIR /app
COPY . .
# Instalamos dependencias y compilamos
RUN npm install
# Nota: Si necesitas Ziggy aquí, lo generaremos en la etapa 2 o lo ignoramos si ya tienes el JS
RUN npm run build

# ETAPA 2: Servidor PHP
FROM richarvey/nginx-php-fpm:latest
WORKDIR /var/www/html

# Copiamos todo el proyecto
COPY . .

# Copiamos los archivos YA COMPILADOS desde la etapa de Node
COPY --from=build-stage /app/public/build ./public/build

# Configuraciones de Render
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

# Instalamos dependencias de PHP y generamos Ziggy por si acaso
RUN composer install --no-dev
RUN php artisan ziggy:generate

EXPOSE 80
