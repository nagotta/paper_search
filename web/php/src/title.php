<?php

// PDFのファイルパス
// 実装時は'/tmp'
// $pdf_file_path = './IPSJ-HPC13141009.pdf';

// PDFファイルの内容を読み込む
// $pdf_content = file_get_contents($pdf_file_path);

// 一時的なファイルを作成してPDFの内容を書き込む
// $temp_file_path = tempnam(sys_get_temp_dir(), 'pdf_');
// file_put_contents($temp_file_path, $pdf_content);

$command = "docker exec -it python3 python3 titile.py /shared/";
exec($command, $response);

foreach ($response as $data) {
    echo $data . "\n";
};


