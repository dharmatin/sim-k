<?php

namespace Dharmatin\Simk\Helper;

class StringHelper {

  public static function toCamelCase($string) {
    $result = strtolower($string);
    $matches = self::matchAllNonAlphanumericBeforeNextWord($result);
    if (count($matches[0]) > 1) {
      foreach($matches[0] as $match) {
        $c = preg_replace('/[\W:]/', '', strtoupper($match));
        $result = str_replace($match, $c, $result);
      }
    }
    $result = StringHelper::fromCammelCaseTo($string, "-");
    
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
    if (count($matches[0]) > 0) {
      foreach($matches[0] as $match) {
        $c = preg_replace('/[\W:]/', '_', $match);
        $result = str_replace($match, $c, $result);
      }
    } else {
      $result = StringHelper::fromCammelCaseTo($string, "_");
    }
    
    return $result;
  }

  public static function matchAllNonAlphanumericBeforeNextWord($string) {
    preg_match_all('/[\W:][a-z]/', $string, $matches);
    return $matches;
  }

  private static function fromCammelCaseTo($string, $separator = "_") {
    return strtolower(preg_replace("/(?<!^)[A-Z]/", $separator . "$0", $string));
  }
}

