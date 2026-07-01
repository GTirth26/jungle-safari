<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'jungle_safaris';

$conn = new mysqli($servername, $username, $password, $dbname, 3307);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// echo "connected successfully".$dbname;

?>