<?php

namespace Dharmatin\Simk\Model\Data;

class UserLoginHistory {
  public $timestamp;
  public $user;
  public $response;

  public function __construct() {
    $this->user = new User();
  }
}