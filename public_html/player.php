<?php
session_start();
require_once '../src/config/database.php'; // This path may differ based on your actual file structure.

// Make sure a user is logged in, otherwise redirect.
if (!isset($_SESSION['player_id'])) {
    header('Location: login.html');
    exit();
}

$playerID = $_SESSION['player_id'];

// Retrieve player and team information
$query = "SELECT Player.Name, Player.Number, Team.Name AS TeamName 
          FROM Player 
          JOIN Team ON Player.TeamID = Team.TeamID 
          WHERE Player.PlayerID = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $playerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $playerInfo = $result->fetch_assoc();
} else {
    echo "Player not found.";
    exit();
}

// Check if the player has chosen to quit the team
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quit'])) {
    $deleteQuery = "DELETE FROM Player WHERE PlayerID = ?";
    $deleteStmt = $connection->prepare($deleteQuery);
    $deleteStmt->bind_param('i', $playerID);
    $deleteStmt->execute();

    if ($deleteStmt->affected_rows > 0) {
        echo "You have successfully quit the team.";
        session_destroy(); // Or unset the player session variables.
        header('Location: login.php');
        exit();
    } else {
        echo "Error quitting the team.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Page</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($playerInfo['Name']); ?></h1>
    <p>You are in team: <?php echo htmlspecialchars($playerInfo['TeamName']); ?></p>
    <p>Your number: <?php echo htmlspecialchars($playerInfo['Number']); ?></p>
    
    <!-- Quit team form -->
    <form method="post">
        <input type="hidden" name="quit" value="1">
        <button type="submit">Quit Team</button>
    </form>
</body>
</html>