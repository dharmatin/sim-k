<?php

namespace Dharmatin\Simk\Model;

use Dharmatin\Simk\Core\Model;

class Users extends Model {
  const DEFAULT_SELECT_STATEMENT = "SELECT U.id as userId, U.username, U.password, U.email, U.first_name, U.last_name,
    UG.id as groupId, UG.group_name, UR.id as roleId, UR.actions, UR.role_name, U.status
    FROM users U
    INNER JOIN user_group UG ON U.user_group_id = UG.id
    INNER JOIN user_role UR ON UR.id = UG.user_role_id ";
  
  const ACTIVE_STATUS = "A";
  const SUSPEND_STATUS = "S";
  const BLOCKED_STATUS = "X";

  private $data;
  public function __construct() {
    parent::__construct();
    $this->data = new Data\User();
  }
  public function getAllUsers() {
    $users = $this->fetchAll(self::DEFAULT_SELECT_STATEMENT . "WHERE status=:status", array("status" => self::ACTIVE_STATUS));
    return array_map(function($user) {
      $this->setUser($user);
      return $this->getUser();
    }, $users);
  }

  public function getUserById($id) {
    $user = $this->fetchOne(self::DEFAULT_SELECT_STATEMENT . "WHERE U.id=:user_id AND status=:status", array(
      "user_id" => $id, 
      "status" => self::ACTIVE_STATUS
    ));
    $this->setUser($user);
    return $this->getUser();
  }

  public function getUserByUsername($username) {
    $user = $this->fetchOne(self::DEFAULT_SELECT_STATEMENT . "WHERE U.username=:username AND status=:status", array(
      "username" => $username, 
      "status" => self::ACTIVE_STATUS
    ));
    if ($user) {
      $this->setUser($user);
      return $this->getUser();
    }
    return;
  }

  public function addUser($user) {
    $sql = "INSERT INTO users (
      username, email, password, first_name, last_name, user_group_id
      ) VALUES (
        :username, :email, :password, :first_name, :last_name, :user_group_id
      )";
    $q = $this->query($sql, array(
      "username" => $user->username,
      "email" => $user->email,
      "password" => $user->password,
      "first_name" => $user->firstName,
      "last_name" => $user->lastName,
      "user_group_id" => $user->userGroup->id
    ));

    return $q;
  }

  public function setUser($user) {
    $this->data->id = $user["userId"];
    $this->data->username = $user["username"];
    $this->data->password = $user["password"];
    $this->data->email = $user["email"];
    $this->data->firstName = $user["first_name"];
    $this->data->lastName = $user["last_name"];
    $this->data->status = $user["status"];
    $this->data->userGroup->id = $user["groupId"];
    $this->data->userGroup->groupName = $user["group_name"];
    $this->data->userGroup->userRole->id = $user["roleId"];
    $this->data->userGroup->userRole->roleName = $user["role_name"];
    $this->data->userGroup->userRole->actions = $user["actions"];
  }

  public function getUser() {
    return $this->data;
  }
}