<?php

namespace Dharmatin\Simk\Library\Connection;

use Dharmatin\Simk\Core\Logger;

class Memcached implements IConnection {
  private $connection;
  private $host;
  private $port;

  public function __construct(Configuration $config) {
    $this->host = $config->host;
    $this->port = $config->port;
    $this->connect();
  }
  public function connect() {
    if ($this->connection === null) {
      $this->connection = new \Memcached();
      $this->connection->addServer($this->host, $this->port);
    }
  }
  public function close() {
    $this->getConnection()->close();
    $this->connection = null;
  }
  public function getConnection() {
    return $this->connection;
  }
}