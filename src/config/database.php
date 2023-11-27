<?php
// Database configuration
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$database = 'test1';

// Create a connection
$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>