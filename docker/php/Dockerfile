FROM ubuntu:latest
LABEL authors="benpi"

ENTRYPOINT ["top", "-b"]

# 1) Base PHP with needed extensions
FROM php:8.3-fpm

# 2) System deps (git, unzip for Composer, node for Vite build/dev)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql zip

# 3) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4) Custom php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# 5) Workdir
WORKDIR /var/www/html

# 6) Expose PHP-FPM port
EXPOSE 9000

# 7) Default command = php-fpm
CMD ["php-fpm"]
