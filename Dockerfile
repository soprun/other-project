FROM php:7.4-fpm

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

# Copy project files to workdir
COPY . /usr/src/app

# Change working directory
WORKDIR /usr/src/app

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]
