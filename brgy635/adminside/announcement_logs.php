<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_SESSION['user']['username'];
    $announcementTitle = isset($_POST['title']) ? $_POST['title'] : 'Untitled';
    $log_entry = $user['username']. ' ' . "created an announcement titled: '$announcementTitle'";
    insertLog($conn, $actionType, $log_entry);

    echo 'Announcement action logged successfully';
} else {
    echo 'Invalid request method';
}

function insertLog($conn, $log_entry) {
    $log_date = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO logs (action, log_entry, log_date) VALUES (?, ?, ?)");
    $action = 'Create Announcment';
    $stmt->bind_param("sss", $action, $log_entry, $log_date);
    $stmt->execute();
    $stmt->close(); 
}
?>
