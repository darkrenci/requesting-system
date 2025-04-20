
<?php
// delete_request.php

require 'connect.php'; // Include the database connection file

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the requestId and residentId from the POST parameters
    $requestId = $_POST['request_id'];
    $residentId = $_POST['resident_id'];

    // Determine the table based on the requestId
    switch ($requestId) {
        case 'barangayClearance':
            $table = 'barangay_clearance';
            break;
        case 'businessClearance':
            $table = 'business_clearance';
            break;
        case 'indigency':
            $table = 'certificate_of_indigency';
            break;
        case 'residency':
            $table = 'certificate_of_residency';
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid request ID']);
            exit;
    }

    //get some information from the table before deleting it
    // $fetchRecord = "SELECT * FROM $table WHERE resident_id = '$residentId'";
    // $result = mysqli_query($conn, $fetchRecord);
    // $row = mysqli_fetch_assoc($result);
    // $information = $row['information'];
    // $information = json_decode($information, true);
    // $information = $information['information'];
    // $information = json_encode($information);
    // $information = json_decode($information, true);
    // $information = $information['information'];
    // $information = json_encode($information);
    // $information = json_decode($information, true);
    // $information = $information['information'];
    // $information = json_encode($information);


    // Prepare the SQL statement to delete the record
    $sql = "DELETE FROM $table WHERE resident_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $residentId); // Assuming resident_id is an integer
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        $log_entry = "Admin Deleted $requestId requested by resident id: $residentId.";
        insertLog($conn, $log_entry);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Request not found']);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
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
