<?php
require 'src/api/controllers/Controller.php';
require 'src/api/gateways/ImgGateway.php';

namespace Src\Api\Controllers;

use \Src\Api\TableGateways\ImgGateway;

class ImgController extends Controller
{
  private $imgGateway;


  public function __construct($db, $requestMethod, $query)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->query = $query;

    $imgGateway = new ImgGateway($db);
  }

  /**
   * # dbKeys
   *
   * This method is responsible for making the validateAny function
   * in the abstract class Controller work. Used for validation of $input.
   *
   * @return the list of columns for the Img Table
   * */
  public function dbKeys() // FIXME: UPDATE

  {
    // This is the only way I know of ensuring that this variable is instantiated.
    // At least with a good error message.
    return [];
  }

  /**
   * # Get Img 
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

    if ($size == 1) // id present
      return $this->successResponse($this->adaptGetResponse($this->imgGateway->find($params["id"])));

    if ($size == 0) // get all
      return $this->successResponse($this->adaptGetResponse($this->imgGateway->findAll()));


    return $response;
  }
  /**
   * # Post Img
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
      return $this->unprocessableEntityResponse();

    $this->imgGateway->insert($input);

    return $this->createdResponse();
  }

  /**
   * # Put Img
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
      return $this->unprocessableEntityResponse();

    $input = $this->fetchPHPInput();

    $this->imgGateway->update($params["id"], $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }

  /**
   * # Delete Img
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
      return $this->unprocessableEntityResponse();

    $input = $this->fetchPHPInput();

    $this->imgGateway->delete($id, $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }


  protected function validateImg($arr)
  { // FIXME: ADD IMG SUPPORT
    throw new Exception("Can't run this! See validateImg at ImgController.");
    $REQUIRED_KEYS = $dbKeys;
    return $this->validateAny($arr, $REQUIRED_KEYS);
  }
}
