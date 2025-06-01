<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a user ID stored in a session
    if (!isset($_SESSION['user_id'])) {
        echo "User is not logged in.";
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Collect POST data and sanitize it
    $fname = htmlspecialchars($_POST['fname']);
    $mname = htmlspecialchars($_POST['mname']);
    $lname = htmlspecialchars($_POST['lname']);
    $birthday = htmlspecialchars($_POST['birthday']);
    $gender = htmlspecialchars($_POST['gender']);
    $citizen = htmlspecialchars($_POST['citizen']);
    $hnum = htmlspecialchars($_POST['hnum']);
    $street = htmlspecialchars($_POST['street']);
    $others = htmlspecialchars($_POST['others']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    // Prepare SQL update statement for user information
    $sql = "UPDATE resident SET fname = ?, mname = ?, lname = ?, birthday = ?, gender = ?, citizen = ?, hnum = ?, street = ?, others = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $fname, $mname, $lname, $birthday, $gender, $citizen, $hnum, $street, $others, $email, $phone, $user_id);

    if ($stmt->execute()) {
        echo "Profile updated successfully.<br>";
    } else {
        echo "Error updating profile: " . $conn->error . "<br>";
    }

    $stmt->close();

    // Check if the user wants to change the password
    if (!empty($_POST['current-password']) && !empty($_POST['new-password']) && !empty($_POST['confirm-new-password'])) {
        $current_password = htmlspecialchars($_POST['current-password']);
        $new_password = htmlspecialchars($_POST['new-password']);
        $confirm_new_password = htmlspecialchars($_POST['confirm-new-password']);

        if ($new_password === $confirm_new_password) {
            // Validate current password
            $sql = "SELECT password FROM resident WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($stored_password);
            $stmt->fetch();
            $stmt->close();

            // Verify the current password
            if ($current_password === $stored_password) {
                // Update password
                $sql = "UPDATE resident SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $new_password, $user_id);

                if ($stmt->execute()) {
                    echo "Password changed successfully.";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "New passwords do not match.";
        }
    }

    $conn->close();
}
?>
