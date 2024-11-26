<?php

namespace Src\Api\Controllers;

require_once 'src/api/controllers/Controller.php';
require_once 'src/api/gateways/OrderGateway.php';
require_once 'src/api/gateways/OrderItemsGateway.php';

use \Src\Api\TableGateways\OrderGateway;
use Src\Api\TableGateways\OrderItemsGateway;

class OrderController extends Controller
{
  private $orderGateway;
  private $orderItemsGateway;

  public function __construct($db, $requestMethod, $query)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->query = $query;

    $this->orderItemsGateway = new OrderItemsGateway($db);
    $this->orderGateway = new OrderGateway($db);
  }

  public function dbKeys()
  {
    return ['name', 'phone_number', 'email', 'postal_address', 'ids'];
  }
  /**
   * # Get Order
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

    if ($size == 1) {
      // id present
      $array = $this->orderGateway->find($params["id"]);
      $length = count($array['value']);
      for ($x = 0; $x < $length; $x++) {
        $ref = &$array['value'][$x]["item_ids"];
        $ref = [];
        foreach ($this->orderItemsGateway->find($array['value'][$x]["id"])['value'] as $row) {
          $ref[] = $row['art_id'];
        }
        $ref = implode(", ", $ref);
      }
      return $this->successResponse($this->adaptGetResponse($array));
    }

    if ($size == 0) {
      // get all 
      $array = $this->orderGateway->findAll();
      $length = count($array['value']);
      for ($x = 0; $x < $length; $x++) {
        $ref = &$array['value'][$x]["item_ids"];
        $ref = [];
        foreach ($this->orderItemsGateway->find($array['value'][$x]["id"])['value'] as $row) {
          $ref[] = $row['art_id'];
        }
        $ref = implode(", ", $ref);
      }
      return $this->successResponse($this->adaptGetResponse($array));
    }

    return $response;
  }


  /**
   * # Post Order
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
      return $this->unprocessableEntityResponse("Invalid input, " . count($this->dbKeys()));
    $ids = $input['ids'];
    unset($input['ids']);

    $result = $this->orderGateway->insert($input);
    $orderId = $result['value']['id']; // special orderGateway override
    if ($result['error']) {
      return $this->serverErrorResponse($result['error']);
    }
    foreach ($ids as $id) {
      if ($result = $this->orderItemsGateway->insert(['art_id' => $id, 'order_id' => $orderId])) {
        if ($result['error']) {
          return $this->serverErrorResponse($result['error']);
        } // else just keep going until done
      }
    }


    return $this->createdResponse();
  }

  /**
   * # Put Order
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
      return $this->unprocessableEntityResponse("Too Many Routes");

    $input = $this->fetchPHPInput();

    $this->orderGateway->update($params["id"], $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }

  /**
   * # Delete Order
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
      return $this->unprocessableEntityResponse("Too Many Routes");

    $input = $this->fetchPHPInput();

    $this->orderGateway->delete($params["id"], $input); // TODO: EXPECT ERRORS

    return $this->successResponse();
  }
}
