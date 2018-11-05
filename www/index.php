<?php
define("CONFIG_DIR", __DIR__ . "/src/configs");

require "./src/core/App.php";
$app = @include CONFIG_DIR . "/app.php";
$configuration = @include CONFIG_DIR . "/index.php";
App::addConfiguration($configuration($app["env"])); 
App::use(CONFIG_DIR . "/router.php");
App::start();
