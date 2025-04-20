<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin Panel - Sign In</title>
    <link rel="icon" href="pics/logo.png">
    <link rel="stylesheet" href="css/forms.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

    <div class="wrapper">
        
        <div class="side text-center">
            <h2>Barangay 635</h2>
            <h4>Security Log-in</h4>
        </div>


        <div class="container">
            <form class="" method="post">

                <h2 class="text-center mt-3">Sign In</h2><br>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input class="border border-secondary" type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="border border-secondary" type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input class="" id="btnSign"  type="submit" value="Sign In" name="signin-submit">
                </div>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            
                <p id="errormsg">

                    <?php
                    session_start(); // Start the session

                    // Database connection
                    require_once 'connect.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin-submit'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        

                        // Validate input
                        if (empty($username) || empty($password)) {
                            echo "Username and password are required.";
                        } else {
                            // Check if username exists
                            $sql = "SELECT * FROM users WHERE username='$username'";
                            $result = $conn->query($sql);

                            if ($result->num_rows == 1) {
                                // Verify password
                                $row = $result->fetch_assoc();
                                if (password_verify($password, $row['password'])) {
                                    // Set session variable to indicate admin is logged in
                                    $_SESSION['admin'] = true;
                                    $_SESSION['role'] = $row['role']; // Store the user's role in the session
                                    
                                    $_SESSION['username'] = $username;
                                    // Redirect based on role
                                    $role = $row['role'];
                                    if ($role == 'captain') {
                                        header('Location: newAdmin.php');
                                    } elseif ($role == 'kagawad') {
                                        header('Location: kagawad.php');
                                    } elseif ($role == 'secretary') {
                                        header('Location: secretary.php');
                                    } elseif ($role == 'SK') {
                                        header('Location: sk.php');
                                    } elseif ($role == 'other official') {
                                        header('Location: otherOfficial.php');
                                    } else {
                                        echo "Invalid role.";
                                    }
                                    exit(); // Terminate script execution after redirection
                                } else {
                                    echo "Invalid password.";
                                }
                            } else {
                                echo "User not found.";
                            }
                        }
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </p>
            </form>
        </div>

    </div>
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
