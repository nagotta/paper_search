<?php

// メタデータ抽出のPythonスクリプトを実行する関数のInclude
include('execute_python_script.php');

// アップロード先のディレクトリを指定します
$uploadDirectory = '/tmp/';

// レスポンスデータの初期化
$responseData = array();

// ディレクトリ名に使うタイムスタンプ
$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];

// POST リクエストがあるかどうかを確認します
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    // アップロードされたファイルの数を取得します
    $fileCount = count($_FILES['files']['name']);

    // 各ファイルについて処理を行います
    for ($i = 0; $i < $fileCount; $i++) {
        $tempFilePath = $_FILES['files']['tmp_name'][$i];
        $fileName = $_FILES['files']['name'][$i];
        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
        
        // アップロードするディレクトリのパスを生成
        $directoryPath = $uploadDirectory . $timestamp . '/' . $fileNameWithoutExtension;
        // ディレクトリを作成
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }
	
	    // ファイルがアップロードされたことを確認し、指定したディレクトリに移動します
        if (!empty($tempFilePath) && move_uploaded_file($tempFilePath, $filePath = $directoryPath . '/' . $fileName)) {
            $metadatas =  execute_python_script($directoryPath . '/' . $fileName);
            // $metadataInfo = array();
            // 各メタデータをループして処理
            // foreach ($metadatas as $metadata) {
            //     // メタデータを文字列に連結して配列に追加
            //     $metadataInfo[] = implode("\n", $metadata);
            // }
            // アップロード成功時のレスポンスを追加
            $responseData[] = array(
                'success' => true,
                'message' => "File {$fileName} has been uploaded successfully.",
                'title' => $metadatas[0],
                'reference' => $metadatas[1],
                'png_num' => $metadatas[2]
		// 'test' => "{$metadatas[0]}"
            );
	    // print_r($metadatas);
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
