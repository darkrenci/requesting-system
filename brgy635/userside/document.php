<?php
session_start(); 
include 'connect.php';


// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_id = $_POST['form_id'];
    $user_id = $_SESSION['user_id'];

    switch ($form_id) {
        case 'barangay-form':
            $req_name = filter_var($_POST['req-name'], FILTER_SANITIZE_STRING);
            $postal_address = filter_var($_POST['postal-address'], FILTER_SANITIZE_STRING);
            $marital_status = filter_var($_POST['marital-status'], FILTER_SANITIZE_STRING);
            $citizenship = filter_var($_POST['citizenship'], FILTER_SANITIZE_STRING);
            $purpose = filter_var($_POST['purpose'], FILTER_SANITIZE_STRING);
          
            $sql = "INSERT INTO barangay_clearance (req_name, postal_address, marital_status, citizenship, purpose, resident_id) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $req_name, $postal_address, $marital_status, $citizenship, $purpose, $user_id);
            break;

        case 'business-form':
            $business_name = $_POST['business-name'];
            $business_address = $_POST['business-address'];
            $nature_business = $_POST['nature-business'];
            $proprietor = $_POST['proprietor'];
            $contact_number = $_POST['contact-number'];
            $ownership_type = $_POST['ownership-type'];

            $sql = "INSERT INTO business_clearance (business_name, business_address, nature_business, proprietor, contact_number, ownership_type, resident_id) VALUES (?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $business_name, $business_address, $nature_business, $proprietor, $contact_number, $ownership_type, $user_id);
            break;

        case 'indigency-form':
            $req_name_indigency = $_POST['req-name-indigency'];
            $postal_address_indigency = $_POST['postal-address-indigency'];
            $purpose_indigency = $_POST['purpose-indigency'];

            $sql = "INSERT INTO certificate_of_indigency (req_name_indigency, postal_address_indigency, purpose_indigency, resident_id) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $req_name_indigency, $postal_address_indigency, $purpose_indigency, $user_id);
            break;

        case 'residency-form':
            $req_name_residency = $_POST['req-name-residency'];
            $postal_address_residency = $_POST['postal-address-residency'];
            $purpose_residency = $_POST['purpose-residency'];

            $sql = "INSERT INTO certificate_of_residency (req_name_residency, postal_address_residency, purpose_residency, resident_id) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $req_name_residency, $postal_address_residency, $purpose_residency, $user_id);
            break;
    }

    // Execute the query
    if ($stmt->execute()) {
        header("Location: dashboard.php");
      } else {
        echo "Error: ". $sql. "<br>". $conn->error;
      }
    }
?>