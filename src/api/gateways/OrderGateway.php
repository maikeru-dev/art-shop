<?php

namespace Src\Api\TableGateways;


class OrderGateway {
  private $db = null;

  public function __construct($db) {
    $this->db = $db;
  }

  public function findAll() {
    // TODO: Implement
  }

  public function find($id) {
    // TODO: Implement

  }
}
