<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\ResizeImage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('imageresize', 'fanout', false, false, false);

list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$channel->queue_bind($queue_name, 'imageresize');

echo ' [*] Waiting for jobs. To exit press CTRL+C', "\n";

$callback = function($msg){
    echo " [-] Resize job detected!\n";
    $params = explode(' ', $msg->body);
    echo " [-] Resizing to " . $params[1] . " x " . $params[2] . "\n";
    $result = new ResizeImage($params[0], $params[1], $params[2]);

    echo " [x] Resulting image saved at img/modified/resized_" . $params[1] . "x" . $params[2] . "_" . $params[0] . "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {

    $channel->wait();
}

$channel->close();
$connection->close();