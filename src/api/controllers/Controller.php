<?php

namespace Src\Api\Controllers;

abstract class Controller {
  protected $db;
  protected $requestMethod;
  protected $query;

  public function processRequest() {
    $responseFn = $this->notFoundResponse; // default case
    switch ($this->requestMethod) {
    case 'GET':
      $responseFn = $this->getResponse;
      break;
    case 'POST':
      $responseFn = $this->postResponse;
      break;
    case 'PUT':
      $responseFn = $this->putResponse;
      break;
    case 'DELETE':
      $responseFn = $this->deleteResponse;
      break;
    } // This is lazy.
    
    // PHP does not crash when parameters_length < arguments_length (user defined only)
    $response = $response($this->query);
    header($response['status_code_header']);
    if ($response['body']) {
      echo $response['body'];
    }
  
  }

  abstract protected function getResponse(...$params);
  abstract protected function postResponse(...$params);
  abstract protected function putResponse(...$params);
  abstract protected function deleteResponse(...$params);

  protected function notFoundResponse() {
      $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
      $response['body'] = null;
      return $response
  }
  
}
