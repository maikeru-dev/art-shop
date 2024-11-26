<?php

namespace Src\Api\TableGateways;

require_once 'src/api/gateways/Gateway.php';

use \Src\Api\TableGateways\Gateway;

class ArtGateway extends Gateway
{

  public function tableName()
  {
    return "art_items";
  }

  public function tableColumns()
  {
    return [
      'name' => 's',
      'date_of_completion' => 's',
      'width' => 'd',
      'height' => 'd',
      'price' => 'd',
      'description' => 's',
      'img' => 's'
    ];
  }

  public function __construct($db)
  {
    $this->db = $db;
  }
}
