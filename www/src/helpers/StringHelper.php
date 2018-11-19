<?php

namespace Dharmatin\Simk\Helper;

class StringHelper {

  public static function toCamelCase($string) {
    $result = strtolower($string);
    $matches = self::matchAllNonAlphanumericBeforeNextWord($result);
    foreach($matches[0] as $match) {
      $c = preg_replace('/[\W:]/', '', strtoupper($match));
      $result = str_replace($match, $c, $result);
    }
    
    return $result;
  }

  public static function toKebabCase($string) {
    $result = strtolower($string);
    $matches = self::matchAllNonAlphanumericBeforeNextWord($result);
    foreach($matches[0] as $match) {
      $c = preg_replace('/[\W:]/', '-', $match);
      $result = str_replace($match, $c, $result);
    }
    
    return $result;
  }

  public static function toSnakeCase($string) {
    $result = strtolower($string);
    $matches = self::matchAllNonAlphanumericBeforeNextWord($result);
    foreach($matches[0] as $match) {
      $c = preg_replace('/[\W:]/', '_', $match);
      $result = str_replace($match, $c, $result);
    }
    
    return $result;
  }

  public static function matchAllNonAlphanumericBeforeNextWord($string) {
    preg_match_all('/[\W:][a-z]/', $string, $matches);
    return $matches;
  }
}

