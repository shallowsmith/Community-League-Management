<?php
session_start();
require_once '../src/config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Delete event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scheduleID = $_POST['scheduleID'];

    $stmt = $connection->prepare("DELETE FROM Schedule WHERE ScheduleID = ?");
    $stmt->bind_param("i", $scheduleID);
    
    if ($stmt->execute()) {
        echo "Event deleted successfully.";
    } else {
        echo "Error deleting event: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}

header("Location: ../public_html/eventList.php");
exit();
?>
