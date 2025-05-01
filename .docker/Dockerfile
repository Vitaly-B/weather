FROM php:8.3.8-fpm-alpine as base

RUN apk --no-cache add \
    libtool \
    autoconf \
    gcc \
    g++ \
    make \
    && apk del libtool autoconf gcc g++ make

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG env
ENV APP_ENV="${env}"

COPY ./ /var/www
WORKDIR /var/www

FROM base as base-php-fpm

COPY ./${APP_ENV}/*.ini /usr/local/etc/php/conf.d/
COPY ./${APP_ENV}/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./${APP_ENV}/php-fpm.conf /usr/local/etc/php-fpm.conf

FROM base-php-fpm as base-with-dev-dependencies

FROM base-with-dev-dependencies as dev
RUN apk --no-cache --update add autoconf gcc g++ make pkgconfig musl-dev linux-headers
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Установка Node.js и Yarn
RUN apk add --no-cache nodejs npm \
    && npm install -g yarn

EXPOSE 9000
CMD ["php-fpm"]
