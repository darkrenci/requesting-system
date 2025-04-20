<?php
require 'vendor/autoload.php';
require 'connect.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Instantiate Dompdf with the default options
$options = new Options();
$options->set('defaultFont', 'Courier');
$dompdf = new Dompdf($options);

$options->set('chroot', realpath(''));

// Fetch data for the certificate
$resident_id = $_GET['residentId']; // Assign the value of $_GET['residentId'] to $resident_id

$sql = "SELECT business_name, business_address, nature_business, proprietor, contact_number, ownership_type FROM business_clearance WHERE resident_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $resident_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $certificate_result = $result->fetch_assoc();
        } else {
            die("No data found for the given resident ID");
        }
    } else {
        die("Error executing query: " . $stmt->error);
    }
    $stmt->close();
} else {
    die("Error preparing query: " . $conn->error);
}



//finds the punong barangay in the database
$sql2 = "SELECT username, role FROM users WHERE role = 'captain'";
$sql2Result = $conn->query($sql2);

if($sql2Result->num_rows == 1){
    $row = $sql2Result->fetch_assoc();
    $chairman_username = $row['username'];
}

// Determine the root directory of your chroot environment

// Generate HTML content for the certificate
$html = '
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="pics/logo.png">
    <link rel="stylesheet" href="css/businessclearance.css">
</head>
<body>

<div class="mainHolder">

    <div class="heading">
        <div class="sub-heading">
            <img id="logo" src="pics/logo.png" alt="logo" srcset="">
            <h1>barangay 635<br><span id="zone">zone 64, district vi, manila</span></h1>
            <h2><span id="year">' . date ("Y") . '</span><br><span id="permit">permits and clearances</span></h2>
        </div>
    </div>

    <hr>

    
    <div class="serialnum">
        <p>Serial No. <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 123456789 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p>
    </div>

    
    <div class="container">
        <div class="title">
            <h1>barangay business clearance</h1>
        </div>

        <p id="certify">This is to certify that the business entity described below is hereby cleared to operate its business in this barangay and engage in the trade activity as described below.</p>

        <div class="vitalinfo">
            <h1>business entity information</h1>

            <p id="name"><span>Name of Business:</span><u>' . '&nbsp;&nbsp; ' . $certificate_result['business_name'] . '&nbsp;&nbsp;</u></p>
            <p id="businessAdd"><span>Business Address:</span><u>' . '&nbsp;&nbsp; ' . $certificate_result['business_address'] . '&nbsp;&nbsp; </u></p>
            <p id="nature"><span>Nature of Business:</span><u>' . '&nbsp;&nbsp; ' . $certificate_result['nature_business'] . '&nbsp;&nbsp; </u></p>

            <h1>proprietor(s) information</h1>

            <p id="proprietor"><span>Proprietor(s):</span><u>' . '&nbsp;&nbsp; ' . $certificate_result['proprietor'] . '&nbsp;&nbsp;</u></p>
            <p id="contact"><span>Contact Number:</span><u>' . '&nbsp;&nbsp; ' . $certificate_result['contact_number'] . '&nbsp;&nbsp; </u></p>
            <p id="ownership"><span>Ownership Type(s):</span><u>' . '&nbsp;&nbsp; ' . $certificate_result['ownership_type'] . '&nbsp;&nbsp; </u></p>
        </div>

        <div class ="ps">
            <p>This certification is being issued as mandated by Paragraph C, Section 152, Article IV of Republic Act 7160, otherwise known as the 1991 Local Government Code,
            for the purpose of securing business permit and/or license from the City of Manila for the year '.date("Y").'. </p>
        </div>

        <div class="note">
            <p>Issued on<b> ' . date("F j, Y") . '</b> at the City of Manila and is valid for one year from the date of issue.</p>
        </div>


        <div class="chairman">
            <h1>'.$chairman_username.'</h1>
            <p>Punong Barangay</p>
        </div>


        <div class="footer">
            <hr>
            <p>This document is VALID ONLY if signed by the Punong Barangay and imprinted with
            the Barangay dry seal.</p>
        </div>

    </div>
    
</div>

</body>
</html>
';

$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
try {
    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF (1 = download and 0 = preview)
    $dompdf->stream("certificate_of_residency.pdf", array("Attachment" => 0));
} catch (Exception $e) {
    die('Error rendering PDF: ' . $e->getMessage());
}

// Close the database connection
$conn->close();
?>
