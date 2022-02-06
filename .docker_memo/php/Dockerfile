FROM php:7.4-fpm
COPY php.ini /usr/local/etc/php/
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
   zlib1g-dev \
   git \
   libzip* \
   libonig-dev \
   libc-client-dev \
   libkrb5-dev \
   vim && \
   rm -r /var/lib/apt/lists/* && \
   PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
   docker-php-ext-install zip pdo_mysql mysqli mbstring imap

