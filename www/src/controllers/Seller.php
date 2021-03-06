<?php

namespace Dharmatin\Simk\Controller;
use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Core\Logger;
class Seller {

  public function __construct() {

  }

  public function get() {
    return "GET";
  }

  public function post() {
    $req = new Request();
    $body = $req->getJsonRawBody();
    print_r($body);
    return "POST";
  }

  public function put() {
    return "PUT";
  }

  public function delete() {
    return "DELETE";
  }

  public function detail() {
    return "detail";
  }

  public function id() {
    return "ID";
  }

  public function twoId() {
    return "TWO ID";
  }

  public function tripleId() {
    $req = new Request();
    $id = $req->getUrlParams("id");
    Logger::write("info", "TEST WRITE TO DISK [" . json_encode($_GET) . "]");
    return "TRIPLE " . $id . " TIPE " . $req->getUrlParams("tipeId");
  }
}