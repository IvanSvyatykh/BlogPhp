FROM php:8.3.4-fpm-bullseye

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    TZ="Asia/Yekaterinburg" \
    LANG="ru_RU.UTF-8"

# Установка базовых пакетов и локалей
RUN apt-get update && apt-get install -y --no-install-recommends \
    locales \
    git \
    wget \
    mc \
    nano \
    && echo "ru_RU.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка зависимостей для PHP расширений
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libffi-dev \
    libc-client-dev \
    libkrb5-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libzip-dev \
    zlib1g-dev \
    libonig-dev \
    libsodium-dev \
    libmemcached-dev \
    libicu-dev \
    libmagickwand-dev \
    build-essential \
    libtool \
    uuid-dev \
    automake \
    autotools-dev \
    libltdl-dev \
    libltdl7 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mysqli \
        pcntl \
        sockets \
        bcmath \
        iconv \
        ffi \
        imap \
        gd \
        zip \
        mbstring \
        opcache \
        sodium \
        intl \
        pdo_pgsql \
    && pecl install apcu memcached redis imagick \
    && docker-php-ext-enable apcu memcached redis imagick

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Настройка рабочей директории и пользователя
WORKDIR /var/www/
RUN chown -R www-data:www-data /var/www
USER www-data:www-data