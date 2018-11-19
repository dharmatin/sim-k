<?php

namespace Dharmatin\Simk\Model;

use Dharmatin\Simk\Core\Model;
use Dharmatin\Simk\Helper\RawValue;

class UserLoginHistory extends Model {
  private $data;
  public function __construct() {
    parent::__construct();
  }

  public function save($username, $response) {
    $sql = "
      INSERT INTO user_login_history (timestamp, username, response)
      VALUES (NOW(), :username, :response)
    ";
    $query = $this->query($sql, array(
      "username" => $username,
      "response" => json_encode($response)
    ));

    return $query;
  }

  public function setUserLoginHistory($data) {

  }
}