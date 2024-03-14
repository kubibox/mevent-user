FROM php:8.3.3-fpm

RUN apt-get update && \
    apt-get install -y \
        libicu-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        default-mysql-client && \
    docker-php-ext-install pdo_mysql intl zip

WORKDIR /var/www

# End test
ARG XDEBUG_MODES="debug"
ARG REMOTE_HOST="host.docker.internal"
ARG REMOTE_PORT=9003
#
ENV MODES=$XDEBUG_MODES
ENV CLIENT_HOST=$REMOTE_HOST
ENV CLIENT_PORT=$REMOTE_PORT

# Xdebuge
ADD etc/php/extensions/xdebug.sh /root/install-xdebug.sh
RUN sh /root/install-xdebug.sh

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash -s - --install-dir /usr/local/bin

#RUN cd /var/www && composer install

EXPOSE 8040 80

# allow non-root users have home
RUN mkdir -p /var/www
RUN chmod 777 -R /var/www

# Set budget as home dir
ENV HOME /var/www
