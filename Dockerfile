FROM php:8.1-apache
RUN docker-php-ext-install mysqli
RUN apt-get update -y && apt-get install libyaml-dev -y
RUN  pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml