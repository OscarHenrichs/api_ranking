FROM php:8.2-apache


RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip


# Enable Apache rewrite module
RUN a2enmod rewrite


RUN echo '#!/bin/bash\n\
    if [ ! -d "/var/www/html/.git" ]; then\n\
    if [ -z "$GIT_REPO" ]; then\n\
    echo "No GIT_REPO environment variable set"\n\
    else\n\
    echo "Cloning repository $GIT_REPO"\n\
    rm -rf /var/www/html/*\n\
    git clone --branch ${GIT_BRANCH:-main} $GIT_REPO /var/www/html\n\
    chown -R www-data:www-data /var/www/html\n\
    fi\n\
    else\n\
    echo "Repository already exists, skipping clone"\n\
    fi\n\
    exec apache2-foreground' > /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

ENTRYPOINT ["/usr/local/bin/startup.sh"]

# Copy your application files
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80