FROM php:8.1-fpm-buster

USER root

#Base install
RUN apt update && apt upgrade -y && apt-get install -y bash git&& \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl && \
    docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql && \
    pecl install xdebug

#Install php zip extension
RUN apt-get install -y libzip-dev zip && \
  docker-php-ext-install zip

#Install intl extension
RUN apt-get install -y libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl

#Let'd add user so we dont run into issues with permissions on Mac and Windows WSL
ARG DEV_UID
ARG DEV_GID
ENV DEV_UID=${DEV_UID}
ENV DEV_GID=${DEV_GID}

RUN addgroup --gid ${DEV_GID} dev
RUN adduser --uid ${DEV_UID} dev --gid ${DEV_GID}
