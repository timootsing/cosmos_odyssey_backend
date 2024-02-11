FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libxslt-dev \
    libzip-dev \
    zip \
    git \
    g++ \
    curl \
    bash \
    wget \
    libpng-dev

RUN docker-php-ext-install pdo pdo_mysql zip gd

RUN wget https://getcomposer.org/installer && \
    php installer --version=2.1.3 --install-dir=/usr/local/bin/ --filename=composer && \
    rm installer

RUN apt-get update && \
    apt-get install -y unzip

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

WORKDIR /var/www

COPY composer.json .

ARG COMPOSER_TOKEN

RUN composer self-update && composer install --no-scripts --no-interaction

RUN composer clearcache

COPY . .

WORKDIR /var/www/

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
