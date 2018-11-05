<?php
namespace Dharmatin\Simk\Core\Router;

require __DIR__ . "/../helpers/uriMatcher.php";
class Router {

  private $__request;
  private $__supportedHttpMethods = array(
    "GET",
    "POST",
    "PUT",
    "DELETE"
  );
  private $__method;

  public function __construct(IRequest $request) {
   $this->__request = $request;
  }

  public function __call($name, $args) {
    $this->register($name, $args);
  }

  /**
   * Removes trailing forward slashes from the right of the route.
   * @param route (string)
   */
  private function __formatRoute($route) {
    $result = rtrim($route, '/');
    if ($result === '')
    {
      return '/';
    }
    return $result;
  }

  private function invalidMethodHandler() {
    header("{$this->__request->mserverProtocol} 405 Method Not Allowed");
  }

  private function defaultRequestHandler() {
    header("{$this->__request->serverProtocol} 404 Not Found");
  }

  /**
   * Resolves a route
   */
  public function resolve() {
    header("{$this->__request->serverProtocol} 200");
    $methodDictionary = $this->{strtolower($this->__request->requestMethod)};
    $formatedRoute = $this->__formatRoute($this->__request->requestUri);
    $class = $methodDictionary[$formatedRoute];
    if(is_null($class))
    {
      $this->defaultRequestHandler();
      return;
    }
    if (!isset($class["controller"])) echo call_user_func_array($class["method"], array($this->__request));
    else echo call_user_func_array(array($class["controller"], $class["method"]), array($this->__request));
  }

  public function __destruct() {
    $this->resolve();
  }

  public function register($name, $args) {
    list($route, $params) = $args;
    if (hasMatchedUri($this->__request->redirectUrl, $route)) {
      if(!in_array(strtoupper($name), $this->__supportedHttpMethods)) {
        $this->invalidMethodHandler();
      }

      if ($params instanceof \Closure) {
        $this->{strtolower($name)}[$this->__formatRoute($this->__request->requestUri)]["method"] = $params;
      } else {
        $controllerName = "\\Dharmatin\\Simk\\Controller\\" . \ucfirst($params["controller"]);
        $this->__method = $params["method"];
        $paramsUri = getMatchedUri($this->__request->redirectUrl, $route);
        $this->registerParamsToQueryString($paramsUri, $params);
        $this->{strtolower($name)}[$this->__formatRoute($this->__request->requestUri)]["controller"] = (new $controllerName());
        $this->{strtolower($name)}[$this->__formatRoute($this->__request->requestUri)]["method"] = $this->__method;
      }
    }
  }

  public function registerParamsToQueryString($uriParams, $routeParams) {
    $map = array_walk($routeParams, function($value, $key) use($uriParams) {
      $_GET[$key] = isset($uriParams[$value]) ? $uriParams[$value] : $value;
    });
  }
}