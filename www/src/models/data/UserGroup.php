<?php

namespace Dharmatin\Simk\Model\Data;

class UserGroup {
  public $id;
  public $groupName;
  public $userRole;
  public function __construct() {
    $this->userRole = new UserRole();
  }
}