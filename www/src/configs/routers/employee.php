<?php

return function($router) {
  $router->get('/employee/v1/employee', array(
    "controller" => "employee",
    "method" => "getEmployee"
  ));
};