<?php
session_start();
require_once '../src/config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

// Fetch the team ID associated with the user
$teamIDQuery = $connection->prepare("SELECT TeamID FROM Users WHERE Username = ?");
$teamIDQuery->bind_param("s", $username);
$teamIDQuery->execute();
$teamIDResult = $teamIDQuery->get_result();

if ($teamIDRow = $teamIDResult->fetch_assoc()) {
    $teamID = $teamIDRow['TeamID'];
} else {
    echo "No team associated with the user. <a href='../src/logout.php'>Logout</a>";
    exit();
}

// Fetch events associated with the team
$query = "SELECT Schedule.ScheduleID, Schedule.GameDate, Schedule.GameTime, 
          Location.CityName AS Location, 
          TeamHome.Name AS HomeTeam, TeamAway.Name AS AwayTeam
          FROM Schedule
          JOIN Team AS TeamHome ON Schedule.HomeTeamID = TeamHome.TeamID
          JOIN Team AS TeamAway ON Schedule.AwayTeamID = TeamAway.TeamID
          LEFT JOIN Location ON Schedule.LocationID = Location.LocationID
          WHERE Schedule.HomeTeamID = ? OR Schedule.AwayTeamID = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ii", $teamID, $teamID);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event List View</title>
    <link rel="stylesheet" href="css/eventList-style.css">
</head>
<body>
    <h1>Team Events</h1>
    <form action="../src/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="playerList.php" class="button-link">View Player List</a>
    </div>

    <?php if (!empty($events)): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Home Team</th>
                <th>Away Team</th>
            </tr>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['GameDate']) ?></td>
                    <td><?= htmlspecialchars($event['GameTime']) ?></td>
                    <td><?= htmlspecialchars($event['Location']) ?></td>
                    <td><?= htmlspecialchars($event['HomeTeam']) ?></td>
                    <td><?= htmlspecialchars($event['AwayTeam']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center">No events found for your team.</p>
    <?php endif; ?>
</body>
</html>
