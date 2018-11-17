<?php

namespace Dharmatin\Simk\Core;

use Dharmatin\Simk\Core\Helper\DotArrayConverter;

class Configure {

  private static $configs;

  public static function write($configs) {
    self::$configs = $configs;
  }

  public static function read($name = "") {
    if (!$name) return self::$configs;
    return DotArrayConverter::get(self::$configs, $name);
  }

  private function __convertToDeepObject($configs) {
    $json = json_encode($configs);
    return json_decode($json);
  }
}