FROM php:8.2-apache

RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y \
    git \
    libzip-dev \
    zip \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

COPY . /var/www/html/
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

ENTRYPOINT ["/bin/sh", "/usr/local/bin/startup.sh"]

EXPOSE 80