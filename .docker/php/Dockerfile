FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libxml2 \
    zip \
    unzip \
    vim \
    tree

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

RUN usermod -u 1000 www-data

RUN echo "export PS1='\[\e[32m\]\u@\h:\w \$ \[\e[0m\]'" >> /etc/bash.bashrc \
    && echo "alias ll='ls -lah --color=auto'" >> /etc/bash.bashrc

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

USER www-data

EXPOSE 9000
