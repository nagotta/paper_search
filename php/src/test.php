<?php

$command = "docker exec -it python3 python3 test.py";
exec($command, $response);

foreach ($response as $data) {
    echo $data . "\n";
};

