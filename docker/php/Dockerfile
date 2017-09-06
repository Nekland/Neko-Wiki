FROM php:5.6-fpm

# Basic packages
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt-get update \
    && apt-get install -y \
        git \
        wget \
        nodejs \
    && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -k -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && composer global require "hirak/prestissimo:^0.3"

# PHP packages + config
RUN curl -L -o /usr/local/bin/docker-php-pecl-install https://raw.githubusercontent.com/helderco/docker-php/master/template/bin/docker-php-pecl-install \
    && chmod +x /usr/local/bin/docker-php-pecl-install

RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# End docker config
USER www-data
WORKDIR /var/www
