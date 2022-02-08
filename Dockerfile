FROM php:7.4-fpm

RUN apt-get update -y && apt-get install -y \
    libonig-dev \
    openssl \
    libpq-dev \
    zip \
    libmcrypt-dev \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpq-dev \
    libzip-dev  \
    libicu-dev  \
    libpng-dev \
    libaio1 \
    && docker-php-ext-install -j$(nproc) pdo iconv mysqli pdo_mysql zip pdo_pgsql pgsql sockets gd opcache\
    && docker-php-ext-install  mbstring \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && apt install -y libmagickwand-dev --no-install-recommends \
    && pecl install imagick && docker-php-ext-enable imagick \
    && pecl install grpc && docker-php-ext-enable grpc



RUN apt-get install supervisor -y

RUN apt-get install -y nginx  && \
    rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html
WORKDIR /var/www/html

RUN chmod +rx /usr/local/bin/composer

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# update memory limit
RUN echo 'memory_limit = -1' >> "$PHP_INI_DIR/conf.d/docker-php-ram-limit.ini"

# run in verbose biar keliatan progressnya
RUN composer update -vvv

#RUN rm /etc/nginx/sites-enabled/default

COPY docker/deploy.conf /etc/nginx/conf.d/default.conf

RUN mv /usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf.backup
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

COPY .env.dev /var/www/html/.env

RUN usermod -a -G www-data root
RUN chgrp -R www-data storage

RUN chown -R www-data:www-data ./storage
RUN chmod -R 777 ./storage
RUN chmod -R 777 bootstrap/cache

# RUN php artisan cache:clear
# RUN php artisan config:clear
# RUN php artisan route:clear
# RUN php artisan view:clear
# RUN php artisan route:cache
# RUN php artisan config:cache
# # RUN ln -s ./secret/.env .env

RUN chmod +x ./docker/run

ENTRYPOINT ["bash", "docker/run"]

EXPOSE 8188