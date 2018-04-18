<?php

include dirname(__FILE__) . '/vendor/autoload.php';

use App\ResizeImage;
use App\ResizeImageEvent;
use App\ResizeImageListener;
use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher();

$resizeListener = new ResizeImageListener();

$dispatcher->addListener(ResizeImageEvent::NAME, [$resizeListener, 'send']);

$result = new ResizeImage($argv[1], $argv[2], $argv[3], $dispatcher);
$result->resize();

echo PHP_EOL . PHP_EOL;