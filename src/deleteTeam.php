<?php
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teamID'])) {
    $teamID = $connection->real_escape_string($_POST['teamID']);

    $stmt = $connection->prepare("DELETE FROM Team WHERE TeamID = ?");
    $stmt->bind_param("i", $teamID);
    if ($stmt->execute()) {
        echo "Team deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>