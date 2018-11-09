<?php

namespace Dharmatin\Simk\Core\Router;

class RouterList {
  
  private static $routers;
  private static $found = 0;

  public static function addRouter($caller, $route, $params) {
    self::$routers[$caller][$route] = $params;
  }

  public static function getRouter() {
    return self::$routers;
  }
}