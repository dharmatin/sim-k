<?php

namespace Dharmatin\Simk\Library\Connection;

interface IConnection {
  public function connect();
  public function close();
  public function getConnection();
}