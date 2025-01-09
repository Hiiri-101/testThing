<?php
namespace App;

class Router {

  private array $routes;
  private const METHOD_GET = 'GET';
  private const METHOD_POST = 'POST';
  private const METHOD_DELETE = 'DELETE';
  private const METHOD_PUT = 'PUT';

  public function get(string $path, $callback): void
  {
    $this->addRoute(self::METHOD_GET, $path,$callback);
  }

  public function post(string $path, $callback): void
  {
    $this->addRoute(self::METHOD_POST, $path,$callback);
  }

  public function put(string $path, $callback): void
  {
    $this->addRoute(self::METHOD_PUT, $path,$callback);
  }

  public function delete(string $path, $callback): void
  {
    $this->addRoute(self::METHOD_DELETE, $path,$callback);
  }

  private function addRoute(string $method, string $path, $callback): void
  {
    $param = false;

    if(preg_match("/\/{.*}$/", $path)){
      $param = true;
    }

    $this->routes[$method.$path] = [
      'path' => $path,
      'method' => $method,
      'param' => $param,
      'callback' => $callback
    ];

  }

  public function run()
  {
    // echo '<pre>';
    // var_dump($this->routes);
    // echo '</pre>';

    // echo '<pre>';
    // var_dump($_SERVER);
    // echo '</pre>';


    $uri = parse_url($_SERVER['REQUEST_URI']);
    $requestPath = $uri['path'];
    $method = $_SERVER['REQUEST_METHOD'];
    $callback = null;
    $isParam = false;
    $uriParam = [];
    
    // form-datan lukemiseen
    //$params = array_merge($_GET, $_POST);
    //$params = [...$_GET, ...$_POST];

    // json bodyn lukemiseen
    $params = json_decode(file_get_contents("php://input"));

    // uri = /customer/123
    // endpoint = /customer/{ID}

    if(preg_match("/\/[0-9]+$/", $requestPath)){
      $isParam = true;
      preg_match_all("/[0-9]+$/", $requestPath, $uriParam);
    }


    foreach($this->routes as $route){
      // uri = /customer/123
      // endpoint = /customer/{ID}
      if($route['method'] === $method && 
        preg_replace("/{.*}/", '', $route['path']) === preg_replace("/[0-9]/", '', $requestPath)){

          $callback = $route['callback'];

          if($isParam){
            // /customer/{ID}
            // /customer/543
            // $params = array(ID => 543)
            preg_match_all("/(?<={).+?(?=})/", $route['path'], $matches);
            $params = array($matches[0][0] => $uriParam[0][0]);
          }

          if( is_array($callback) ) {
            [$class, $method] = $route['callback'];

            $object = new $class;
            $callback = [$object, $method];
          }

          call_user_func($callback, $params);
      }
    }

  }

}