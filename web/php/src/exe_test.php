<?php
include('execute_python_script.php');
$filePath = "/tmp/1714391827.1456/20T348-本体/20T348-本体.pdf";
$responses =  execute_python_script($filePath);
return $responses;
?>
