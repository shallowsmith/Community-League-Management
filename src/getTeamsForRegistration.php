<?php
require_once 'config/database.php'; 

$query = "SELECT TeamID, Name FROM Team";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    echo "<option value=''>Select a Team</option>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['TeamID'] . "'>" . htmlspecialchars($row['Name']) . "</option>";
    }
} else {
    echo "<option value=''>No teams available</option>";
}

$connection->close();
?>
