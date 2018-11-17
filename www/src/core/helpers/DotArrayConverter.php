<?php
namespace Dharmatin\Simk\Core\Helper;

class DotArrayConverter {
  /**
   * Get an item from an array using "dot" notation.
   * https://stackoverflow.com/a/39118759
   * @param  \ArrayAccess|array  $array
   * @param  string  $key
   * @param  mixed   $default
   * @return mixed
   */
  public static function get($array, $key, $default = null) {
    if (! static::accessible($array)) {
        return $default;
    }
    if (is_null($key)) {
        return $array;
    }
    if (static::exists($array, $key)) {
        return $array[$key];
    }
    if (strpos($key, '.') === false) {
        return $array[$key] ?? $default;
    }
    foreach (explode('.', $key) as $segment) {
        if (static::accessible($array) && static::exists($array, $segment)) {
            $array = $array[$segment];
        } else {
            return $default;
        }
    }
    return $array;
  }
  /**
   * Determine whether the given value is array accessible.
   *
   * @param  mixed  $value
   * @return bool
   */
  public static function accessible($value) {
    return is_array($value) || $value instanceof ArrayAccess;
  }

  /**
   * Determine if the given key exists in the provided array.
   *
   * @param  \ArrayAccess|array  $array
   * @param  string|int  $key
   * @return bool
   */
  public static function exists($array, $key) {
    if ($array instanceof ArrayAccess) {
        return $array->offsetExists($key);
    }
    return array_key_exists($key, $array);
  }

  /**
   * Set an array item to a given value using "dot" notation.
   *
   * If no key is given to the method, the entire array will be replaced.
   *
   * @param  array   $array
   * @param  string  $key
   * @param  mixed   $value
   * @return array
   */
  public static function set(&$array, $key, $value) {
    if (is_null($key)) {
        return $array = $value;
    }

    $keys = explode('.', $key);

    while (count($keys) > 1) {
        $key = array_shift($keys);

        // If the key doesn't exist at this depth, we will just create an empty array
        // to hold the next value, allowing us to create the arrays to hold final
        // values at the correct depth. Then we'll keep digging into the array.
        if (! isset($array[$key]) || ! is_array($array[$key])) {
            $array[$key] = [];
        }

        $array = &$array[$key];
    }

    $array[array_shift($keys)] = $value;

    return $array;
  }
}