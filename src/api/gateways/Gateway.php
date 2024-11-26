<?php

namespace Src\Api\TableGateways;

abstract class Gateway
{
  abstract public function tableColumns();
  abstract public function tableName();

  protected $db = null;
  protected function findIdPmst()
  {
    return "SELECT * FROM " . $this->tableName() . " WHERE id = ?;";
  }
  protected function findAllPmst()
  {
    return "SELECT * FROM " . $this->tableName() . ";";
  }
  protected function deleteIdPmst()
  {
    return "DELETE FROM " . $this->tableName() . " WHERE id = ?;";
  }
  protected function insertPmst()
  {
    return ["INSERT INTO " . $this->tableName() . " ", null, " VALUES ", null, ";"];
  }
  protected function updateIdPmst()
  {
    return ["UPDATE " . $this->tableName() . " SET ", null, " WHERE id = ?;"];
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
    } catch (\Exception $e) {
      return ['value' => null, 'error' => implode($rawStatment)];
    }

    if (!$stmt->execute()) {
      return ['value' => null, 'error' => $stmt->error];
    }

    return ['value' => "Rows updated: $stmt->affected_rows", 'error' => null];
  }

  public function update($id, $input)
  {
    $db = $this->db;
    $rawStatement = null;
    $this->objCpy($rawStatement, $this->updateIdPmst()); // pure sugar

    $setPrepared = $this->parseInputForUpdate($input);
    $types = $this->produceParallelTypes($input) . 'i'; // see bind_param for why concat
    $values = array_values($input); // this set should be parallel to $types.

    $rawStatement[1] = $setPrepared;

    $stmt = $db->prepare(implode($rawStatement));
    $values[] = $id; // need id at the end!
    $stmt->bind_param($types, ...$values);

    if (!$stmt->execute()) {
      return ['value' => null, 'error' => $stmt->error];
    }

    return ['value' => "Rows updated: $stmt->affected_rows", 'error' => null];
  }


  public function find($id)
  {
    $db = $this->db;

    $stmt = $db->prepare($this->findIdPmst());
    $stmt->bind_param("i", $id);

    if (!($stmt->execute())) {
      return ['value' => null, 'error' => $stmt->error];
    }

    return ['value' => $stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'error' => null];
  }
  public function delete($id)
  {
    $db = $this->db;

    $stmt = $db->prepare($this->deleteIdPmst());
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
      return ['value' => null, 'error' => $stmt->error];
    }

    return ['value' => "Rows updated: $stmt->affected_rows", 'error' => null];
  }

  public function findAll()
  {
    $db = $this->db;

    $stmt = $db->prepare($this->findAllPmst());

    if (!($stmt->execute())) {
      return ['value' => null, 'error' => $stmt->error];
    }

    return ['value' => $stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'error' => null];
  }
  protected function produceParallelTypes($input)
  {
    $output = "";
    $cols = $this->tableColumns();

    foreach (array_keys($input) as $key) {
      $output .= $cols[$key];
    }

    return $output;
  }

  protected function parseInputForInsert($input)
  {
    return str_repeat("?, ", count($input) - 1) . "?";
  }

  /**
   * # parseInputForUpdate
   *  
   *  This function takes the columns and values and adapts them to
   *  work for mySQL SET statement.
   *
   *  @param $input, valid assoc array of response body
   *  @return "key = ?," pattern string
   */
  protected function parseInputForUpdate($input)
  {
    $output = "";

    foreach (array_keys($input) as $key) {
      $output += "$key = ?,";
    }

    return trim($output, ',');
  }

  protected function objCpy(&$destination, $source)
  {
    $destination = $source;
  }
}
