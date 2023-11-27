<?php
require_once '../src/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamID = $_POST['teamID'];
    $playerName = $_POST['playerName']; // Add sanitization
    $position = $_POST['position']; // Add sanitization

    $stmt = $connection->prepare("INSERT INTO Player (Name, Position, TeamID) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $playerName, $position, $teamID);

    if ($stmt->execute()) {
        header("Location: playerList.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>
