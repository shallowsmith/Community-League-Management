<?php
require_once 'config/database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['teamName'])) {
    $teamName = $connection->real_escape_string($_POST['teamName']);

    // Prepare SQL statement to insert new team
    $stmt = $connection->prepare("INSERT INTO Team (Name) VALUES (?)");
    $stmt->bind_param("s", $teamName);
    if ($stmt->execute()) {
        echo "New team added successfully.";
        header("Location: ../public_html/teamList.html"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$connection->close();
?>