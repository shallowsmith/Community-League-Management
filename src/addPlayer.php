<?php
require_once '../src/config/database.php';

// Insert new player record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamID = $_POST['teamID'];
    $playerName = $_POST['playerName'];
    $playerNumber = $_POST['playerNumber'];  
    $position = $_POST['position']; 

    $stmt = $connection->prepare("INSERT INTO Player (Name, Number, Position, TeamID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", $playerName, $playerNumber, $position, $teamID);

    if ($stmt->execute()) {
        header("Location: ../public_html/playerList.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>
