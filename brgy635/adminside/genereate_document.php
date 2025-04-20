<?php
// Get the request ID and tab name from the request
$typeId = $_GET['typeId'];
$requestId = $_GET['requestId'];

// Define the file path and name based on the tab
switch ($typeId) {
    case 'barangay_clearance':
        $fileName = 'C:\\xampp\\htdocs\\softeng\\QMS\\Brgy-Clearance.docx';
        break;
    case 'business_clearance':
        $fileName = 'C:\\xampp\\htdocs\\softeng\\QMS\\Brgy-Business-Clearance.docx';
        break;
    case 'certificate_of_indigency':
        $fileName = 'C:\\xampp\\htdocs\\softeng\\QMS\\Cert-of-Indigency.docx';
        break;
    case 'certificate_of_residency':
        $fileName = 'C:\\xampp\\htdocs\\newse\\adminside\\Cert-of-Residency.docx';
        break;
    default:
        echo "Invalid tab name";
        exit;
}

// Generate document content based on the request ID and tab name
switch ($typeId) {
    case 'barangay_clearance':
        $documentContent = generateBarangayClearanceDocument($conn, $requestId);
        break;
    case 'business_clearance':
        $documentContent = generateBusinessClearanceDocument($conn, $requestId);
        break;
    case 'certificate_of_indigency':
        $documentContent = generateCertificateOfIndigencyDocument($conn, $requestId);
        break;
    case 'certificate_of_residency':
        $documentContent = generateCertificateOfResidencyDocument($conn, $requestId);
        break;
}

// Create a temporary file to store the document content
$tmpFile = tempnam(sys_get_temp_dir(), 'doc_');
file_put_contents($tmpFile, $documentContent);

// Copy the temporary file to the WordPad file
copy($tmpFile, $fileName);

// Execute command to open the file with WordPad
shell_exec("start WordPad \"$fileName\"");

// Remove the temporary file
unlink($tmpFile);

// Functions to generate document content for each type
function generateBarangayClearanceDocument($conn, $requestId) {
    // Query to fetch data for Barangay Clearance document
    $query = "SELECT * FROM barangay_clearance WHERE id = $requestId";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    // Generate document content using the fetched data
    $documentContent = "
        <h1>Barangay Clearance</h1>
        <p>Name: {$data['req_name']}</p>
        <p>Address: {$data['postal_address']}</p>
        <p>Purpose: {$data['purpose']}</p>
    ";
    return $documentContent;
}

// Function to generate document content for Business Clearance
function generateBusinessClearanceDocument($conn, $requestId) {
    // Query to fetch data for Business Clearance document
    $query = "SELECT * FROM business_clearance WHERE id = $requestId";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    // Generate document content using the fetched data
    $documentContent = "
        <h1>Business Clearance</h1>
        <p>Business Name: {$data['business_name']}</p>
        <p>Address: {$data['business_address']}</p>
        <p>Purpose: {$data['purpose']}</p>
    ";
    return $documentContent;
}

// Function to generate document content for Certificate of Indigency
function generateCertificateOfIndigencyDocument($conn, $requestId) {
    // Query to fetch data for Certificate of Indigency document
    $query = "SELECT * FROM certificate_of_indigency WHERE id = $requestId";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    // Generate document content using the fetched data
    $documentContent = "
        <h1>Certificate of Indigency</h1>
        <p>Name: {$data['req_name']}</p>
        <p>Address: {$data['postal_address']}</p>
        <p>Purpose: {$data['purpose']}</p>
    ";
    return $documentContent;
}

// Function to generate document content for Certificate of Residency
function generateCertificateOfResidencyDocument($conn, $requestId) {
    // Query to fetch data for Certificate of Residency document
    $query = "SELECT * FROM certificate_of_residency WHERE id = $requestId";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    // Generate document content using the fetched data
    $documentContent = "
        <h1>Certificate of Residency</h1>
        <p>Name: {$data['req_name']}</p>
        <p>Address: {$data['postal_address']}</p>
        <p>Purpose: {$data['purpose']}</p>
    ";
    return $documentContent;
}