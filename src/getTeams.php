<?php
require_once 'config/database.php';

$query = "SELECT Team.TeamID, Team.Name AS TeamName, GROUP_CONCAT(Player.Name ORDER BY Player.Name ASC SEPARATOR ', ') AS Players 
          FROM Team 
          LEFT JOIN Player ON Team.TeamID = Player.TeamID 
          GROUP BY Team.TeamID";
$result = $connection->query($query);

// Store query results in an array

$teams = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($teams, array(
            "id" => $row['TeamID'], 
            "name" => $row['TeamName'],
            "players" => $row['Players'] ? $row['Players'] : "No players"
        ));
    }
    echo json_encode($teams);
} else {
    echo json_encode([]);
}

$connection->close();
?>