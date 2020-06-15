FROM php:7.4-fpm-alpine

# installation system packages
RUN apk add --no-cache $PHPIZE_DEPS git zip \
  && pecl install xdebug-2.9.0 \
  && docker-php-ext-enable xdebug

# use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer global require hirak/prestissimo --no-plugins --no-scripts

# install dependencies
# COPY composer.json composer.json
# RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer

# copy source files to workdir
COPY . /usr/src/app

# change working directory
WORKDIR /usr/src/app

ENV PATH="${PATH}:/usr/src/app/bin"
ENV PATH="${PATH}:/usr/src/app/vendor/bin"

# finish composer
# RUN composer dump-autoload --no-scripts --no-dev --optimize

# run application
CMD ["php-fpm", "--nodaemonize"]
