FROM php:5.6-fpm

# Basic packages
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt-get update \
    && apt-get install -y \
        git \
        wget \
        nodejs \
        zip \
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

# Install xdebug
RUN pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Aliases
RUN echo 'alias sf="php app/console"' >> ~/.bashrc

# Define www-data user + workdir
RUN usermod -u 1000 www-data
WORKDIR /var/www
