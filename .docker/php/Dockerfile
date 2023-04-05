FROM php:8.1.0-fpm

RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxml2-dev \
    libpng-dev \
    libwebp-dev \
    zip \
    unzip \
    libzip-dev \
    git \
    curl \
    default-mysql-client \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data
