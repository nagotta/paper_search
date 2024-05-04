FROM php:8.1.4-fpm-alpine

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY php/settings/php.ini /usr/local/etc/php/conf.d/php.ini
COPY php/settings/php-fpm.d/zz-www.conf /usr/local/etc/php-fpm.d/zz-www.conf
COPY src /usr/share/nginx/html 
COPY php/src /usr/share/python
#RUN apt-get update
RUN apk add --update
#RUN apt install -y docker.io docker-compose
RUN apk add docker docker-compose
RUN apk add sudo
RUN  delgroup docker
RUN addgroup -g 1001 docker
RUN adduser www-data docker
