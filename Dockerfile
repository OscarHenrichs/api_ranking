FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

RUN a2enmod rewrite

COPY startup.sh /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

COPY . /var/www/html/

WORKDIR /var/www/html

ENTRYPOINT ["/bin/sh", "/usr/local/bin/startup.sh"]

EXPOSE 80