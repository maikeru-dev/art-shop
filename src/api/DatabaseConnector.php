<?php
namespace Src\System;
// heavily inspired by 
// <https://developer.okta.com/blog/2019/03/08/simple-rest-api-php>
class DatabaseConnector {
  private static $dbConnection = null;

  private function __construct() {  
    $databaseHost = 'localhost';
    $databaseUsername = 'mysql';
    $databasePassword = 'mysql';
    $databaseName = 'artShop';
    
    $artTable = 'art_items';
    $ordersTable = 'orders';
    
    self::$dbConnection = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
    
    if (self::$dbConnection->connect_error){
      throw new Throwable("Connection failed! " . $mysqli->connect_error);
    }
  }

  public static function getConn() {
    if (!isset(self::$dbConnection)) {
      self::$dbConnection = new DatabaseConnector();
    }
    return self::$dbConnection;
  }
}



