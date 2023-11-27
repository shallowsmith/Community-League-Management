<?php
require_once 'config/database.php'; 

// Function to sanitize user input
function sanitizeInput($data) {
    global $connection;
    return $connection->real_escape_string(htmlspecialchars(stripslashes(trim($data))));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    $userType = sanitizeInput($_POST['user_type']);

    // Handle TeamID, set to NULL if not provided or if userType is not 'team'
    $teamID = (isset($_POST['TeamID']) && $userType === 'team') ? (int)$_POST['TeamID'] : NULL;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $stmt = $connection->prepare("SELECT * FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Username does not exist, proceed with registration
        $query = "INSERT INTO Users (Username, Password, Role, TeamID) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssi", $username, $hashed_password, $userType, $teamID);

        if ($stmt->execute()) {
            echo "Registration successful. <a href='../public_html/login.html'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$connection->close();
?>