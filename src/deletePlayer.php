<?php
require_once 'config/database.php';

// Delete player record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerID = $_POST['playerID']; 

    $stmt = $connection->prepare("DELETE FROM Player WHERE PlayerID = ?");
    $stmt->bind_param("i", $playerID);

    if ($stmt->execute()) {
        header("Location: ../public_html/playerList.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>
