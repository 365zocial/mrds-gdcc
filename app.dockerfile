FROM php:7.2-fpm-alpine3.7

RUN apk add libpng-dev
RUN docker-php-ext-install mysqli gd pdo_mysql mbstring