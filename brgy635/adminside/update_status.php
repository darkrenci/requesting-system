<?php
session_start(); // Add this at the very top to use session variables

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Make sure the user is logged in
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        echo 'User not logged in';
        exit;
    }

    $requestId = $_POST['requestId'];
    $newStatus = $_POST['status'];
    $table = $_POST['table'];

    // Validate table name to prevent SQL injection
    $validTables = ['barangay_clearance', 'business_clearance', 'certificate_of_indigency', 'certificate_of_residency'];
    if (!in_array($table, $validTables)) {
        echo 'Invalid table name';
        exit;
    }

    // Prepare the SQL statement to update the status
    $query = "UPDATE $table SET `Queue Status` = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $newStatus, $requestId);
    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        echo 'Error: ' . $stmt->error;
        exit;
    }

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // Get session details
        $admin_id = $_SESSION['user_id']; // from session
        $username = $_SESSION['username']; // from session

        // Insert log with dynamic username
        $log_entry = $username . " updated queue status to '$newStatus' for request ID $requestId in table $table.";
        insertLog($conn, $admin_id, $log_entry);

        echo 'Status updated successfully';
    } else {
        echo 'Failed to update status';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method';
}

// Updated insertLog function to accept $admin_id
function insertLog($conn, $admin_id, $log_entry) {
    $log_date = date('Y-m-d H:i:s');
    $action = 'Update'; // Adjust this as needed
    $stmt = $conn->prepare("INSERT INTO logs (admin_id, action, log_entry, log_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $admin_id, $action, $log_entry, $log_date);
    $stmt->execute();
    $stmt->close();
}
?>
