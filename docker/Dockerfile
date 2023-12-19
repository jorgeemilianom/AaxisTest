FROM php:7.4-fpm-buster

# Instala las extensiones de PHP necesarias y otras herramientas
RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    libpq-dev \
    nginx

RUN docker-php-ext-install pgsql pdo pdo_pgsql zip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"


COPY . /var/www/html

COPY nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/html

# Expone los puertos para Nginx y PHP-FPM
EXPOSE 80 9000

# comando para ejecutar Nginx y PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]
