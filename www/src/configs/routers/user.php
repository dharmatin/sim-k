<?php

$basePath = '/user/v1/user';
return function($router) use($basePath) {
  $router->post($basePath . "/login", array(
    "controller" => "user",
    "method" => "login"
  ));

  $router->post($basePath . "/register", array(
    "controller" => "user",
    "method" => "register"
  ));

  $router->post($basePath . "/reset-password", array(
    "controller" => "user",
    "method" => "resetPassword"
  ));

  $router->put($basePath . "/update", array(
    "controller" => "user",
    "method" => "updateUser"
  ));

  $router->put($basePath . "/change-status", array(
    "controller" => "user",
    "method" => "changeStatus"
  ));
};