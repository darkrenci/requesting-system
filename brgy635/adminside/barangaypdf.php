<?php
session_start();

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

$sql = "SELECT req_name, postal_address, marital_status, citizenship, purpose FROM barangay_clearance WHERE resident_id =?";
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
        die("Error executing query: ". $stmt->error);
    }
    $stmt->close();
} else {
    die("Error preparing query: ". $conn->error);
}



//finds the punong barangay in the database
$sql2 = "SELECT username, role FROM users WHERE role = 'captain'";
$sql2Result = $conn->query($sql2);

if($sql2Result->num_rows == 1){
    $row = $sql2Result->fetch_assoc();
    $chairman_username = $row['username'];
}

$serialNumber = $_SESSION['serialNumber'];

// Determine the root directory of your chroot environment

// Generate HTML content for the certificate
$html = '
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="pics/logo.png">
    <link rel="stylesheet" href="css/barangayclearance.css">
    
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
            <p>Serial No. <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '. $serialNumber .' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p>
        </div>


        <div class="container">
            <div class="title">
                <h1>barangay clearance</h1>
            </div>

            <p id="certify">This is to certify that the below indicated person is bona fide resident of this barangay. Further, I certify that he/she is found to have <b>NO DEROGATORY RECORD</b> in our Barangay.</p>

            <div class="vitalinfo2">
                
                <p id="name"><span>Requestor\'s Name:</span><u>' .'&nbsp;&nbsp; ' . strtoupper($certificate_result['req_name']) . '&nbsp;&nbsp;</u></p>
                <p id="postalAdd"><span>Postal Address:</span> <u>' .'&nbsp;&nbsp; ' . strtoupper($certificate_result['postal_address']) . '&nbsp;&nbsp;</u></p>
                <p id="marital"><span>Marital Status:</span> <u>' .'&nbsp;&nbsp; ' . strtoupper($certificate_result['marital_status']) . '&nbsp;&nbsp;</u></p>
                <p id="citizenship"><span>Citizenship:</span> <u>' .'&nbsp;&nbsp; '. strtoupper($certificate_result['citizenship']) . '&nbsp;&nbsp;</u></p>
            </div>

            <div class ="ps">
                <p>This certification is being issued upon the request of the aforementioned individual for the purpose below:</p>
            </div>

            <div class="vitalinfo">
                <p id="purpose"><span>Purpose:</span> <u>' .'&nbsp;&nbsp; ' . strtoupper($certificate_result['purpose']) . '&nbsp;&nbsp;&nbsp;&nbsp;</u></p>
            </div>

            <div class="note">
                <p>This certificate is issued on <b>' . date("F j, Y") . '</b> at Barangay 635, Zone 64, District VI, City of Manila, Philippines.</p>
                <p id="moreover">Moreover, this certificate is<b> VALID</b> only for <b> 3 MONTHS FROM THE DATE ISSUED.</b></p>
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
