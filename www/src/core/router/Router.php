<?php
namespace Dharmatin\Simk\Core\Router;

require __DIR__ . "/../helpers/uriMatcher.php";
class Router {

  private $request;
  private $supportedHttpMethods = array(
    "GET",
    "POST",
    "PUT",
    "DELETE"
  );
  private $controller;
  private $method;
  private $get = array();
  private $post = array();
  private $put = array();
  private $delete = array();

  public function __construct(IRequest $request) {
   $this->request = $request;
  }

  public function __call($name, $args) {
    list($route, $params) = $args;
    RouterList::addRouter(strtolower($name), $route, $params);
    if (hasMatchedUri($this->request->redirectUrl, $route) && strtolower($this->request->requestMethod) === strtolower($name)) {
      $this->execute($params, $route);
    } else if(!in_array(strtoupper($this->request->requestMethod), $this->supportedHttpMethods)) {
      return $this->invalidMethodHandler();
    } else if (!$this->findRoute($this->request->redirectUrl)) {
      return $this->pageNotFound();
    }
  }

  public function register($caller, $route, $params) {
    $this->{strtolower($caller)}[$this->formatRoute($route)] = $params;
  }

  private function execute($params, $route) {
    http_response_code(200);
    $this->registerParamsToQueryString(getMatchedUri($this->request->redirectUrl, $route), $params);
    if ($params instanceof \Closure) {
      Response::jsonResponse(call_user_func_array($params, array($this->request)));
    } else {
      $controller = "\\Dharmatin\\Simk\\Controller\\" . \ucfirst($params["controller"]);
      $method = $params["method"];
      Response::jsonResponse(call_user_func_array(array(new $controller, $method), array($this->request)));
    }
  }
  private function formatRoute($route) {
    $result = rtrim($route, '/');
    if ($result === '') {
      return '/';
    }
    return $result;
  }

  private function invalidMethodHandler() {
    http_response_code(405);
  }

  private function pageNotFound() {
    http_response_code(404);
  }

  private function findRoute($uri) {
    $routers = RouterList::getRouter();
    $paths = array_keys($routers[strtolower($this->request->requestMethod)]);
    foreach($paths as $path) {
      if (hasMatchedUri($uri, $path)) {
        return true;
      }
    }
    return false;
  }

  public function registerParamsToQueryString($uriParams, $routeParams) {
    $map = array_walk($routeParams, function($value, $key) use($uriParams) {
      $_GET[$key] = isset($uriParams[$value]) ? $uriParams[$value] : $value;
    });
  }
}