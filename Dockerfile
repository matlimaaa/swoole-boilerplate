FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git zip unzip curl wget libssl-dev pkg-config libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Instala Swoole
RUN pecl install swoole \
    && docker-php-ext-enable swoole

WORKDIR /var/www
