<?php
require_once 'config/registration.php';

$query = "SELECT Name FROM Team";
$result = $connection->query($query);

// Store query results in an array
$teams = array();

if ($result->num_rows > 0) {
    // Loop through query results and push to $teams array
    while($row = $result->fetch_assoc()) {
        array_push($teams, $row['Name']);
    }
    // Send $teams array as JSON response
    echo json_encode($teams);
} else {
    echo json_encode([]);
}

$connection->close();
?>