#!/bin/bash
#
# Teedyサーバーにアイテム（文書など）を登録するスクリプト
#

set -e  # コマンドが失敗した時点でスクリプトを終了

# 環境変数を読み込む
source "$(dirname "$0")/common.sh"
load_env

# PDFから抽出したメタデータ
title=""
#etc1
#etc2
#...
language=jpn

# ドキュメントをPUT（新規作成）
response=$(curl -i -X PUT -H "Cookie: auth_token=${auth_token}" -d "title=${title}&language=${language}" "${baseurl}/api/document")

# HTTPステータスコードを取得
http_status=$(echo "$response" | grep -i "HTTP/" | awk '{print $2}')

# HTTPステータスコードが200でない場合は1回だけ再試行
if [ "$http_status" -ne 200 ]; then
    auth_token=$(./get_auth_token.sh)
    response=$(curl -i -X PUT -H "Cookie: auth_token=${auth_token}" -d "title=${title}&language=${language}" "${TEEDYBASEURL}/api/document")
    # 再度HTTPステータスコードを確認
    http_status=$(echo "$response" | grep -i "HTTP/" | awk '{print $2}')
    if [ "$http_status" -ne 200 ]; then
        echo "エラー: ドキュメントのPUTに失敗しました。HTTPステータスコード: ${http_status}"
        exit 1
    fi
fi

# ドキュメントIDを抽出
document_id=$(echo "$response" | grep -o '"id":"[^"]*' | sed 's/"id":"//')

# ファイルをドキュメントにPUT（ファイルのみ、ディレクトリは対象外）
response=$(curl -i -X PUT -H "Cookie: auth_token=${auth_token}" -F "id=${document_id}" -F "file=@$1")

# HTTPステータスコードを再度確認
http_status=$(echo "$response" | grep -i "HTTP/" | awk '{print $2}')
if [ "$http_status" -ne 200 ]; then
    echo "エラー: ${document_id} への $1 のPUTに失敗しました"
fi

# ディレクトリの場合は再帰的に処理されます（未実装）