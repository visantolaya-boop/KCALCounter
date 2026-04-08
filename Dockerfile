FROM richarvey/nginx-php-fpm:latest

# 1. Instalar dependencias necesarias y Node.js 22
RUN apk add --update --no-cache nodejs npm

# 2. Copiar los archivos del proyecto
COPY . .

# 3. Configuraciones de entorno para Render
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

# 4. Instalar dependencias de PHP y generar rutas de Ziggy
RUN composer install --no-dev
RUN php artisan ziggy:generate

# 5. Instalar dependencias de JS y compilar con Vite
# Limpiamos caché de npm para evitar conflictos de versiones previas
RUN npm install
RUN npm run build

EXPOSE 80
