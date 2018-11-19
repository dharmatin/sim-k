<?php

namespace Dharmatin\Simk\Helper;

class RawValue {
  public $value;

  public function __construct($value) {
    if (is_string($value) === false) {
      throw new Exception("Invalid parameter type");
    }
    $this->value = $value;
  }

  // public function getValue() {
  //   return $this->value;
  // }

  public function __toString() {
    return $this->value;
  }
}