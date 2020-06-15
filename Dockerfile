FROM php:7.4-cli AS app

# Copy project files to workdir
COPY . /usr/src/app

# Change working directory
WORKDIR /usr/src/app

# Install composer
# ENV COMPOSER_ALLOW_SUPERUSER=1
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install phpunit
# RUN curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
# RUN chmod +x /usr/local/bin/phpunit

CMD ["php", "./brackets.php"]
