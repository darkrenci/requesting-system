<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay 635</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php
session_start();
require_once 'connect.php';

$redirectUrl = "index.php";
$redirectTime = 3; // Countdown time in seconds

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Do not escape password as it will be used in password_verify

    // SQL query to check if user exists
    $sql = "SELECT id, password FROM resident WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Store user ID in session
            $_SESSION['user_id'] = $row['id'];
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            echo '<h1 class="invalidLoginMsg">Invalid email or password</h1>';
            echo '<p class="returningCountdown">Returning to the first page in <span id="countdown">' . $redirectTime . '</span> seconds.</p>';
        }
    } else {
        // Email does not exist
        echo '<h1 class="invalidLoginMsg">Invalid email or password</h1>';
        echo '<p class="returningCountdown">Returning to the first page in <span id="countdown">' . $redirectTime . '</span> seconds.</p>';
    }

    $stmt->close();
}

$conn->close();
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
    setInterval(updateCountdown, 1000);
</script>

</body>
</html>
