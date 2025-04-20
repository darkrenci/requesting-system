<?php
require 'vendor/autoload.php';
require 'connect.php';

// Check if the 'typeId' parameter is provided
if (isset($_GET['typeId'])) {
    $typeId = $_GET['typeId'];
    $requestId = $_GET['request_id'];

    // Initialize variables to store data and column headers
    $data = [];
    $headers = [];

    // Fetch data based on clearance type
    switch ($typeId) {
        case 'barangay_clearance':
            // Execute SQL query to fetch data for Barangay Clearance
            $sql = "SELECT req_name, postal_address, marital_status, purpose FROM barangay_clearance";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error: ". mysqli_error($conn);
                exit;
            }
            // Fetch column names as headers
            $headers = ['Name', 'Postal Address', 'Marital Status', 'Purpose'];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array_values($row);
            }
            break;
        case 'business_clearance':
            // Execute SQL query to fetch data for Business Clearance
            $sql = "SELECT business_name, business_address, nature_business, proprietor, contact_number, ownership_type FROM business_clearance";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error: ". mysqli_error($conn);
                exit;
            }
            // Fetch column names as headers
            $headers = ['Business Name', 'Business Address', 'Nature of Business', 'Proprietor', 'Contact Number', 'Ownership Type'];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array_values($row);
            }
            break;
        // Add cases for other clearance types (certificate_of_indigency, certificate_of_residency) as needed
    }

    // Generate PDF document with formatted data
    // Initialize HTML content with table structure
    $html = '<html><body><h1>'. ucfirst(str_replace('_', '.', $typeId)). ' Report</h1>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5">';
    // Add column headers to HTML content
    $html .= '<tr>';
    foreach ($headers as $header) {
        $html .= '<th>'. $header. '</th>';
    }
    $html .= '</tr>';
    // Add data rows to HTML content
    foreach ($data as $row) {
$html.= '<tr>';
        foreach ($row as $cell) {
            $html.= '<td>'. $cell. '</td>';
        }
        $html.= '</tr>';
    }
    $html.= '</table></body></html>';

    // Debug: echo out the HTML content
    echo $html;

    // Create PDF object
    $dompdf = new Dompdf\Dompdf();
    // Load HTML content (formatted data)
    $dompdf->loadHtml($html);
    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');
    // Render PDF content
    $dompdf->render();

    // Check if the PDF generation was successful
    if ($dompdf->getErrors()) {
        echo "Error generating PDF: ". implode(", ", $dompdf->getErrors());
        exit;
    }

    // Output PDF to browser
    $filename = ucfirst($typeId). "_Report.pdf";
    $dompdf->stream($filename, array("Attachment" => false));

    // Check if the PDF file was generated successfully
    if (!file_exists($filename)) {
        echo "Error: PDF file not generated.";
    } else {
        echo "PDF file generated successfully.";
    }
} else {
    // Handle case when 'typeId' parameter is not provided
    echo "Error: 'typeId' parameter is missing.";
}
?>