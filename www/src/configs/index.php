<?php

$environment = "dev";

return function ($environment){
  return array(
    "env" => $environment,
    "test" => array(
      "hallo" => "OK"
    )
  );
};