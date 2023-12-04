<?php
require_once '../src/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coachID = $_POST['coachID'] ?? null;

    // Sanitize input
    $coachID = filter_var($coachID, FILTER_SANITIZE_NUMBER_INT);

    // Delete coach record
    $stmt = $connection->prepare("DELETE FROM Coach WHERE CoachID = ?");
    $stmt->bind_param("i", $coachID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Coach removed successfully.";
    } else {
        echo "Error removing coach.";
    }

    $stmt->close();
    $connection->close();
}

header("Location: playerlist.php"); 
?>