<?php
namespace Dharmatin\Simk\Core\Router;

class Request implements IRequest {
  
  function __construct() {
    $this->__bostrap();
  }

  private function __bostrap() {
    foreach($_SERVER as $key => $value) {
      $this->{$this->__toCammelCase($key)} = $value;
    }
  }

  private function __toCammelCase($string) {
    $result = strtolower($string);
    preg_match_all('/[^a-zA-Z\d\s:][a-z]/', $result, $matches);
    foreach($matches[0] as $match) {
      $c = preg_replace('/[^a-zA-Z\d\s:]/', '', strtoupper($match));
      $result = str_replace($match, $c, $result);
    }
    
    return $result;
  }

  public function getHeaders() {
    $headers = array();
    foreach(getallheaders() as $key => $value) {
      $headers[$this->__toCammelCase($key)] = $value;
    }

    return $headers;
  }

  public function getBody() {
    if ($this->requestMethod === "GET") {
      return;
    }

    if ($this->requestMethod === "POST") {
      $result = array();
      foreach($_POST as $key => $value) {
        $result[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }

      return $result;
    }

    return $body;
  }

  public function getJsonRawBody() {
    try {
      $rawJson = file_get_contents("php://input");
      return $this->isValidJson($rawJson) ? json_decode($rawJson) : null;
    } catch(\Error $e) {

    }
  }

  public function getQuery($queryString) {
    return $_GET[$queryString];
  }

  public function isValidJson($strJson) {
    json_decode($strJson);
    return json_last_error() == JSON_ERROR_NONE;
  }

  public function getUrlParams($name) {
    return $_GET[$name];
  }
}