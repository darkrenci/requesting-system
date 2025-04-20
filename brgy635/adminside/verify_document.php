<?php
require_once 'connect.php'; // include your database connection

$requestId = $_POST['requestId'];
$residentId = $_POST['residentId'];
$typeId = $_POST['typeId'];

$response = array('valid' => false);

// Set the table based on the typeId
switch ($typeId) {
    case '1':
        $table = 'barangay_clearance';
        break;
    case '2':
        $table = 'business_clearance';
        break;
    case '3':
        $table = 'certificate_of_indigency';
        break;
    case '4':
        $table = 'certificate_of_residency';
        break;
    default:
        echo json_encode($response);
        exit;
}

// Prepare the query
$stmt = $conn->prepare("SELECT * FROM $table WHERE document_type_id = ? AND resident_id = ?");
$stmt->bind_param("ii", $requestId, $residentId);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response = array('valid' => true);
}

echo json_encode($response);
?>