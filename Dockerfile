FROM richarvey/nginx-php-fpm:latest

# 1. Instalar Node.js 22 directamente desde los repositorios de Alpine
RUN apk add --no-cache nodejs npm

# 2. Copiar archivos del proyecto
COPY . .

# 3. Configuraciones de Render
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV SKIP_COMPOSER 1

# 4. Instalar dependencias de PHP (Esto crea la carpeta vendor)
RUN composer install --no-dev --optimize-autoloader

# 5. Generar el archivo de rutas de Ziggy (Esto crea el archivo que Vite no encontraba)
RUN php artisan ziggy:generate

# 6. Instalar JS y compilar (Ahora Vite sí encontrará a Ziggy)
RUN npm install
RUN npm run build

EXPOSE 80
