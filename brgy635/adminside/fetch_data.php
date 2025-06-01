<?php
include 'connect.php';

$section = $_GET['section'];
$document_type_id = isset($_GET['document_type_id']) ? $_GET['document_type_id'] : null;
$requestId = isset($_GET['requestId']) ? $_GET['requestId'] : null;
$response = [];

if ($section == 'dashboard') {
    // Fetch data for dashboard
    $numUsersQuery = "SELECT COUNT(*) as numUsers FROM resident";
    $numUsersResult = $conn->query($numUsersQuery);
    $response['numUsers'] = $numUsersResult->fetch_assoc()['numUsers'];

    $numBarangayClearanceQuery = "SELECT COUNT(*) as numBarangayClearance FROM barangay_clearance";
    $numBarangayClearanceResult = $conn->query($numBarangayClearanceQuery);
    $response['numBarangayClearance'] = $numBarangayClearanceResult->fetch_assoc()['numBarangayClearance'];

    $numBusinessClearanceQuery = "SELECT COUNT(*) as numBusinessClearance FROM business_clearance";
    $numBusinessClearanceResult = $conn->query($numBusinessClearanceQuery);
    $response['numBusinessClearance'] = $numBusinessClearanceResult->fetch_assoc()['numBusinessClearance'];

    $numIndigencyQuery = "SELECT COUNT(*) as numIndigency FROM certificate_of_indigency";
    $numIndigencyResult = $conn->query($numIndigencyQuery);
    $response['numIndigency'] = $numIndigencyResult->fetch_assoc()['numIndigency'];

    $numResidencyQuery = "SELECT COUNT(*) as numResidency FROM certificate_of_residency";
    $numResidencyResult = $conn->query($numResidencyQuery);
    $response['numResidency'] = $numResidencyResult->fetch_assoc()['numResidency'];

    $numMaleUsersQuery = "SELECT COUNT(*) as numMale FROM resident WHERE gender = 'male'";
    $numMaleUsersResult = $conn->query($numMaleUsersQuery);
    $response['numMale'] = $numMaleUsersResult->fetch_assoc()['numMale'];

    $numFemaleUsersQuery = "SELECT COUNT(*) as numFemale FROM resident WHERE gender = 'female'";
    $numFemaleUsersResult = $conn->query($numFemaleUsersQuery);
    $response['numFemale'] = $numFemaleUsersResult->fetch_assoc()['numFemale'];
}

elseif ($section == 'docRequest') {
    // Fetch data for document requests
    $response['barangayClearance'] = fetchDocumentRequests($conn, 'barangay_clearance');
    $response['businessClearance'] = fetchDocumentRequests($conn, 'business_clearance');
    $response['indigency'] = fetchDocumentRequests($conn, 'certificate_of_indigency');
    $response['residency'] = fetchDocumentRequests($conn, 'certificate_of_residency');

      // Include typeId and requestId in the response
      $response['typeId'] = $_GET['typeId'];
      $response['requestId'] = $_GET['requestId'];
}

elseif ($section == 'listUsers') {
    // Fetch data for list of users
    $usersQuery = "SELECT id,fname, lname, mname, phone, gender, citizen, hnum, street, email, birthday FROM resident";
    $usersResult = $conn->query($usersQuery);
    $users = [];
    while ($row = $usersResult->fetch_assoc()) {
        $users[] = $row;
    }
    $response['users'] = $users;
}


elseif ($section == 'logs') {
    // Fetch data for logs (Assuming you have a logs table)
    $logsQuery = "SELECT log_entry, log_date FROM logs";
    $logsResult = $conn->query($logsQuery);
    $logs = [];
    while ($row = $logsResult->fetch_assoc()) {
        $logs[] = $row;
    }
    $response['logs'] = $logs;
}

elseif ($section == 'docDetails') {
    $requestId = $_GET['requestId'];
    if ($requestId == 'barangayClearance') {
        $response = fetchDocumentDetails($conn, 'barangay_clearance');
    } elseif ($requestId == 'businessClearance') {
        $response = fetchDocumentDetails($conn, 'business_clearance');
    } elseif ($requestId == 'indigency') {
        $response = fetchDocumentDetails($conn, 'certificate_of_indigency');
    } elseif ($requestId == 'residency') {
        $response = fetchDocumentDetails($conn, 'certificate_of_residency');
    }
    }elseif ($section == 'logs') {
        // Fetch data for logs
        $logsQuery = "SELECT log_entry, log_date FROM logs";
        $logsResult = $conn->query($logsQuery);
        $logs = [];
        while ($row = $logsResult->fetch_assoc()) {
            $logs[] = $row;
        }
        $response['logs'] = $logs;
    }



echo json_encode($response);

function fetchDocumentRequests($conn) {
    $query = "SELECT id, '1' AS document_type_id FROM barangay_clearance
              UNION ALL 
              SELECT id, '2' AS document_type_id FROM business_clearance
              UNION ALL 
              SELECT id, '3' AS document_type_id FROM certificate_of_indigency
              UNION ALL 
              SELECT id, '4' AS document_type_id FROM certificate_of_residency";
    $result = $conn->query($query);
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    return $requests;
}




function fetchRequestsFromTable($conn, $table) {
    $query = "SELECT id FROM $table";
    $result = $conn->query($query);
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    return $requests;
}


function getTableName($typeId) {
    switch ($typeId) {
        case 'barangay_clearance':
            return 'barangay_clearance';
        case 'business_clearance':
            return 'business_clearance';
        case 'certificate_of_indigency':
            return 'certificate_of_indigency';
        case 'certificate_of_residency':
            return 'certificate_of_residency';
        default:
            return null; // or throw an exception if typeId is invalid
    }
}

function fetchDocumentDetails($conn, $table) {
    $query = "SELECT * FROM $table";
    $result = $conn->query($query);
    $details = [];
    while ($row = $result->fetch_assoc()) {
        // Generate the dropdown for Queue Status
        $row['Queue Status'] = "
            <select class='queue-status-dropdown' data-request-id='{$row['id']}' data-table='{$table}'>
                <option value='Action' " . ($row['Queue Status'] == 'Action' ? 'selected' : '') . ">Action</option>
                <option value='Pending' " . ($row['Queue Status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                <option value='processing' " . ($row['Queue Status'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                 <option value='Rejected' " . ($row['Queue Status'] == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                <option value='ready to claim' " . ($row['Queue Status'] == 'Ready to claim' ? 'selected' : '') . ">Ready to claim</option>
            </select>
        ";
        $details[] = $row;
    }
    return $details;
}


?>