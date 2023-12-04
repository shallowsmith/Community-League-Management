<?php
require_once '../src/config/database.php';

// Insert new coach record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamID = $_POST['teamID'] ?? null;
    $coachName = $_POST['coachName'] ?? '';
    
    $teamID = filter_var($teamID, FILTER_SANITIZE_NUMBER_INT);
    $coachName = filter_var($coachName, FILTER_SANITIZE_STRING);


    $stmt = $connection->prepare("INSERT INTO Coach (Name, TeamID) VALUES (?, ?)");
    $stmt->bind_param("si", $coachName, $teamID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Coach added successfully.";
    } else {
        echo "Error adding coach.";
    }

    $stmt->close();
    $connection->close();
}

header("Location: playerlist.php");
?>