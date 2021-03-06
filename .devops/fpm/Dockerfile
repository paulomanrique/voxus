FROM php:7.4-fpm-alpine

ENV USE_OPCACHE=0

USER root

RUN rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN rm -f /etc/crontabs/root
RUN rm -rf /etc/supervisor.d

RUN apk add --update --no-cache --virtual \
    .build-deps git file re2c autoconf make g++ php7-dev zlib-dev pcre-dev vim postgresql-dev bash supervisor

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo pdo_mysql

RUN apk add --no-cache freetype libwebp-dev libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev && \
    docker-php-ext-configure gd \
        --with-freetype \
        --with-webp \
        --with-jpeg && \
    NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} gd && \
    apk del --no-cache freetype-dev libpng-dev libwebp libjpeg-turbo-dev


# install xdebug
RUN pecl install -f xdebug
RUN pecl install -f redis
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable redis
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY ./php.ini /usr/local/etc/php/php.ini

RUN echo '*  *  *  *  * /usr/local/bin/php  /var/www/html/artisan schedule:run >> /dev/null 2>&1' > /etc/crontabs/root && mkdir /etc/supervisor.d
ADD master.ini /etc/supervisor.d/

RUN deluser www-data
RUN addgroup -g 1000 -S www-data && adduser -S www-data -G www-data -u 1000

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["/usr/bin/supervisord"]
