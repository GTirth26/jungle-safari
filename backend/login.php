<?php
session_start();
require_once "db.php"; // database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate
    if (empty($email) || empty($password)) {
        die("Both fields are required. <a href='../frontend/login.html'>Go back</a>");
    }

    // Check user
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: ../frontend/admin.html");
            } else {
                header("Location: ../frontend/home.html");
            }
            exit;
        } else {
            echo "Invalid password. <a href='../frontend/login.html'>Try again</a>";
        }
    } else {
        echo "No account found with that email. <a href='../frontend/register.html'>Register here</a>";
    }
}
?>
