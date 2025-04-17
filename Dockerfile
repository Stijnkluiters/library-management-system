FROM php:8.3-fpm-alpine

ARG user
ARG uid

RUN apk update && apk add \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    shadow  # Add shadow package to install useradd

RUN docker-php-ext-install pdo pdo_mysql \
    && apk --no-cache add nodejs npm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

# Install Xdebug
RUN apk add --no-cache --update linux-headers $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del $PHPIZE_DEPS

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www
USER $user
