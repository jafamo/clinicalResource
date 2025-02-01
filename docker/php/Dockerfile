# Declarar el argumento PHP_VERSION
ARG PHP_VERSION=8.4

# Utilizar la imagen base de PHP FPM
FROM php:${PHP_VERSION}-fpm

# Actualizar y agregar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    unzip \
    git \
    nano \
    make \
    curl \
    ibicu-dev \
    && docker-php-ext-install zip pdo pdo_mysql gd intl

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Crear el directorio de trabajo
WORKDIR /var/www/clinicalResource