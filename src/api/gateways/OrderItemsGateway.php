<?php

namespace Src\Api\TableGateways;

require_once 'src/api/gateways/Gateway.php';

use \Src\Api\TableGateways\Gateway;

class OrderItemsGateway extends Gateway
{
  public function __construct($db)
  {
    $this->db = $db;
  }
  protected function findIdPmst()
  {
    return "SELECT * FROM " . $this->tableName() . " WHERE order_id = ?;";
  }

  public function tableName()
  {
    return "art_orders";
  }

  public function tableColumns()
  {
    return [
      'order_id' => 'i',
      'art_id' => 'i',
    ];
  }
}
