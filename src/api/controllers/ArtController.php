<?php
require 'src/api/controllers/Controller.php';
namespace Src\Api\Controllers;

class ArtController extends Controller {
  private $artGateway;

  public function __construct($db, $requestMethod, $query) {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->query = $query;

    $artGateway = new ArtGateway($db);
  }

  /**
   * # Get Art
   *
   * When passing an argument (id), the function will return one row.
   * Passing nil arguments returns all the rows of the Art Table.
   *
   * Argument should be an array with optional key "id", or it should be named exactly "$id".
   *
   * @version 1.0
   * @param id (optional)
   * @return response ["header", "body"] | 404 on key failure
   */
  protected function getResponse(...$params) {
    $size = sizeof($params);
    $response = $this->notFoundResponse();

    if ($size == 1): // id present
      return $this->successResponse($this->adaptGetResponse($this->artGateway->getId($params["id"])));
    
    if ($size == 0): // get all
      return $this->successResponse($this->adaptGetResponse($this->artGateway->getAll()))
    

    return $response;
  }
  /**
   * # Post Art
   * ## Create/Insert method
   * This function takes no parameters.
   *
   * @version 1.0
   * @return response ["header", "body"]
   */
  protected function postResponse(...$params) {
    $input = $this->fetchPHPInput();

    if (!validateArt($input))
      return $this->unprocessableEntityResponse();

    $this->artGateway->insert($input);

    return $this->createdResponse();
  }

  /**
   * # Put Art
   * ## Update method
   *
   * When passing an argument (id), the function will return one row.
   * Passing nil arguments returns all the rows of the Art Table.
   *
   * Argument should be an array with optional key "id", or it should be named exactly "$id".
   *
   * **Expects input on request body**
   * @version 1.0
   * @param id (optional)
   */
  protected function putResponse(...$params) {
    $size = sizeof($params);

    if ($size == 0):
      return $this->notFoundResponse();
    if ($size > 1):
      return $this->unprocessableEntityResponse();

    $input = $this->fetchPHPInput();

    $this->artGateway->update($params["id"], $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }

  /**
   * # Delete Art
   * ## Delete method
   *
   * When passing an argument (id), the function will return one row.
   * Passing nil arguments returns all the rows of the Art Table.
   *
   * Argument should be an array with optional key "id", or it should be named exactly "$id".
   *
   * **Expects input on request body**
   * @version 1.0
   * @param id (optional)
   */
  protected function deleteResponse(...$params) {
    $size = sizeof($params);

    if ($size == 0):
      return $this->notFoundResponse();
    if ($size > 1):
      return $this->unprocessableEntityResponse();

    $input = $this->fetchPHPInput();

    $this->artGateway->delete($id, $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }
  

  protected function validateArt($arr){
    $REQUIRED_KEYS = ['name', 'date_of_completion', 'width', 'height', 'price', 'description'];
    return $this->validateAny($arr, $REQUIRED_KEYS);
  }

} 
