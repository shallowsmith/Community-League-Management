<?php
require_once 'config/registration.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $connection->real_escape_string($_POST['username']);
    $password = $_POST['password']; 
    $userType = $connection->real_escape_string($_POST['user-type']);

    // Prepare SQL statement to retrieve user data
    $stmt = $connection->prepare("SELECT Password FROM Users WHERE Username = ? AND Role = ?");
    $stmt->bind_param("ss", $username, $userType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // Password is correct, start a session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $userType;
            
            // Redirect based on user role
            switch ($userType) {
                case 'admin':
                    header("Location: ../public_html/teamList.html");
                    break;
                case 'team':
                    header("Location: ../public_html/playerList.html");
                    break;
                case 'player':
                    header("Location: ../public_html/player.html");
                    break;
                default:
                    echo "Invalid user role.";
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$connection->close();
?>