<?php

namespace Dharmatin\Simk\Core;

class ErrorPage {
  private $error;
  public function show() {
    $this->error = error_get_last();
    preg_match('/^(.*)$/m', $this->error["message"], $matches);
    $firsLineMessage = $matches[1];
    switch($this->error["type"]) {
      case \E_ERROR:
        $this->showError500($firsLineMessage);
      break;
      default:
        $this->showHttpErrorCode(http_response_code());
      break;
    }
  }

  public function showError500($message) {
    header("Content-Type: Application/json");
    echo json_encode(array(
      "code" => 500,
      "message" => $message
    ));
  }

  public function showHttpErrorCode($httpCode) {
    switch($httpCode) {
      case 404:
        header("Content-Type: Application/json");
        echo json_encode(array(
          "code" => $httpCode,
          "message" => "Not Found"
        ));
      break;
      case 405:
        header("Content-Type: Application/json");
        echo json_encode(array(
          "code" => $httpCode,
          "message" => "Method Not Allowed"
        ));
      break;
      default:
      break;
    }
  }
}