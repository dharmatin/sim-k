<?php

namespace Dharmatin\Simk\Helper;

class TypeHelper {
  public static function cast($destination, \stdClass $source) {
      $sourceReflection = new \ReflectionObject($source);
      $sourceProperties = $sourceReflection->getProperties();
      foreach ($sourceProperties as $sourceProperty) {
          $name = $sourceProperty->getName();
          $destination->{$name} = $source->$name;
      }
      return $destination;
  }
}