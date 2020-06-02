FROM php:7.4-cli

COPY . /usr/src/app

# change working directory
WORKDIR /usr/src/app

CMD ["php", "./brackets.php"]
