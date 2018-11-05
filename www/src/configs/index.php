<?php

return function ($env){

  function excludeFile($fileName, &$files) {
    $fileIndex = array_search(__DIR__ . '/' . $fileName, $files);
    unset($files[$fileIndex]);
  }

  function hasEnvironmentConfig($env, $configs) {
    return isset($configs[$env]) ? true : false;
  }

  function generate($env) {
    $configs = [];
    $files = glob(__DIR__ . '/*.php');
    excludeFile("index.php", $files);
    excludeFile("router.php", $files);
    foreach ($files as $file) {
      $info = pathinfo($file);
      $configFile = @include $file;
      $configs[$info["filename"]] = hasEnvironmentConfig($env, $configFile) ? $configFile[$env] : $configFile;
    }
    return $configs;
  };
  
  return generate($env);
};
