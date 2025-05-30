<?php
/**
 * 機能：$vars_fileをincludeする
 * 引数：なし
 * 返り値：成功なら1, 失敗なら0でexit
 */
function include_vars() {
    $vars_file = "user_info.php";
    include($vars_file);

    if ($response != 1) {
        echo "エラー：${vars_file} の読み込みに失敗しました\n";
        echo "レスポンス：${response}";
        exit(0);
    } else {
        return 1;
    }
}

/**
 * 機能：$token_fileから$auth_tokenを読み込む
 * 引数：なし
 * 返り値：成功なら1, 失敗なら0でexit
 */
function include_auth_token($auth_token_file) {
    include($auth_token_file);
    
    if ($response != 1) {
        echo "エラー：${token_file} の読み込みに失敗しました\n";
        echo "レスポンス：${response}";
        exit(0);
    } else {
        return 1;
    }
}

/**
 * 機能：トークンを取得してtoken.phpに書き込む
 * 引数：なし
 * 返り値：成功なら取得した$auth_token, 失敗なら0
 */
function get_auth_token() {

    // 変数の読み込み
    $vars_file = "user_info.php";
    include($vars_file);
    
    // curlセッションの初期化
    $ch = curl_init();
    // URLの指定
    curl_setopt($ch, CURLOPT_URL, "${baseurl}/api/user/login");
    // HTTPリクエストの指定
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // POSTで通信するデータを設定
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username' => $username, 'password' => $password]));
    // 実行結果を文字列として取得
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);

    // curlを実行してレスポンスを変数に代入
    $response = curl_exec($ch);
    // 実行したcurlリクエストに関する詳細な情報を取得
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // curlセッションの終了
    curl_close($ch);

    if ($http_status == 200) {
        // curlリクエストが成功した場合
        // $token_fileに上書きしてreturn $auth_token
        preg_match("/^Set-Cookie:\s*([^;]*)/mi", $response, $matches);
        $auth_token = $matches[1];
        $auth_token = str_replace('=', '="', $auth_token) . '"';
        file_put_contents($auth_token_file, "<?php\n\$${auth_token};\n?>");
        return $auth_token;

    } else {
        // HTTPステータスが200以外の場合
        echo "エラー：認証トークンの取得に失敗しました\n";
        echo "HTTPステータスコード：${http_status}\n";
        return 0;
    }
}

/**
 * 機能：ドキュメントとファイルを一対一でアップロードする
 * 引数：
 *      $title：ドキュメントにつけるタイトル
 * オプション引数：
 *      $description：抽出した参考文献一覧
 *      $creationdate：
 *      $language：ドキュメントの言語, default='jpn'
 *      $newfiles：アップロードするファイル
 *      $tags
 * 返り値：成功なら1, 失敗ならexit(0)
 */
function put_item($putFilePath, $metadata){

    // 変数読み込み
    $vars_file = "user_info.php";
    include($vars_file);
    // ファイルから$auth_token変数の読み込み
    include($auth_token_file);

    // メタデータ
    $language='jpn';
    $title = $metadata[0];
    $reference = $metadata[1];

    // curlセッションの初期化
    $ch = curl_init();
    // URLの指定
    curl_setopt($ch, CURLOPT_URL, "${baseurl}/api/document");
    // HTTPリクエストの指定
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    // ドキュメントに付与するメタデータ
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['title' => $title, 'description' => $reference, 'language' => $language]));
    // 実行結果を文字列として取得
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // トークンの値を指定
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Cookie: auth_token={$auth_token}"]);
    
    // curlを実行してレスポンスを変数に代入
    $response = curl_exec($ch);
    // 実行したcurlリクエストに関する詳細な情報を取得
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // curlセッションの終了
    curl_close($ch);

    // HTTPステータスコードの確認
    if ($http_status !== 200) {
        echo "エラー：ドキュメントのPUTに失敗しました。HTTPステータスコード：{$http_status}\n";
        exit(0);
    } else {
        echo "成功：HTTPステータスコードは {$http_status} です\n";
    }

    preg_match('/"id":"([^"]+)"/', $response, $matches);
    $document_id = $matches[1] ?? "";
    // ドキュメントにファイルをPUT（ファイルのみ、ディレクトリは対象外）
    // curlセッションの初期化
    $ch = curl_init();
    // URLの指定
    curl_setopt($ch, CURLOPT_URL, "${baseurl}/api/file");
    // HTTPリクエストの指定
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    // アップロードするファイルを指定
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['id' => $document_id, 'file' => new CURLFile("@" . $putFilePath)]);
    // 実行結果を文字列として取得
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // トークンの値を指定
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Cookie: auth_token={$auth_token}"]);

    // curlを実行してレスポンスを変数に代入
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $max_retries = 10; // 最大再試行回数
    $retry_interval = 1; // 再試行間隔（秒）
    $retry_count = 0;

    while ($http_status === 100 && $retry_count < $max_retries) {
        sleep($retry_interval); // 1秒待機（必要に応じて調整）
        $retry_count++;
        // 再度HTTPステータスコードを取得
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    // curlセッションの終了
    curl_close($ch);

    // HTTPステータスコードの確認
    if ($http_status !== 200) {
        echo "エラー：${document_id}（document_id）へのファイルPUTに失敗しました\n";
        echo "HTTPステータスコード：${http_status}\n";
        exit(0);
    } else {
        echo "成功：HTTPステータスコードは {$http_status} です\n";
        return 1;
    }

    // ドキュメントの追加
    //$response = put_document();
    // 追加したドキュメントにファイルを追加
    //$response = put_file_to_document($response);
    //return $response;
}

?>