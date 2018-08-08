<?php

class Processor
{
  public function __construct()
  {
    $this->conn = new PDO('mysql:host=localhost;dbname=storage_db', 'root', '');
  }

  public function process($msg)
  {
    $parsedMessage = json_decode($msg);

    $stmt = $this->conn->prepare('INSERT INTO storages (`key`, `value`, user_id) VALUES (?, ?, ?)');
    $stmt->execute([$parsedMessage->key, $parsedMessage->value, $parsedMessage->user_id]);
  }
}
