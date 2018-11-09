<?php

namespace Dharmatin\Simk\Library\Connection;

use Dharmatin\Simk\Core\Logger;

class Mysql implements IConnection {

  private $host;
  private $username;
  private $port;
  private $database;
  private $password;
  private $connection;
  private static $reconnects = 3;

  public function __construct(Configuration $config) {
    $this->username = $config->username;
    $this->host = $config->host;
    $this->port = $config->port;
    $this->database = $config->database;
    $this->password = $config->password;
    $this->connect();
  }

  public function connect() {
    if ($this->connection === null) {
      $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->database;
      $options    = array(
        \PDO::ATTR_EMULATE_PREPARES     => false, 
        \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE   => \PDO::FETCH_ASSOC
      );
      try {
        $this->connection = new \PDO($dsn, $this->username, $this->password, $options);
      } catch (\PDOException $e) {
        Logger::write("error", "[MYSQL EXCEPTION] [" . $e->getMessage() . "]");
        throw new \Exception($e->getMessage());
      }
    } else {
      Logger::write("info", "[MYSQL] [Trying to connect...]");
      $this->testConnection();
    }
  }

  public function close() {
    $this->connection = null;
  }

  public function getConnection() {
    return $this->connection;
  }

  public function testConnection() {
    try {
      $this->connection->query("SELECT 1");
    } catch (\PDOException $e) {
      // Mysql server has gone away or similar error
      self::$reconnects--;
      if (self::$reconnects <= 0) {
          // No more tests, throw error, reinstate reconnects
          self::$reconnects = 3;
          throw $e;
      }
      $this->connection = null;
      $this->connect();      
    }
  }
}