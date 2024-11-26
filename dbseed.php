<?php

require 'src/api/DatabaseConnector.php';

use \Src\Api\DatabaseConnector;

$dbConn = DatabaseConnector::getConn();

$sqlCreate = "CREATE TABLE IF NOT EXISTS art_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    date_of_completion DATE,
    width DECIMAL(5,2),
    height DECIMAL(5,2),
    price DECIMAL(15,2),
    description TEXT
);";

$dbConn->query($sqlCreate);

$sqlCreate = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    postal_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

$dbConn->query($sqlCreate);

$sqlCreate = "CREATE TABLE IF NOT EXISTS art_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    art_id INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (art_id) REFERENCES art_items(id) ON DELETE CASCADE
);";

$dbConn->query($sqlCreate);
