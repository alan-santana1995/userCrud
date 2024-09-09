FROM php:8.3.11-zts-alpine3.20

LABEL autor="Alan <alansantana1995@hotmail.com>"
LABEL description="Configura o serviço de PHP do projeto."

WORKDIR /var/www
COPY ./ /var/www
COPY .env.docker .env

RUN apk add --no-cache \
        composer \
        libxml2-dev \
        libzip-dev \
        php83-dom \
        php83-fileinfo \
        php83-session \
        php83-tokenizer \
        php83-xml \
        php83-xmlwriter && \
    docker-php-ext-install \
        pdo \
        zip \
        pdo_mysql \
        exif \
        pcntl && \
    docker-php-ext-configure zip && \
    composer install && \
    php artisan key:generate && \
    php artisan optimize

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000
