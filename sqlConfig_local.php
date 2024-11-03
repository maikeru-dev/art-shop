<?php 

$databaseHost = 'localhost';
$databaseUsername = 'mysql';
$databasePassword = 'mysql';
$databaseName = 'artShop';

$artTable = 'art_items';
$ordersTable = 'orders';

$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

if ($mysqli->connect_error){
  throw new Throwable("Connection failed! " . $mysqli->connect_error);
}
?>
