<?php
session_start();
require_once '../src/config/database.php';

// Fetch teams and locations
$teamQuery = "SELECT TeamID, Name FROM Team";
$teamResult = $connection->query($teamQuery);
$teams = [];
while ($row = $teamResult->fetch_assoc()) {
    $teams[] = $row;
}

$locationQuery = "SELECT LocationID, CityName FROM Location";
$locationResult = $connection->query($locationQuery);
$locations = [];
while ($row = $locationResult->fetch_assoc()) {
    $locations[] = $row;
}

// Fetch events
$eventQuery = "SELECT ScheduleID, GameDate, GameTime, L.CityName, HT.Name AS HomeTeam, AT.Name AS AwayTeam
               FROM Schedule
               JOIN Team HT ON Schedule.HomeTeamID = HT.TeamID
               JOIN Team AT ON Schedule.AwayTeamID = AT.TeamID
               JOIN Location L ON Schedule.LocationID = L.LocationID";
$eventResult = $connection->query($eventQuery);
$events = [];
while ($row = $eventResult->fetch_assoc()) {
    $events[] = $row;
}

$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>
    <link rel="stylesheet" href="css/eventList-style.css">
</head>
<body>
    <h1>Event List</h1>
    <form action="../src/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="teamList.html" class="button-link">View Team List</a>
    </div>

    <h2>Add Event</h2>
    <form action="../src/addEvent.php" method="post">
        <label>Date: <input type="date" name="gameDate" required></label>
        <label>Time: <input type="time" name="gameTime" required></label>
        <label>Location: 
            <select name="locationID" required>
                <?php foreach ($locations as $location): ?>
                    <option value="<?= $location['LocationID'] ?>"><?= $location['CityName'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Home Team: 
            <select name="homeTeamID" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team['TeamID'] ?>"><?= $team['Name'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Away Team: 
            <select name="awayTeamID" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team['TeamID'] ?>"><?= $team['Name'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Add Event</button>
    </form>

    <h2>Current Events</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Home Team</th>
            <th>Away Team</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= $event['GameDate'] ?></td>
                <td><?= $event['GameTime'] ?></td>
                <td><?= $event['CityName'] ?></td>
                <td><?= $event['HomeTeam'] ?></td>
                <td><?= $event['AwayTeam'] ?></td>
                <td>
                    <form action="../src/deleteEvent.php" method="post">
                        <input type="hidden" name="scheduleID" value="<?= $event['ScheduleID'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
