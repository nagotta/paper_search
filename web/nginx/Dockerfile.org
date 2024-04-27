# FROM nginx:1.21.6-alpine
FROM nginx:1.25.0
COPY nginx/settings/nginx.conf /etc/nginx/nginx.conf
COPY src /usr/share/nginx/html

COPY nginx/settings/default.conf /etc/nginx/conf.d/default.conf
