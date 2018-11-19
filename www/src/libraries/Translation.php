<?php

namespace Dharmatin\Simk\Library;

use Dharmatin\Simk\Core\Configure;
use Dharmatin\Simk\Core\Router\Request;
use Dharmatin\Simk\Core\Helper\DotAsArrayKeyConverter;

class Translation {
  
  public static function translate($key) {
    $translation = self::loadDictionary();
    return empty($key) ? $translation : DotAsArrayKeyConverter::get($translation, $key);
  }

  private static function loadDictionary() {
    $request = new Request();
    $languageFromHeader = $request->getHeaders()["acceptLanguage"] ? $request->getHeaders()["acceptLanguage"] : Configure::read("app.defaultLanguage");
    $languageFromQuery = $request->getQuery("lang") ? $request->getQuery("lang") : Configure::read("app.defaultLanguage"); 
    $language = $languageFromHeader ? $languageFromHeader : $languageFromQuery;
    return Configure::read("lang." . $language);
  }
}