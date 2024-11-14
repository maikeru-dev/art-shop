<?php 
require 'src/api/DatabaseConnector.php';
use \Src\Api\DatabaseConnector;
$dbConn = DatabaseConnector::getConn();
// heavily inspired by <https://developer.okta.com/blog/2019/03/08/simple-rest-api-php>

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,SET,POST,GET,PUT,DELETE");


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Check method type
// Check Uri

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($uri[2]) {
case "art":
  echo "art found!";
  break;
case "order":
  echo "order found!";
  break;
case "img":
  echo "img found!";
  break;
default:
  header("HTTP/1.1 404 Not Found");
  die();
}
die();
