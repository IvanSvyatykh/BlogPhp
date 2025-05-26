FROM php:8.3.4-fpm-bullseye

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    TZ="Asia/Yekaterinburg" \
    LANG="ru_RU.UTF-8"

# Обновляем списки пакетов и ставим базовые зависимости
RUN apt-get update && apt-get install -y \
    git wget mc nano \
    locales \
    libpq-dev zlib1g-dev libssl-dev \
    libpng-dev libfreetype6-dev libjpeg-dev libzip-dev \
    libonig-dev libsodium-dev libicu-dev \
    libmagickwand-dev libmemcached-dev \
    libc-client-dev libkrb5-dev \
    libffi-dev \
    && rm -rf /var/lib/apt/lists/*

# Настройка локали
RUN echo "ru_RU.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen

# Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mysqli pcntl sockets bcmath iconv \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip mbstring opcache sodium intl pdo_pgsql \
    && PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap ffi

# Установка PECL-расширений
RUN pecl install apcu && docker-php-ext-enable apcu \
    && pecl install memcached && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install imagick && docker-php-ext-enable imagick

# Очистка кеша
RUN apt-get clean && apt-get autoclean && apt-get autoremove

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER www-data:www-data
WORKDIR /var/www/
CMD ["php-fpm", "-R"]