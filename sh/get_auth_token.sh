#!/bin/bash
#
# Teedyサーバーから認証トークンを取得し，auth_token.txtに保存するスクリプト
#

set -e  # コマンドが失敗した時点でスクリプトを終了

auth_token_file="../auth_token.txt"  # トークンを保存するファイルのパス

# 環境変数を読み込む
source "$(dirname "$0")/common.sh"
load_env

# Teedyから認証トークンを取得
response=$(curl -i -s -X POST -d "username=${TEEDYUSERNAME}" -d "password=${TEEDYPASSWORD}" "${TEEDYBASEURL}/api/user/login")

# HTTPステータスコードを取得
http_status=$(echo "$response" | head -n 1 | awk '{print $2}')

# リクエストの成否を確認
if [ -z "$http_status" ]; then  # 変数の要素が空の場合にTRUE
    echo "HTTPステータスコードが取得できませんでした" >&2  # 標準エラー出力
    exit 1
elif [ "$http_status" -eq 200 ]; then
    echo "リクエストは成功しました。HTTPステータスコード: $http_status"
    auth_token=$(echo "$response" | grep -i "^Set-Cookie:" | awk -F'[=;]' '{print $2}')
    # 認証トークンをファイル二書き込み
    echo "$auth_token" > $auth_token_file
    if [ -n "$auth_token" ]; then  # 変数の要素が空でない場合にTRUE
        echo "認証トークンが取得されました: $auth_token"
    else
        echo "認証トークンが取得できませんでした" >&2  # 標準エラー出力
        exit 1
    fi
else
    echo "リクエストが失敗しました。HTTPステータスコード: $http_status" >&2  # 標準エラー出力
    exit 1
fi
