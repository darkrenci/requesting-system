<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestId = $_POST['requestId'];
    $log_entry = "Admin generated a document: $requestId";
    insertLog($conn, $log_entry);
    echo 'Document generation logged successfully';
} else {
    echo 'Invalid request method';
}

function insertLog($conn, $log_entry) {
    $log_date = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO logs (action, log_entry, log_date) VALUES (?, ?, ?)");
    $action = 'Document Generation';
    $stmt->bind_param("sss", $action, $log_entry, $log_date);
    $stmt->execute();
    $stmt->close();
}
?>
