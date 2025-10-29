FROM php:8.3-fpm

# systémové balíky
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && docker-php-ext-install pdo_mysql zip

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# entrypoint
COPY entrypoint.sh /usr/local/bin/app-entrypoint.sh
RUN chmod +x /usr/local/bin/app-entrypoint.sh

WORKDIR /var/www/html

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/app-entrypoint.sh"]
