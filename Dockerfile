FROM php:7.4-cli

# installation system packages
RUN apt-get update && apt-get install -y \
  git \
  bash \
  vim \
  curl \
  zip \
  unzip

# installation system packages
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

# use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer global require hirak/prestissimo --prefer-dist --no-plugins --no-scripts

# install dependencies
COPY composer.json composer.json
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer

# copy source files to workdir
COPY . /var/app

# change working directory
WORKDIR /var/app

ENV PATH="${PATH}:/var/app/bin"
ENV PATH="${PATH}:/var/app/vendor/bin"

# finish composer
RUN composer dump-autoload --no-scripts --no-dev --optimize

# expose port outside
EXPOSE 9000

# run application
# CMD ["php-fpm", "--nodaemonize"]
CMD ["php", "./bin/script.php"]
