<?php

$loader = @include "vendor/autoload.php";
$loader->addPsr4("Dharmatin\\Simk\\", "./src", true);
$loader->addPsr4("Dharmatin\\Simk\\Controller\\", "./src/controllers", true);
$loader->addPsr4("Dharmatin\\Simk\\Core\\Router\\", "./src/core/router", true);

// require './src/core/router/Request.php';
// require './src/core/router/Router.php';

// use Dharmatin\Simk\Controller\Seller;
use Dharmatin\Simk\Core\Router\Router;
use Dharmatin\Simk\Core\Router\Request;

$router = new Router(new Request);
$router->get('/seller/v1/seller', array(
  "controller" => "seller",
  "method" => "get"
));

$router->get('/seller/v1/seller/1', array(
  "controller" => "seller",
  "method" => "get"
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

