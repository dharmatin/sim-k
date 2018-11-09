<?php

define("VENDOR_DIR", __DIR__ . "/../../vendor");
define("WORKING_DIR", __DIR__ . "/../../src");

require "Loader.php";

use Dharmatin\Simk\Core\Router\Router;
use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Core\ErrorPage;

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
    register_shutdown_function(array(new ErrorPage(), 'show'));
    Configure::write(self::$config);
    foreach(self::$path as $app) {
      $app(new Router(new Request));
    }
  }

  public static function registerNamespace($config = array()) {
    Loader::registerNamespace($config);
  }

  private static function register($path) {
    array_push(self::$path, @include $path);
  }
}

function shutDownFunction() { 
  $error = error_get_last();
  print_r($error);
  if ($error) {
      // Call your error handler or something...
      echo 'A fatal parse error occured!';
  } 
}