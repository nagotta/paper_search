<?php

function execute_python_script($pdfFilePath){

    // 実行するPythonスクリプトのファイル名を指定
    $scriptNames = array("title.py", "references.py", "image.py");

    // 実行結果を格納する配列を初期化
    $responses = array();

    // $scriptNames 配列の各要素に対してループ処理を行う
    foreach ($scriptNames as $scriptName) {
        // Dockerコマンドの生成
	$command = "docker exec python3 python3 {$scriptName} {$pdfFilePath}";
        // コマンドを実行し、結果を $responses 配列に追加
        exec($command, $response);
	$response = implode($response);
        // echo "{$command} : {$response}\n";
	$responses[] = $response;
    }

    // 実行結果の配列を返す
    return $responses;
}

?>
