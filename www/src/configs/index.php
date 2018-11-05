<?php

return function ($env){

  function excludeFile($fileName, &$files) {
    $fileIndex = array_search(__DIR__ . '/' . $fileName, $files);
    unset($files[$fileIndex]);
  }

  function generate() {
    $configs = [];
    $files = glob(__DIR__ . '/*.php');
    excludeFile("index.php", $files);
    excludeFile("router.php", $files);
    foreach ($files as $file) {
      $info = pathinfo($file);
      $configFile = @include $file;
      $configs[$info["filename"]] = isset($configFile[$env]) ? $configFile[$env] : $configFile;
    }
    return $configs;
  };
  
  return generate();
};
