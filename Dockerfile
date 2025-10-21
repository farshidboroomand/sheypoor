FROM php:8.2-fpm

# Install PHP extensions
RUN apt-get update && \
    apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        zip \
        unzip \
        git

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install opcache \
    && docker-php-ext-install zip \
    && docker-php-ext-install exif

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN apt-get update && apt-get -y install sqlite3
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /app
WORKDIR /app

RUN composer install
RUN composer dump-autoload

ENV APP_URL=http://localhost

ENV APP_ENV=local

ENV PHP_CS_FIXER_IGNORE_ENV=1