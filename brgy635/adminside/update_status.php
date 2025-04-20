<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        // Insert log
        $log_entry = "Admin updated queue status to '$newStatus' for request ID $requestId in table $table.";
        insertLog($conn, $log_entry);
        
        echo 'Status updated successfully';
    } else {
        echo 'Failed to update status';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method';
}

function insertLog($conn, $log_entry) {
    $log_date = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO logs (admin_id, action, log_entry, log_date) VALUES (?, ?, ?, ?)");
    // Assuming you have an admin ID, replace '1' with the actual admin ID
    $admin_id = 1;
    $action = 'Update'; // Adjust this as per the action being performed
    $stmt->bind_param("isss", $admin_id, $action, $log_entry, $log_date);
    $stmt->execute();
    $stmt->close();
}
?>
