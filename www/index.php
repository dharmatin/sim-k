<?php
define("CONFIG_DIR", __DIR__ . "/src/configs");

require "./src/core/App.php";

$configuration = @include CONFIG_DIR . "/index.php";
App::addConfiguration($configuration("dev")); 
App::use(CONFIG_DIR . "/router.php");
App::start();
