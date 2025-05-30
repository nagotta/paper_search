FROM nginx:1.25.0
COPY web/nginx/settings/nginx.conf /etc/nginx/nginx.conf
COPY web/src /usr/share/nginx/html

COPY web/nginx/settings/default.conf /etc/nginx/conf.d/default.conf

RUN apt-get update
RUN apt install -y docker.io docker-compose
RUN apt install -y vim
RUN usermod -u 82 www-data \
    && usermod -aG docker www-data \
    && echo "www-data ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers \
    && echo 'www-data:www-data' | chpasswd
