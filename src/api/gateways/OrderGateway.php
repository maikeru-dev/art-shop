<?php

namespace Src\Api\TableGateways;

require_once 'src/api/gateways/Gateway.php';

use \Src\Api\TableGateways\Gateway;

class OrderGateway extends Gateway
{
  public function __construct($db)
  {
    $this->db = $db;
  }

  public function tableName()
  {
    return "orders";
  }

  public function tableColumns()
  {
    return [
      'name' => 's',
      'phone_number' => 's',
      'email' => 's',
      'postal_address' => 's',
    ];
  }
  public function insert($input)
  {
    $db = $this->db;
    $rawStatment = null;
    $this->objCpy($rawStatment, $this->insertPmst());

    $types = $this->produceParallelTypes($input);
    $keys = array_keys($input);
    $values = array_values($input);

    $rawStatment[1] = '(' . implode(", ", $keys) . ')';
    $rawStatment[3] = '(' . $this->parseInputForInsert($input) . ')';

    try {
      $stmt = $db->prepare(implode($rawStatment));
      $stmt->bind_param($types, ...$values);
      if (!$stmt->execute()) {
        return ['value' => null, 'error' => $stmt->error];
      }
    } catch (\Exception $e) {
      return ['value' => null, 'error' => implode($rawStatment)];
    }

    $id = $stmt->insert_id;

    return ['value' => ['msg' => "Rows updated: $stmt->affected_rows", 'id' => $id], 'error' => null];
  }
}
