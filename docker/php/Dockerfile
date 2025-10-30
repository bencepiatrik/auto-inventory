FROM php:8.3-fpm

# systémové balíky + netcat na "wait-for-db"
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    netcat-openbsd \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# composer z oficiálneho image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ak máš vlastné nastavenia
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# náš entrypoint
COPY entrypoint.sh /usr/local/bin/app-entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/app-entrypoint.sh && chmod +x /usr/local/bin/app-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/app-entrypoint.sh"]
