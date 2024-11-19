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
    
    // PHP does not crash when parameters_length < arguments_length (user defined definitions only, does not apply to php base defs)
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


  protected function fetchPHPInput(){
    // Take input from request body, then decode into assoc array
    return (array) json_decode(file_get_contents('php://input', TRUE));
  }

  protected function createdResponse() {
    $response['statusCodeHeader'] = 'HTTP/1.1 201 Created';
    $response['body'] = null;
    return $response;
  }
  protected function successResponse() {
    $response['statusCodeHeader'] = 'HTTP/1.1 200 OK';
    $response['body'] = null;
    return $response;
  }
  protected function successResponse($body) {
    $response = $this->successResponse();
    $response['body'] = $body;
    return $response;
  }
  protected function notFoundResponse() {
      $response['statusCodeHeader'] = 'HTTP/1.1 404 Not Found';
      $response['body'] = null;
      return $response
  }
  protected function adaptGetResponse($rows) {
    return json_encode($rows, JSON_PRETTY_PRINT);
  }
  protected function unprocessableEntityResponse(){
    $response['statusCodeHeader'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = '{"error": "Invalid input"}';
    return $response;
  }
  protected function validateAny($arr, $REQUIRED_KEYS) {
    foreach($REQUIRED_KEYS as $value):
      if (!isset($arr[$value])):
        return false;

    return true;
  }
  
}
