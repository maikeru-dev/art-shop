<?php

require 'src/api/DatabaseConnector.php';
use \Src\Api\DatabaseConnector;

$dbConn = DatabaseConnector::getConn();

$sqlCreate = "CREATE TABLE IF NOT EXISTS art_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    date_of_completion smallint,
    width DECIMAL(5,2),
    height DECIMAL(5,2),
    price DECIMAL(15,2),
    description TEXT
);";

$dbConn->query($sqlCreate);

