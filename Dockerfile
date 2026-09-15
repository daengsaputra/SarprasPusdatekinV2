FROM php:8.3-apache

RUN a2enmod rewrite vhost_alias headers

RUN apt-get update \
    && apt-get install -y \
        curl \
        git \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        nano \
        procps \
        unzip \
        vim \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        curl \
        exif \
        fileinfo \
        gd \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN git config --global --add safe.directory /var/www/html

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction || true

EXPOSE 80