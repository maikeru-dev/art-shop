<?php 
use Src\System\DatabaseConnector;

$dbConn = new DatabaseConnector::getConn();
// heavily inspired by <https://developer.okta.com/blog/2019/03/08/simple-rest-api-php>

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,SET,POST,GET,PUT,DELETE");


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
