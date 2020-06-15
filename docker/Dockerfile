# FROM php:7.4-fpm-alpine
FROM php:7.4-fpm AS prepare

### Installation system packages
RUN apt-get update && apt-get install -y \
  git \
  bash \
  zip \
  unzip

RUN pecl install xdebug-2.8.1 \
  && docker-php-ext-enable xdebug

# Install composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

### Configuration
# Use the default production configuration
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

### Install entrypoint
COPY /docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT ["docker-entrypoint"]

CMD ["php-fpm", "--nodaemonize"]

FROM prepare AS build

# Copy source files to workdir
COPY . /usr/src/app

# Change working directory
WORKDIR /usr/src/app

### Install application dependencies
RUN set -xe \
  && composer install --no-interaction --optimize-autoloader --ansi


FROM php:7.4-fpm AS production

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"