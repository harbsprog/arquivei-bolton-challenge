FROM php:7.2-fpm

MAINTAINER João Pedro Harbs <harbsprog@gmail.com>

RUN apt-get update && apt-get install -y &&  apt-get install -y git
RUN apt-get install -y --no-install-recommends libbz2-dev zlib1g-dev && docker-php-ext-install zip bz2 pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./scheduler.sh /opt/bin/scheduler.sh
RUN chmod +x /opt/bin/scheduler.sh
