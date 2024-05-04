#/bin/sh
docker compose down
docker volume rm web_php-fpm-sock
docker rmi $(docker images -q)
