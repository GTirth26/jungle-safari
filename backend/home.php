<?php
include 'db.php';
session_start();

// Database connection
$servername = "localhost";
$username   = "root";      // your DB username
$password   = "";          // your DB password
$dbname     = "jungale_safaris";  // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Query to check username and password
    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login success
        $_SESSION['username'] = $user;
        header("Location: ../home.html");  // redirect to home page
        exit();
    } else {
        // Login failed
        echo "<script>alert('Invalid Username or Password'); window.location='login.html';</script>";
    }
}
$conn->close();
?>
