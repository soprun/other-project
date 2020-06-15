FROM php:7.4-fpm AS build

### Set environment variables
ENV APP_ENV=build
ENV COMPOSER_ALLOW_SUPERUSER=1

## Installation system packages
RUN apt-get update && apt-get install -y \
  git \
  zip \
  unzip

### Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy source files to workdir
COPY . /usr/src/app

# change working directory
WORKDIR /usr/src/app

# expose port outside
EXPOSE 9000

# set entrypoint
# COPY /docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
# RUN chmod +x /usr/local/bin/docker-entrypoint
# ENTRYPOINT ["docker-entrypoint"]

# run application
CMD ["php-fpm", "--nodaemonize"]

### Build: Development
FROM build AS dev

### Set environment variables
ENV APP_ENV=dev

RUN pecl install xdebug-2.8.1 \
  && docker-php-ext-enable xdebug

### Install application dependencies
RUN set -xe \
  && composer install --no-interaction --no-progress --optimize-autoloader --ansi

#### Build: Production
#FROM build AS prod
#
#### Set environment variables
#ENV APP_ENV=prod
#
#### Use the default production configuration
#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
#
### Remove dev dependencies
#RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader --ansi --ignore-platform-reqs
