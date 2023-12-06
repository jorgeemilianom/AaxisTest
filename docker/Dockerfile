# Imagen base de PHP con Apache
FROM php:7.4-apache-buster

# Instala las extensiones de PHP necesarias y otras herramientas
RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    libpq-dev

RUN docker-php-ext-install pgsql pdo pdo_pgsql zip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Configura el archivo de virtual host de Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Copia los archivos de tu proyecto de PHP al directorio del servidor web
COPY . /var/www/html


# Regresa al directorio del servidor web de PHP
WORKDIR /var/www/html

# Expone el puerto en el que se ejecutará la aplicación de PHP
EXPOSE 80

# Define el comando que se ejecutará cuando se inicie el contenedor
CMD ["apache2-foreground"]
