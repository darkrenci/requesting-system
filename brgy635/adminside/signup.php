<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin Panel - Sign Up</title>
    <link rel="icon" href="pics/logo.jpg">
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
            <form method="post">
        
                <h2 class="text-center mt-3">Sign Up</h2><br>
        
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input class="border border-secondary" type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="captain">Captain</option>
                        <option value="kagawad">Kagawad</option>
                        <option value="secretary">Secretary</option>
                        <option value="SK">SK</option>
                        <option value="other official">Other Official</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="border border-secondary" type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input class="border border-secondary" type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="form-group">
                    <input id="btnSign" type="submit" value="Sign Up" name="signup-submit">
                </div>
                <p>Already have an account? <a href="signin.php">Sign In</a></p>
                <p id="errormsg">
                <?php
                    // Database connection
                    require_once 'connect.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup-submit'])) {
                        $username = $_POST['username'];
                        $role = $_POST['role'];
                        $password = $_POST['password'];
                        $confirmPassword = $_POST['confirm-password'];

                        // Validate input
                        if (empty($username) || empty($password) || empty($confirmPassword)) {
                            print "All fields are required.";
                        } elseif ($password != $confirmPassword) {
                            print "Passwords do not match.";
                        } else {
                            // Check if username already exists
                            $check_user_sql = "SELECT * FROM users WHERE username='$username'";
                            $check_user_result = $conn->query($check_user_sql);

                            // Check if there is already a captain in the database
                            if ($role === 'captain') {
                                $check_captain_sql = "SELECT * FROM users WHERE role='captain'";
                                $check_captain_result = $conn->query($check_captain_sql);

                                if ($check_captain_result->num_rows > 0) {
                                    print "A captain is already registered. Please choose a different role.";
                                    exit; 
                                }
                            }

                            // If username exists
                            if ($check_user_result->num_rows > 0) {
                                print "Username already exists. Please choose a different username.";
                            } else {
                                // Hash password for security
                                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                                // Insert user into database
                                $insert_user_sql = "INSERT INTO users (username, role, password) VALUES ('$username', '$role', '$hashedPassword')";
                                if ($conn->query($insert_user_sql) === TRUE) {
                                    print "Signup successful!";
                                    header('Location: signin.php');
                                } else {
                                    print "Error: " . $insert_user_sql . "<br>" . $conn->error;
                                }
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
