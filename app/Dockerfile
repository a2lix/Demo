ARG PHP_VERSION=7.3
ARG NODE_VERSION=12


#### Stage - PHP Common
FROM php:$PHP_VERSION-cli-alpine AS php_common

ARG APCU_VERSION=5.1.17
RUN set -eux \
      && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        postgresql-dev \
      && docker-php-ext-install -j$(nproc) \
        intl \
        pdo_pgsql \
      && pecl install apcu-${APCU_VERSION} \
      && pecl clear-cache \
      && docker-php-ext-enable \
        apcu \
        opcache \
      && runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
          | tr ',' '\n' \
          | sort -u \
          | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
      )" \
      && apk add --no-cache --virtual .api-phpexts-rundeps $runDeps \
      && apk del .build-deps

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
# RUN set -eux \
#     && composer global require "symfony/flex" --prefer-dist --no-progress --no-suggest --classmap-authoritative --no-interaction \
#     && composer clear-cache

WORKDIR /appdata


#### Stage - Development
FROM php_common AS dev

ARG XDEBUG_VERSION=2.7.2
RUN set -eux \
      && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
      && pecl install xdebug-$XDEBUG_VERSION \
      && docker-php-ext-enable xdebug \
      && apk del .build-deps

COPY docker/php/symfony_dev.ini $PHP_INI_DIR/conf.d/

COPY composer.* ./
RUN set -eux \
    && composer install --prefer-dist --no-scripts --no-progress --no-suggest --classmap-authoritative --no-interaction \
    && composer clear-cache

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/appdata/public"]


#### Stage - Testing
FROM php_common AS test


#### Stage - Production
FROM php_common AS prod

COPY docker/php/symfony_prod.ini $PHP_INI_DIR/conf.d/

COPY composer.* ./
RUN set -eux \
      && composer install --prefer-dist --no-scripts --no-progress --no-suggest --classmap-authoritative --no-interaction --no-dev \
      && composer clear-cache


#### Stage - Node
FROM node:$NODE_VERSION-alpine as node

WORKDIR /appdata

COPY package.json package-lock.json /appdata/
