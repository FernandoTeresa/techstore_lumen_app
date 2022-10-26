FROM php:7.4-fpm

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN \
    apt-get update && \
    apt-get -y --no-install-recommends install \
        libicu-dev \
        unzip \
        mc && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN \
    docker-php-ext-install \
        pdo_mysql \
        mysqli \
        intl
