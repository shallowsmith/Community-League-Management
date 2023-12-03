<?php
require_once 'config/database.php';

$query = "SELECT Team.TeamID, Team.Name AS TeamName, 
          COUNT(CASE WHEN Player.Position = 'Catcher' THEN 1 END) AS Catchers,
          COUNT(CASE WHEN Player.Position = 'Pitcher' THEN 1 END) AS Pitchers,
          COUNT(CASE WHEN Player.Position = 'Infield' THEN 1 END) AS Infield,
          COUNT(CASE WHEN Player.Position = 'Outfield' THEN 1 END) AS Outfield
          FROM Team 
          LEFT JOIN Player ON Team.TeamID = Player.TeamID 
          GROUP BY Team.TeamID";

$result = $connection->query($query);

$teams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teams[] = [
            "id" => $row['TeamID'],
            "name" => $row['TeamName'],
            "catchers" => $row['Catchers'],
            "pitchers" => $row['Pitchers'],
            "infield" => $row['Infield'],
            "outfield" => $row['Outfield']
        ];
    }
    echo json_encode($teams);
} else {
    echo json_encode([]);
}

$connection->close();

?>