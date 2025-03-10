FROM php:8.3.17-apache

RUN apt-get update && apt-get upgrade -y \
    curl \
    unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80