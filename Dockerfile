FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install mysqli

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite


RUN service apache2 restart