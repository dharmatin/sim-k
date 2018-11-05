<?php

define("VENDOR_DIR", __DIR__ . "/../../vendor");
define("WORKING_DIR", __DIR__ . "/../../src");

require "Loader.php";

use Dharmatin\Simk\Core\Router\Router;
use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Configure;

class App {
  private static $config;
  private static $path = array();

  public static function use($path, $isConfiguration = false) {
    self::register($path);
  }

  public static function addConfiguration($config = array()) {
    self::$config = $config;
  }
  public static function start() {
    Loader::loadClass();
    Configure::write(self::$config);
    foreach(self::$path as $app) {
      $app(new Router(new Request));
    }
  }

  private static function register($path) {
    array_push(self::$path, @include $path);
  }
}