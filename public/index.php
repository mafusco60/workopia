<?php

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

use Framework\Router;

/* spl_autoload_register(function ($class){
  $path = basepath('Framework/' . $class . '.php');
  if(file_exists($path)){
    require $path;
  }
}); */

//Instantiate the router
$router = new Router();

//Get routes
$routes = require basePath('routes.php');

//Get current URI and http method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);