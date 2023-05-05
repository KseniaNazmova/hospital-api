FROM php:8.1-apache

RUN apt update && apt install -y \
    g++ \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    zlib1g-dev \
&& docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql

# xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Enable required Apache modules
RUN a2enmod rewrite headers

WORKDIR /var/www/src

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 80
EXPOSE 80