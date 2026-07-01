<?php
// Database configuration
require_once 'db.php';

// Check connection (db.php already checks, but double check if needed or just rely on db.php)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Detect form submission (after JavaScript redirect OR direct POST)
$showPayment = false;
$bookingData = [
    'park' => '',
    'name' => '',
    'phone' => '',
    'email' => '',
    'persons' => '',
    'total' => '',
    'date' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If you later submit this form via POST instead of JS redirect
    $showPayment = true;
    $bookingData['park'] = $_POST['nationalPark'] ?? '';
    $bookingData['name'] = trim(($_POST['firstName'] ?? '') . ' ' . ($_POST['middleName'] ?? '') . ' ' . ($_POST['lastName'] ?? ''));
    $bookingData['phone'] = $_POST['contactNumber'] ?? '';
    $bookingData['email'] = $_POST['email'] ?? '';
    $bookingData['persons'] = $_POST['numPersons'] ?? '';
    $bookingData['total'] = '₹' . ((int) ($_POST['numPersons'] ?? 1) * 1000);
    $bookingData['date'] = date('d/m/Y');

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO bookings (park, name, phone, email, persons, total, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $bookingData['park'], $bookingData['name'], $bookingData['phone'], $bookingData['email'], $bookingData['persons'], $bookingData['total'], $bookingData['date']);

    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        header("Location: ../frontend/success.html"); // Assuming success.html is in frontend folder
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} elseif (!empty($_GET)) {
    // After your JavaScript redirect to payment.html?...
    $showPayment = true;
    $bookingData['park'] = $_GET['park'] ?? '';
    $bookingData['name'] = $_GET['name'] ?? '';
    $bookingData['phone'] = $_GET['phone'] ?? '';
    $bookingData['email'] = $_GET['email'] ?? '';
    $bookingData['persons'] = $_GET['persons'] ?? '';
    $bookingData['total'] = $_GET['total'] ?? '';
    $bookingData['date'] = $_GET['date'] ?? '';
}
?>