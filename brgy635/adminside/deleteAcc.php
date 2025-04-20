<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="css/admin.css"> -->
    <link rel="stylesheet" href="css/newAdmin.css">
    <link rel="icon" href="pics/logo.jpg">

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-VhAtZjHpP6X+C56q6lye9V3G6Xc1cf+5kHYB5Bv1qIhjmJw2+A0Gr9dPplT+RiE/" crossorigin="anonymous">
</head>
<body >


<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delConfirm'])) {
    // Treat form data as arrays
    $usernames = isset($_POST['username']) ? $_POST['username'] : [];
    $passwords = isset($_POST['password']) ? $_POST['password'] : [];

    // Check if exactly 3 accounts were provided
    if (count($usernames) === 3 && count($passwords) === 3) {
        // Check for unique usernames
        if (count(array_unique($usernames)) !== 3) {
            echo "<div class='msgResponse'><p>Please ensure all usernames are unique.</p></div>";
        } else {
            $allMatched = true; // Flag to check if all accounts match

            // Check each username and password
            for ($i = 0; $i < 3; $i++) {
                $username = $usernames[$i];
                $password = $passwords[$i];

                // Query to find the user
                $query = "SELECT * FROM users WHERE username = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Verify the password
                    if (!password_verify($password, $row['password'])) {
                        $allMatched = false;
                        break;
                    }
                } else {
                    $allMatched = false;
                    break;
                }

                $stmt->close();
            }

            // If all accounts match, delete all accounts in the database
            if ($allMatched) {
                $deleteQuery = "DELETE FROM users";
                if ($conn->query($deleteQuery) === TRUE) {
                    echo "<div class='msgResponse'><p>All accounts have been deleted.</p></div>";
                    
                } else {
                    echo "<div class='msgResponse'><p>Error deleting accounts: </p></div>" . $conn->error;
                }
            } else {
                echo "<div class='msgResponse'><p>Information does not match.</p></div>";
            }
        }
    } else {
        echo "<div class='msgResponse'><p>Please provide exactly 3 accounts.</p></div>";
    }
}

$conn->close();
?>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>