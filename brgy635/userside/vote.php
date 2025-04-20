<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $option_id = $_POST['option_id'];
    $user_id = $_POST['user_id'];

    // Check if user already voted on this poll
    $poll_check = $conn->query("
        SELECT o.poll_id FROM options o WHERE o.id = $option_id
    ");
    $poll = $poll_check->fetch_assoc();
    $poll_id = $poll['poll_id'];

    $check = $conn->query("
        SELECT v.id FROM votes v 
        JOIN options o ON v.option_id = o.id 
        WHERE v.user_id = $user_id AND o.poll_id = $poll_id
    ");

    if ($check->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO votes (option_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $option_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: dashboard.php");
    exit;
}
?>
