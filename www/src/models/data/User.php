<?php

namespace Dharmatin\Simk\Model\Data;

class User {
  public $id;
  public $username;
  public $email;
  public $password;
  public $firstName;
  public $lastName;
  public $userGroup;
  public $status;

  public function __construct() {
    $this->userGroup = new UserGroup();
  }
}