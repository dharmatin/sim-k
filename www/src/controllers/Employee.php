<?php

namespace Dharmatin\Simk\Controller;
use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Core\Logger;
use Dharmatin\Simk\Library\Connection\Mysql;
use Dharmatin\Simk\Library\Connection\Configuration;

class Employee {
  public function getEmployee() {
    echo $text;
    $config = new Configuration;
    $config->username = Configure::read("mysql.username");
    $config->password = Configure::read("mysql.password");
    $config->port = Configure::read("mysql.port");
    $config->host = Configure::read("mysql.host");
    $config->database = Configure::read("mysql.database");
    // $mysql = new Mysql($config);
    return "Employee";
  }
}