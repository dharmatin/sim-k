<?php

namespace Dharmatin\Simk\Core\Router;

class Response {
  const SUCCESS_CODE = 200;

  public static function jsonResponse($response) {
    header("Content-Type: application/json");
    if (is_array($response)) die(json_encode($response));
    die($response);
  }

  public static function htmlResponse($response) {
    header("Content-Type: text/html; charset=utf-8");
    return $response;
  }

  public static function errorResponse($errorCode, $message, $data = array()) {
    return count($data) > 0 ? self::jsonResponse(array("code" => $errorCode, "message" => $message, "data" => $data))
      : self::jsonResponse(array("code" => $errorCode, "message" => $message));
  }

  public static function successResponse($message, $data = array()) {
    return count($data) > 0 ? self::jsonResponse(array("code" => self::SUCCESS_CODE, "message" => $message, "data" => $data))
      : self::jsonResponse(array("code" => self::SUCCESS_CODE, "message" => $message));
  }

  public static function isJSON($string) {
    json_decode($string);
    return (\json_last_error()===JSON_ERROR_NONE);
  }
}