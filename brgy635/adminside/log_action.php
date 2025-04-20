<?php
session_start();
require_once 'connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: signin.html');
    exit(); // Terminate script execution after redirection
}

// Get the admin ID from the session
$admin_id = $_SESSION['id']; // Adjust this based on your session structure

// Get the action and log entry from the POST request
$action = $_POST['action'];
$log_entry = $_POST['log_entry'];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO logs (id, action, log_entry) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $admin_id, $action, $log_entry);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
