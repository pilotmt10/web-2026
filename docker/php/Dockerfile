FROM php:8.4-fpm

# System dependencies for building PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libpq-dev \
        libzip-dev \
        libicu-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        bcmath \
        intl \
        gd \
        zip \
        pcntl \
        sockets \
        opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get purge -y --auto-remove \
    && rm -rf /var/lib/apt/lists/* /tmp/pear

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Writable HOME dirs for psysh/tinker (www-data)
RUN mkdir -p /var/www/.config /var/www/.local/share \
    && chown -R www-data:www-data /var/www/.config /var/www/.local/share

# PHP configuration (dev-friendly)
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini

WORKDIR /var/www/html

USER www-data
