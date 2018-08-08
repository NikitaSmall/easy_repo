<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once './processor.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('setQueue', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) use ($channel) {
  echo ' [x] Received ', $msg->body, "\n";
  $processor = new Processor();
  $processor->process($msg->body);
};

$channel->basic_consume('setQueue', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
