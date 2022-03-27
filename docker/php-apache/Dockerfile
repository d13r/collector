FROM php:8.1-apache

# Update the paths
RUN sed -i 's!/var/www/html!/app/www!g' /etc/apache2/sites-available/*.conf && \
    sed -i 's!/var/www/!/app/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /app

# Install dependencies
RUN apt-get update -y && \
    apt-get install -y \
        zip

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Enable Apache modules
RUN a2enmod \
    headers \
    rewrite

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configure PHP
COPY php.ini $PHP_INI_DIR/conf.d/custom.ini
COPY debug-off.ini $PHP_INI_DIR/debug-off.ini
COPY debug-on.ini $PHP_INI_DIR/debug-on.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
