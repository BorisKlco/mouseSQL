FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libsqlite3-dev \
    curl \
	git \
	unzip \
	libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ./src .