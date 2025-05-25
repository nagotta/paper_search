FROM php:8.1.4-fpm-alpine
RUN apk add --no-cache tzdata \
    && apk add --no-cache --virtual .locale-deps \
       gettext \
    && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && echo "Asia/Tokyo" > /etc/timezone \
    && apk del .locale-deps

# 日本語UTF-8環境の設定
ENV LANG=C.UTF-8 \
    LANGUAGE=C:ja \
    LC_ALL=C.UTF-8 \
    LC_CTYPE=C.UTF-8 \
    LC_NUMERIC=C.UTF-8 \
    LC_TIME=C.UTF-8 \
    LC_COLLATE=C.UTF-8 \
    LC_MONETARY=C.UTF-8 \
    LC_MESSAGES=C.UTF-8 \
    LC_PAPER=C.UTF-8 \
    LC_NAME=C.UTF-8 \
    LC_ADDRESS=C.UTF-8 \
    LC_TELEPHONE=C.UTF-8 \
    LC_MEASUREMENT=C.UTF-8 \
    LC_IDENTIFICATION=C.UTF-8 \
    LC_TIME=C.UTF-8

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY web/php/settings/php.ini /usr/local/etc/php/conf.d/php.ini
COPY web/php/settings/php-fpm.d/zz-www.conf /usr/local/etc/php-fpm.d/zz-www.conf
COPY web/src /usr/share/nginx/html 
COPY web/php/src /usr/share/python
#RUN apt-get update
RUN apk add --update
#RUN apt install -y docker.io docker-compose
RUN apk add docker docker-compose
RUN apk add sudo
RUN delgroup docker
RUN addgroup -g 1001 docker
RUN adduser www-data docker
