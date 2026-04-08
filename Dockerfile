FROM richarvey/nginx-php-fpm:latest

# 1. Instalar Node.js y NPM (necesarios para Vue/Inertia)
RUN apk add --update nodejs npm

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

# 5. Instalar dependencias de JS y compilar assets con Vite
RUN npm install
RUN npm run build

EXPOSE 80
