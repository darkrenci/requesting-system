<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 635</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>


<?php
session_start();
require_once 'connect.php';

$redirectUrl = "index.php";
$redirectTime = 3; // Countdown time in seconds

if ($_SERVER["REQUEST_METHOD"]) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $marital_status = $_POST['options'];
    $gender = $_POST['gender'];
    $hnum = $_POST['hnum'];
    $street = $_POST['street'];
    $others = $_POST['others'];

    $sql = "SELECT * FROM resident WHERE email = '$email' OR phone = '$phone'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        echo "<p class='invalidLoginMsg'>Email or Phone already exists</p>";
        echo '<p class="returningCountdown">Returning to the first page in <span id="countdown">' . $redirectTime . '</span> seconds.</p>';
    }else{
        // SQL query to insert data into table
        $sql2 = "INSERT INTO resident (fname, lname, mname, email, phone, birthday, password, marital_status, gender, hnum, street, others)
        VALUES ('$fname', '$lname', '$mname', '$email', '$phone', '$birthday', '$hashed_password', '$marital_status', '$gender', '$hnum', '$street', '$others')";
        $insert = $conn->query($sql2);
        echo "<p class='text-center'>Sign up Successful, Log In to the page</p>";
        echo '<p class="returningCountdown">Returning to the first page in <span id="countdown">' . $redirectTime . '</span> seconds.</p>';
    }


}

?>
<script>
    let countdown = <?php echo $redirectTime; ?>; // Get the countdown time from PHP

    function updateCountdown() {
        const countdownElement = document.getElementById("countdown");
        countdownElement.textContent = countdown; // Update the countdown display
        countdown--;

        if (countdown < 0) {
            window.location.href = "<?php echo $redirectUrl; ?>"; // Redirect when countdown ends
        }
    }

    // Update the countdown every second
    setInterval(updateCountdown, 800);
</script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
