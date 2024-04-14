FROM php:8.1.4-fpm-alpine

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY php/settings/php.ini /usr/local/etc/php/conf.d/php.ini
COPY src /usr/share/nginx/html
