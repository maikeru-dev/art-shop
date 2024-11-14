<?php
require 'src/api/controllers/Controller.php';
namespace Src\Api\Controllers;

class ImgController extends Controller {
  private $artGateway;

  public function __construct($db, $requestMethod, $query) {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->query = $query;

    $artGateway = new ImgGateway($db);
  }

  protected function getResponse(...$params) {

  }
  protected function postResponse(...$params) {

  }
  protected function putResponse(...$params) {

  }
  protected function deleteResponse(...$params) {

  }


} 
