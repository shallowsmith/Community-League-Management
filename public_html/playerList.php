<?php
session_start();
require_once '../src/config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$teamID = null;

$stmt = $connection->prepare("SELECT TeamID FROM Users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teamID = $row['TeamID'];
} else {
    echo "User not found. <a href='../src/logout.php'>Logout</a>";
    exit();
}

$teamName = '';
if ($teamID !== null) {
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

$query = "SELECT PlayerID, Name, Number, Position FROM Player WHERE TeamID = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $teamID);
$stmt->execute();
$result = $stmt->get_result();

$playersByPosition = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $playersByPosition[$row['Position']][] = $row;
    }
}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player List</title>
    <link rel="stylesheet" href="css/playerList-style.css">
</head>
<body>
    <h1>Team Roster for <?php echo htmlspecialchars($teamName); ?></h1>

    <form action="../src/logout.php" method="post">
        <button type="submit">Logout</button>
    </form>

    <?php if (!empty($playersByPosition)): ?>
        <?php foreach ($playersByPosition as $position => $players): ?>
            <div class="position-container">
            <h2><?php echo htmlspecialchars($position); ?></h2>
            <table>
                <tr>
                    <th>Player Name</th>
                    <th>No.</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($player['Name']); ?></td>
                        <td><?php echo htmlspecialchars($player['Number']); ?></td>
                        <td>
                            <form action="deletePlayer.php" method="post">
                                <input type="hidden" name="playerID" value="<?php echo $player['PlayerID']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No players found in your team.</p>
    <?php endif; ?>

    <form action="addPlayer.php" method="post">
        <input type="hidden" name="teamID" value="<?php echo $teamID; ?>">
        <input type="text" name="playerName" placeholder="Player Name" required>
        <input type="number" name="playerNumber" placeholder="Player Number" required>
        <select name="position" required>
            <option value="">Select Position</option>
            <option value="Catcher">Catcher</option>
            <option value="Pitcher">Pitcher</option>
            <option value="Infield">Infield</option>
            <option value="Outfield">Outfield</option>
        </select>
        <button type="submit">Add Player</button>
    </form>

</body>
</html>


