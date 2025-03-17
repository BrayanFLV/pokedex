# Usa PHP 8.0 en el contenedor
FROM php:8.0-cli

# Define el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instala dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && \
    apt-get install -y unzip libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Copia los archivos del backend al contenedor
COPY . .

# Instala Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependencias de PHP (Slim, Guzzle, etc.)
RUN composer install --no-dev --optimize-autoloader

# Comando para ejecutar el servidor PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
