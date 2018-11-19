<?php

namespace Dharmatin\Simk\Controller;
use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Core\Logger;
use Dharmatin\Simk\Library\Connection\Mysql;
use Dharmatin\Simk\Library\Connection\Configuration;
use Dharmatin\Simk\Model\Users;
use Dharmatin\Simk\Core\Router\Response;

class Employee {
  public function getEmployee() {
    $users = new Users();
    $user = json_decode(json_encode(array(
      "username" => "deni",
      "email" => "deni@me.id",
      "password" => "123123123",
      "firstName" => "deni",
      "lastName" => "ucok",
      "userGroup" => array(
        "id" => 1
      )
    )));
    print_r($users->addUser($user));
    return Response::successResponse("SUKSES", $users->getUsers());
  }
}