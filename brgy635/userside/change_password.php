<?php
session_start();
include 'connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];

    // Assume you have a user ID stored in the session
    $userId = $_SESSION['user_id'];

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT password FROM resident WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($dbPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (password_verify($currentPassword, $dbPassword)) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateStmt = $conn->prepare("UPDATE resident SET password = ? WHERE id = ?");
        $updateStmt->bind_param('si', $hashedPassword, $userId);
        if ($updateStmt->execute()) {
            echo "Password changed successfully.";
        } else {
            echo "Error updating password.";
        }
        $updateStmt->close();
    } else {
        echo "Current password is incorrect.";
    }
}
?>
