<?php

return function($router) {
  $router->get('/seller/v1/seller', array(
    "controller" => "seller",
    "method" => "get"
  ));

  $router->get('/seller/v1/seller/([1-9]+)', array(
    "controller" => "seller",
    "method" => "id",
    "id" => 1
  ));

  $router->get('/seller/v1/seller/([1-9]+)/([1-9]+)', array(
    "controller" => "seller",
    "method" => "twoId",
    "id" => 1
  ));

  $router->get('/seller/v1/seller/([1-9]+)/((?=.*\d)(?=.*[a-zA-Z]).{2,8})', array(
    "controller" => "seller",
    "method" => "tripleId",
    "id" => 1,
    "tipeId" => 2
  ));

  $router->post('/seller/v1/seller', array(
    "controller" => "seller",
    "method" => "post"
  ));

  $router->put('/seller/v1/seller', array(
    "controller" => "seller",
    "method" => "put"
  ));

  $router->delete('/seller/v1/seller', array(
    "controller" => "seller",
    "method" => "delete"
  ));
  $router->get('/', function() {
    return "HELLO";
  });
};