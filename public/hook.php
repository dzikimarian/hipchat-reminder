<?php

$txt = $_SERVER['REQUEST_URI'] . PHP_EOL . $RAW_POST_DATA;
$myfile = file_put_contents('logs.txt', $txt.PHP_EOL , FILE_APPEND);