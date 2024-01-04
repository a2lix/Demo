FROM dunglas/frankenphp:latest-alpine AS frankenphp_upstream
FROM composer/composer:2-bin AS composer_upstream

# Base FrankenPHP image
FROM frankenphp_upstream AS frankenphp_base

WORKDIR /app

# persistent / runtime deps
# hadolint ignore=DL3018
RUN apk add --no-cache \
        acl \
        file \
        gettext \
        git \
    ;

RUN set -eux; \
    install-php-extensions \
        apcu \
        intl \
        opcache \
        zip \
    ;

###> recipes ###
###> doctrine/doctrine-bundle ###
RUN set -eux; \
    install-php-extensions pdo_pgsql
###< doctrine/doctrine-bundle ###
###< recipes ###

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer_upstream --link /composer /usr/bin/composer
