<?php
// アップロード先のディレクトリを指定します
$uploadDirectory = '/tmp/';

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
            echo "File {$fileName} has been uploaded successfully.";
        } else {
            echo "Failed to upload file {$fileName}.";
        }
    }
} else {
    echo "No files have been uploaded.";
}
?>

