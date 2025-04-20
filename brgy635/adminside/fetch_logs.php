<?php
session_start();
require_once 'connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: signin.html');
    exit();
}

$query = "SELECT log_entry, log_date FROM logs ORDER BY log_date DESC";
$result = $conn->query($query);

$logs = [];
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['logs' => $logs]);

$conn->close();
?>
