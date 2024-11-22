<?php
namespace Src\Api\TableGateways;

require 'src/api/gateways/Gateway.php';
use \Src\Api\TableGateways\Gateway;

class ArtGateway extends Gateway {

  public function tableName() {
    return "art_items";
  }

  public function tableColumns() {
    return [
      'name' => 's',
      'date_of_completion' => 'i',
      'width' => 'd',
      'height' => 'd',
      'price' => 'd',
      'description' => 's'
    ];
  }

  public function __construct($db) {
    $this->db = $db;
  }
}
