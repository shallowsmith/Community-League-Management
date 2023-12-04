<?php
session_start();
require_once '../src/config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Insert new event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameDate = $_POST['gameDate'];
    $gameTime = $_POST['gameTime'];
    $locationID = $_POST['locationID'];
    $homeTeamID = $_POST['homeTeamID'];
    $awayTeamID = $_POST['awayTeamID'];

    // Ensure that the home and away teams are not the same
    if ($homeTeamID === $awayTeamID) {
        echo "Home and Away teams cannot be the same.";
        exit();
    }

    $stmt = $connection->prepare("INSERT INTO Schedule (GameDate, GameTime, LocationID, HomeTeamID, AwayTeamID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $gameDate, $gameTime, $locationID, $homeTeamID, $awayTeamID);
    
    if ($stmt->execute()) {
        echo "Event added successfully.";
    } else {
        echo "Error adding event: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}

header("Location: ../public_html/eventList.php");
exit();
?>
