<?php
function insertLog($conn, $log_entry) {
    $log_date = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO logs (log_entry, log_date) VALUES (?, ?)");
    $stmt->bind_param("ss", $log_entry, $log_date);
    $stmt->execute();
    $stmt->close();
}
?>
