FROM php:7.4-apache-buster


## Install PHP required dependencies

RUN set -eux \
  && mkdir -p /usr/share/man/man1 \
  && apt-get update \
  && apt-get install -y --no-install-recommends \
  acl \
  file \
  gettext \
  git \
  libicu-dev \
  libzip-dev  \
  libpq-dev \
  libxslt-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


## Configure PHP  dependencies

RUN set -eux; \
    docker-php-ext-configure zip; \
    docker-php-ext-install -j$(nproc) \
      intl \
      pgsql \
      pdo_pgsql \
      xsl \
      zip \
      && docker-php-ext-configure intl --enable-intl;

RUN pecl install timezonedb redis \
   && docker-php-ext-enable timezonedb  \
   && rm -rf /tmp/pear;


## Configure PHP

COPY docker/php/conf.d/000_php.ini $PHP_INI_DIR/conf.d/


RUN a2enmod expires headers rewrite status ssl proxy proxy_http deflate

COPY docker/entrypoint /usr/local/bin/docker-php-entrypoint
RUN chmod a+rx /usr/local/bin/docker-php-entrypoint

## Add apache configuration files

COPY docker/apache/apache.conf /etc/apache2/apache2.conf
COPY docker/apache/docker-php.conf /etc/apache2/conf-available/docker-php.conf
COPY docker/apache/vimeet365.conf /etc/apache2/sites-available/000-default.conf

## Configure OPCACHE
ARG DISABLE_OPCACHE="0"
ENV DISABLE_OPCACHE ${DISABLE_OPCACHE}
ARG VERSION=latest
ARG PHP_VARIANT=apache


# Timezone
RUN echo "UTC" > /etc/timezone


WORKDIR /var/www/vimeet365

# Create files required by symfony and by node

RUN mkdir -p ./var/cache  ./var/log ./vendor /var/www/.npm ./node_modules /var/www/.config  \
  && chown www-data ./var/cache  ./var/log  ./vendor /var/www/.npm ./node_modules /var/www/.config

## Copy only specifically what we need

## Symfony Specifics

COPY --chown=www-data:www-data .env ./
COPY --chown=www-data:www-data bin bin/
COPY --chown=www-data:www-data config config/
COPY --chown=www-data:www-data migrations migrations/
COPY --chown=www-data:www-data public public/
COPY --chown=www-data:www-data src src/
COPY --chown=www-data:www-data templates templates/

## Node Specifics

COPY --chown=www-data:www-data webpack.config.js ./
COPY --chown=www-data:www-data assets assets/

# Install and configure composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

#Install Node and NPM
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install nodejs -y --no-install-recommends


USER www-data
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"


## Install application dependencies
ENV APP_ENV=prod

# PHP Dependencies
COPY composer.json composer.lock symfony.lock ./
RUN set -eux; \
  composer install --prefer-dist --no-scripts --no-dev --no-progress; \
  composer clear-cache

# Node Depenencies
COPY package*.json ./
RUN  set -eux; \ 
  npm ci && npm run build

USER root
