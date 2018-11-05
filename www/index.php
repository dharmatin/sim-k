<?php
define("CONFIG_DIR", __DIR__ . "/src/configs");

require "./src/core/App.php";
$common = @include CONFIG_DIR . "/common.php";
$configuration = @include CONFIG_DIR . "/index.php";
App::addConfiguration($configuration($common["env"])); 
App::use(CONFIG_DIR . "/router.php");
App::start();
