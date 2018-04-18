<?php

include dirname(__FILE__) . '/vendor/autoload.php';

use App\ResizeImage;

$result = new ResizeImage($argv[1], $argv[2], $argv[3]);
$result->resize();

echo PHP_EOL . PHP_EOL;