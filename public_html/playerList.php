<?php
session_start();
require_once '../src/config/database.php'; // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); 
    exit();
}

$username = $_SESSION['username'];
$teamID = NULL;

// Fetch the user's team ID from the database
$stmt = $connection->prepare("SELECT TeamID FROM Users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teamID = $row['TeamID'];
}

if ($teamID === NULL) {
    echo "No team assigned or you're not a team member. <a href='../src/logout.php'> Logout</a>";
    exit(); 
}

$teamName = '';
if ($teamID !== NULL) {
    // Query to fetch team name
    $teamQuery = "SELECT Name FROM Team WHERE TeamID = ?";
    $teamStmt = $connection->prepare($teamQuery);
    $teamStmt->bind_param("i", $teamID);
    $teamStmt->execute();
    $teamResult = $teamStmt->get_result();

    if ($teamResult->num_rows > 0) {
        $teamRow = $teamResult->fetch_assoc();
        $teamName = $teamRow['Name'];
    }

    $teamStmt->close();
}

// Query to fetch team roster
$query = "SELECT PlayerID, Name, Position FROM Player WHERE TeamID = ?"; 
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $teamID);
$stmt->execute();
$result = $stmt->get_result();

$players = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($players, $row);
    }
} else {

}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player List</title>
    <link rel="stylesheet" href="css/teamList-style.css">
</head>
<body>
    <h1>Team Roster for <?php echo htmlspecialchars($teamName); ?></h1>

    <!-- Logout Button -->
    <form action="../src/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    
    <?php if (count($players) > 0): ?>
        <ul>
        <?php foreach ($players as $player): ?>
            <?php echo htmlspecialchars($player['Name']); ?> - <?php echo htmlspecialchars($player['Position']); ?>
            <form action="deletePlayer.php" method="post">
                <input type="hidden" name="playerID" value="<?php echo isset($player['PlayerID']) ? $player['PlayerID'] : ''; ?>">
                <button type="submit">Delete</button>
            </form>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No players found in your team.</p>
    <?php endif; ?>
    
    <form action="addPlayer.php" method="post">
        <input type="hidden" name="teamID" value="<?php echo $teamID; ?>">
        <input type="text" name="playerName" placeholder="Player Name" required>
        <input type="text" name="position" placeholder="Position" required>
        <button type="submit">Add Player</button>
    </form>

</body>
</html>
