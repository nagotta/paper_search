#/bin/sh
#
# Teedyサーバーを停止し、関連するDockerボリュームとイメージを削除するスクリプト
#

docker compose down
docker volume rm paper_search_php-fpm-sock paper_search_meta_data
docker rmi $(docker images -q)
