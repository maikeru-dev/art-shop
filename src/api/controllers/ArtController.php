<?php

namespace Src\Api\Controllers;

require_once 'src/api/gateways/ArtGateway.php';
require_once 'src/api/controllers/Controller.php';

use \Src\Api\TableGateways\ArtGateway;

class ArtController extends Controller
{
  private $artGateway;

  public function __construct($db, $requestMethod, $query)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->query = $query;

    $this->artGateway = new ArtGateway($db);
  }

  /**
   * # dbKeys
   *
   * This method is responsible for making the validateAny function
   * in the abstract class Controller work. Used for validation of $input.
   *
   * @return the list of columns for the Art Table
   * */
  public function dbKeys()
  {
    // This is the only way I know of ensuring that this variable is instantiated.
    // At least with a good error message.
    return ['name', 'date_of_completion', 'width', 'height', 'price', 'description', 'img']; // img is required here.
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
  protected function getResponse(...$params)
  {
    $size = sizeof($params);
    $response = $this->notFoundResponse();

    if ($size == 1 && isset($params["id"])) // id present
      return $this->successResponse($this->adaptGetResponse($this->artGateway->find($params["id"])));

    if ($size == 0) // get all
      return $this->successResponse($this->adaptGetResponse($this->artGateway->findAll()));

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
  protected function postResponse(...$params)
  {
    $input = $this->fetchPHPInput();

    if (!parent::validateAny($input))
      return $this->unprocessableEntityResponse("Bad POST input, got: [" . implode(", ", array_keys($input)) . "]");

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
  protected function putResponse(...$params)
  {
    $size = sizeof($params);

    if ($size == 0)
      return $this->notFoundResponse();
    if ($size > 1)
      return $this->unprocessableEntityResponse("Too Many Route Inputs On Put");

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
  protected function deleteResponse(...$params)
  {
    $size = sizeof($params);

    if ($size == 0)
      return $this->notFoundResponse();
    if ($size > 1)
      return $this->unprocessableEntityResponse("Too Many Route Inputs On Delete");

    $input = $this->fetchPHPInput();

    $this->artGateway->delete($params["id"], $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }
}
