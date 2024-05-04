<?php
// アップロード先のディレクトリを指定します
$uploadDirectory = '/tmp/';

// レスポンスデータの初期化
$responseData = array();

// POST リクエストがあるかどうかを確認します
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    // アップロードされたファイルの数を取得します
    $fileCount = count($_FILES['files']['name']);

    // 各ファイルについて処理を行います
    for ($i = 0; $i < $fileCount; $i++) {
        $tempFilePath = $_FILES['files']['tmp_name'][$i];
        $fileName = $_FILES['files']['name'][$i];

        // ファイルがアップロードされたことを確認し、指定したディレクトリに移動します
        if (!empty($tempFilePath) && move_uploaded_file($tempFilePath, $uploadDirectory . $fileName)) {
            // アップロード成功時のレスポンスを追加
            $responseData[] = array(
                'success' => true,
                'message' => "File {$fileName} has been uploaded successfully."
            );
        } else {
            // アップロード失敗時のレスポンスを追加
            $responseData[] = array(
                'success' => false,
                'message' => "test Failed to upload file {$tempFilePath}. tempfilepath : {$tempFilePath}. updir:{$uploadDirectory}"
            );
            http_response_code(500);
        }
    }
} else {
    // ファイルがアップロードされなかった場合のレスポンスを追加
    $responseData[] = array(
        'success' => false,
        'message' => "No files have been uploaded."
    );
    http_response_code(500);
}

// JSON 形式でレスポンスデータを出力
header('Content-Type: application/json');
echo json_encode($responseData);
?>
