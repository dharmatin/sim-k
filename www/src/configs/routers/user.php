<?php

$basePath = '/user/v1/user';
return function($router) use($basePath) {
  $router->post($basePath . "/login", array(
    "controller" => "user",
    "method" => "login"
  ));
};