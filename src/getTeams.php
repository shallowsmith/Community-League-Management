<?php
require_once 'config/database.php';

// Get all teams and their players and coaches and return a json array of teams
$query = "SELECT 
            Team.TeamID, 
            Team.Name AS TeamName, 
            COUNT(CASE WHEN Player.Position = 'Catcher' THEN 1 END) AS Catchers,
            COUNT(CASE WHEN Player.Position = 'Pitcher' THEN 1 END) AS Pitchers,
            COUNT(CASE WHEN Player.Position = 'Infield' THEN 1 END) AS Infield,
            COUNT(CASE WHEN Player.Position = 'Outfield' THEN 1 END) AS Outfield,
            Coach.Name AS CoachName
          FROM Team 
          LEFT JOIN Player ON Team.TeamID = Player.TeamID
          LEFT JOIN Coach ON Team.TeamID = Coach.TeamID
          GROUP BY Team.TeamID";

$result = $connection->query($query);

$teams = [];

// Build an array of teams
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teams[] = [
            "id" => $row['TeamID'],
            "name" => $row['TeamName'],
            "catchers" => $row['Catchers'],
            "pitchers" => $row['Pitchers'],
            "infield" => $row['Infield'],
            "outfield" => $row['Outfield'],
            "coach" => $row['CoachName']
        ];
    }
    // Return the array as a json string
    echo json_encode($teams);
} else {
    echo json_encode([]);
}

$connection->close();

?>