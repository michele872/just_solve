FROM php:8.2-fpm

ARG CACHE_BUSTER=1
RUN echo "Cache buster backend: ${CACHE_BUSTER}"

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev netcat-openbsd nginx dos2unix \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif pcntl bcmath xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN dos2unix /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

COPY src/ .

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
