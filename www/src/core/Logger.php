<?php
namespace Dharmatin\Simk\Core;
class Logger {
  
  public static function write($level = "debug", $log) {
    if (Configure::read("app.log.enable")) {
      if (self::shouldWriteToDisk($level)) {
        try{
          self::writeToDisk(self::generateFileName(), self::formatLog($level, $log));
        } catch (\Exception $e) {
          print_r($e);
        }
      }
    }
  }

  private static function formatLog($level, $log) {
    return date('Y-m-d H:i:s') . " | " . $level . " | " . $log . "\n"; 
  }

  private static function generateFileName() {
    preg_match('/\{(?<dateFormat>.*?)\}/', Configure::read("app.log.file"), $matches);
    return str_replace($matches[0], date($matches["dateFormat"]), Configure::read("app.log.file"));
  }

  private static function shouldWriteToDisk($level) {
    return \in_array($level, Configure::read("app.log.level"));
  }

  private static function writeToDisk($file, $log) {
    file_put_contents($file, $log, FILE_APPEND);
  }
}