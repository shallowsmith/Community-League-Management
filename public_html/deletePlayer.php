<?php
require_once '../src/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerID = $_POST['playerID']; // Add sanitization

    $stmt = $connection->prepare("DELETE FROM Player WHERE PlayerID = ?");
    $stmt->bind_param("i", $playerID);

    if ($stmt->execute()) {
        header("Location: playerList.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>
