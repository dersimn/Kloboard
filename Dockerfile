FROM php:fpm

RUN apt-get update && \
    docker-php-ext-install -j$(nproc) mysqli && \
    apt-get autoremove -y
