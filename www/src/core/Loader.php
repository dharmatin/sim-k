<?php

class Loader {
  
  private static $loader;

  public static function loadClass() {
    self::registerNamespace();
  }

  public static function registerNamespace($configs = array()) {
    if ($configs) {
      self::loadNameSpace($configs);
    } else {
      self::loadCoreNameSpace();
    }
  }

  private static function loadCoreNameSpace() {
    $namespaces = @include 'config/class.loader.php';
    self::loadNameSpace($namespaces);
  }

  private static function loadNameSpace($configs = array()) {
    self::$loader = @include VENDOR_DIR . "/autoload.php";
    self::$loader->addPsr4("Dharmatin\\Simk\\", WORKING_DIR, true);
    foreach ($configs as $namespace => $path) {
      self::$loader->addPsr4($namespace, realpath($path), true);
    }
  }
}