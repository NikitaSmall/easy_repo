<?php

namespace App\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Queue
{
  public function __construct($queueName)
  {
    $this->connection = new AMQPStreamConnection(
      env('RMQ_HOST'),
      intval(env('RMQ_PORT')),
      env('RMQ_USER'),
      env('RMQ_PASS')
    );

    $this->queueName = $queueName;

    $this->channel = $this->connection->channel();
    $this->channel->queue_declare($queueName, false, false, false, false);
  }

  public function broadcast($message)
  {
    $msg = new AMQPMessage(json_encode($message));
    $this->channel->basic_publish($msg, '', $this->queueName);
  }

  public function __destruct()
  {
    $this->channel->close();
    $this->connection->close();
  }
}
