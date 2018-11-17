<?php

namespace Dharmatin\Simk\Core;

use Dharmatin\Simk\Library\Connection\Mysql;
use Dharmatin\Simk\Library\Connection\Configuration;

abstract class Model {

  const PDO_PARAMS =  array(
    "integer" => \PDO::PARAM_INT,
    "string" => \PDO::PARAM_STR,
    "boolean" => \PDO::PARAM_BOOL,
    "object" => \PDO::PARAM_STR
  );

  private $connection;

  public function __construct() {
    $config = new Configuration;
    $config->username = Configure::read("mysql.username");
    $config->password = Configure::read("mysql.password");
    $config->port = Configure::read("mysql.port");
    $config->host = Configure::read("mysql.host");
    $config->database = Configure::read("mysql.database");
    $this->setConnection((new Mysql($config))->getConnection());
  }

  public function setConnection($connection) {
    $this->connection = $connection;
  }

  public function getConnection() {
    return $this->connection;
  }

  protected function fetchOne($statement, $conditionalValues = array()) {
    return $this->preparedStatement($statement, $conditionalValues)->fetch();
  }

  protected function fetchAll($statement, $conditionalValues = array()) {
    return $this->preparedStatement($statement, $conditionalValues)->fetchAll();
  }

  protected function query($statement, $conditionalValues = array()) {
    $preparedStatement = $this->getConnection()->prepare($statement);
    foreach ($conditionalValues as $field => $value) {
      $preparedStatement->bindValue(
        ":" . $field, 
        $value, 	
        isset(self::PDO_PARAMS[\gettype($value)]) ? self::PDO_PARAMS[\gettype($value)] : self::PDO_PARAMS["string"]
      );
    }

    return $preparedStatement->execute();
  }

  private function preparedStatement($statement, $conditionalValues = array()) {
    $preparedStatement = $this->getConnection()->prepare($statement);
    $preparedStatement->execute($conditionalValues);

    return $preparedStatement;
  }

}