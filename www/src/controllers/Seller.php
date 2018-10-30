<?php

namespace Dharmatin\Simk\Controller;
use Dharmatin\Simk\Core\Router\Request;
class Seller {

  public function __construct() {

  }

  public function get() {
    return "GET";
  }

  public function post() {
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
    return "TRIPLE ID";
  }
}