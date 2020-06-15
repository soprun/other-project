FROM php:7.4-fpm

## Installation system packages
RUN apt-get update && apt-get install -y \
  git \
  curl \
  zip \
  unzip

# installation system packages
# RUN pecl install xdebug-2.9.6 \
#  && docker-php-ext-enable xdebug

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

# use the default production configuration
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer global require hirak/prestissimo --prefer-dist --no-plugins --no-scripts

# install dependencies
# COPY composer.json composer.json
# RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer

# copy source files to workdir
COPY . /usr/src/app

# change working directory
WORKDIR /usr/src/app

ENV PATH="${PATH}:/usr/src/app/bin"
ENV PATH="${PATH}:/usr/src/app/vendor/bin"
ENV XDEBUG_CONFIG="remote_host=host.docker.internal remote_enable=1"

# finish composer
# RUN composer dump-autoload --no-scripts --no-dev --optimize

# expose port outside
EXPOSE 9000

# run application
CMD ["php-fpm", "--nodaemonize"]
