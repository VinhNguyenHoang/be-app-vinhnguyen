FROM php:8.0-fpm

COPY . /var/www/html

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions gd intl zip

RUN curl -sS https://getcomposer.org/installer | php \
&& mv composer.phar /usr/local/bin/composer