<?php
require 'src/api/DatabaseConnector.php';
require 'src/utilities/Util.php';
require 'src/api/controllers/ArtController.php';

use Src\Api\Controllers\ArtController;
use Src\Api\DatabaseConnector;

$dbConn = DatabaseConnector::getConn();
// heavily inspired by <https://developer.okta.com/blog/2019/03/08/simple-rest-api-php>

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,SET,POST,GET,PUT,DELETE");


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Check method type
// Check Uri

$requestMethod = $_SERVER['REQUEST_METHOD'];
$controller = null;
$id = $uri[3];



switch ($uri[2]) {
  case "art":
    $controller = new ArtController($dbConn, $requestMethod, isset($uri[3]) ? ["id" => $id] : []);
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

$controller->processRequest();
die();
