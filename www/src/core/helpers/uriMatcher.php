<?php

const SLASH = "/";

function hasMatchedUri($url, $route) {
  $urlParts = explode("/", removeTrailingSlash($url));
  $routeParts = explode("/", removeTrailingSlash($route));
  return count($urlParts) == count($routeParts) && count(getMatchedUri($url, $route)) > 0;
}


function getMatchedUri($url, $route) {
  $pattern = "/" . str_replace("/", "\/", substr($route, 1)) . "\/?$/";
  preg_match($pattern, removeTrailingSlash($url), $matches);
  return $matches;
}

function removeTrailingSlash($string) {
  return rtrim($string, SLASH);
}