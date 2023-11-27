<?php
require_once 'config/database.php';

$query = "SELECT TeamID, Name FROM Team";
$result = $connection->query($query);

// Store query results in an array
$teams = array();

$teams = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($teams, array("id" => $row['TeamID'], "name" => $row['Name']));
    }
    echo json_encode($teams);
} else {
    echo json_encode([]);
}

$connection->close();
?>