FROM php:8.2-fpm

RUN apt-get update \
  && apt-get install -y default-mysql-client libzip-dev libicu-dev unzip git \
  && docker-php-ext-install pdo_mysql zip intl

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www