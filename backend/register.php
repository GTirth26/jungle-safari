<?php
session_start();
require_once "db.php"; // database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Email already registered. <a href='../frontend/login.html'>Login</a>";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        header("Location: ../frontend/login.html?registered=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
