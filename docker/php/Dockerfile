FROM php:5.6-apache
RUN echo "deb http://archive.debian.org/debian stretch main" > /etc/apt/sources.list
RUN a2enmod rewrite
RUN docker-php-ext-install mysql
RUN apt-get update && apt-get install -y imagemagick

