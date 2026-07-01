<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jungle_safaris";

// Return JSON response for easier debugging
header('Content-Type: application/json');

$response = [];

// 1. Create Connection
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// 2. Create Database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    $response[] = "Database '$dbname' created or already exists.";
} else {
    echo json_encode(["status" => "error", "message" => "Error creating database: " . $conn->error]);
    $conn->close();
    exit;
}

// 3. Select Database
$conn->select_db($dbname);

// 4. Create Users Table
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sqlUsers) === TRUE) {
    $response[] = "Table 'users' created or already exists.";
} else {
    $response[] = "Error creating 'users' table: " . $conn->error;
}

// 5. Create Bookings Table
$sqlBookings = "CREATE TABLE IF NOT EXISTS bookings (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    park VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    persons INT(11),
    total VARCHAR(50),
    date VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sqlBookings) === TRUE) {
    $response[] = "Table 'bookings' created or already exists.";
} else {
    $response[] = "Error creating 'bookings' table: " . $conn->error;
}

$conn->close();

echo json_encode(["status" => "success", "logs" => $response]);
?>