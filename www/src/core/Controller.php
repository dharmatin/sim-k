<?php

namespace Dharmatin\Simk\Core;

use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Core\Router\Response;

abstract class Controller {
  protected $request;
  protected $config;
  public function __construct() {
    $this->request = new Request();
    $this->config = new Configure();
  }

  protected function successResponse($message, $data = array()) {
    return Response::successResponse($message, $data);
  }

  protected function errorResponse($code, $message, $data = array()) {
    return Response::errorResponse($code, $message, $data);
  }
}